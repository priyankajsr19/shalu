<?php


class AmazonFeeder {
    protected $db;
    protected $mws_config;
    protected $config;
    public function __construct() {
        $this->db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $this->mws_config = MarketplaceWebService_Config::getConfig();
        $this->config = array (
                            'ServiceURL' => $this->mws_config['url'],
                            'ProxyHost' => null,
                            'ProxyPort' => -1,
                            'MaxErrorRetry' => 3,
                        );

    }

    public function submitPendingFeeds($id_feedtype) {
        $sql = "select f.id_feed, sf.id_subfeed, ft.feed_name, ft.code, sf.feed_file from ps_affiliate_feed f inner join ps_affiliate_subfeed sf on f.id_feed = sf.id_feed and f.id_status in (".MarketplaceWebService_DB::$STATUS_PREP_SUCCESS .",". MarketplaceWebService_DB::$STATUS_PREP_PARTIAL_SUCCESS .") and sf.id_status in (".MarketplaceWebService_DB::$STATUS_PREP_SUCCESS .",". MarketplaceWebService_DB::$STATUS_PREP_PARTIAL_SUCCESS .") inner join ps_affiliate_feed_type ft on ft.id = sf.id_type and ft.id = $id_feedtype";
        
        $feed = $this->db->getRow($sql);


        if( empty($feed) )
            return "none";
	
        $service = new MarketplaceWebService_Client($this->mws_config['access_key'], $this->mws_config['secret_key'], $this->config, APPLICATION_NAME,APPLICATION_VERSION);
        $id_feed = $feed['id_feed'];
        $id_subfeed = $feed['id_subfeed'];
        $code = $feed['code'];
        $feed_file = PS_ADMIN_DIR . "/amazon/". $feed['feed_file']; 
        $feedstr = file_get_contents($feed_file);

        $feedHandle = @fopen('php://memory', 'rw+');
        fwrite($feedHandle, $feedstr);
        rewind($feedHandle);

        $marketplaceIdArray = array("Id" => array($this->mws_config['marketplace_id']));
    
        $request = new MarketplaceWebService_Model_SubmitFeedRequest();
        $request->setMerchant($this->mws_config['merchant_id']);
        $request->setMarketplaceIdList($marketplaceIdArray);
        $request->setFeedType($code);
        $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
        rewind($feedHandle);
        $request->setPurgeAndReplace(false);
        $request->setFeedContent($feedHandle);
        //print_r( $request ); 
        rewind($feedHandle);
        $feedSubmissionId = $this->invokeSubmitFeed($service, $request);
        @fclose($feedHandle);

        if( $feedSubmissionId === null )
            return "wait";

        $sql = "update ps_affiliate_subfeed set feed_submission_id=$feedSubmissionId, id_status = ".MarketplaceWebService_DB::$STATUS_AZN_SUBMITTED." where id_subfeed = $id_subfeed";
        $this->db->ExecuteS($sql); 
        
        $sql = "select count(*) as count from ps_affiliate_subfeed where id_feed = $id_feed and id_status != ". MarketplaceWebService_DB::$STATUS_AZN_SUBMITTED;
        $cres = $this->db->getRow($sql);
        if( ((int)$cres['count']) === 0 ) {
            $sql = "update ps_affiliate_feed set id_status = ".MarketplaceWebService_DB::$STATUS_AZN_SUBMITTED." where id_feed = $id_feed";
            $this->db->ExecuteS($sql);
        }
        return "success";
    }

    public function updateStatusForFeeds() {
        $sql = "select sf.id_subfeed, sf.feed_submission_id from ps_affiliate_subfeed sf where sf.id_status = ".MarketplaceWebService_DB::$STATUS_AZN_SUBMITTED;
        $feeds = $this->db->ExecuteS($sql);
        $service = new MarketplaceWebService_Client($this->mws_config['access_key'], $this->mws_config['secret_key'], $this->config, APPLICATION_NAME,APPLICATION_VERSION);
        foreach($feeds as $feed) {
            $id_subfeed = $feed['id_subfeed'];
            $feed_submission_id = $feed['feed_submission_id'];
            
            $request = new MarketplaceWebService_Model_GetFeedSubmissionResultRequest();
            $request->setMerchant($this->mws_config['merchant_id']);
            $request->setFeedSubmissionId($feed_submission_id);
            $request->setFeedSubmissionResult(@fopen('php://memory', 'rw+'));
     
            $this->invokeGetFeedSubmissionResult($service, $request);
            sleep(5);
        }
    } 


    private function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request) {
        $feedSubmissionId = null;
        try {
            $response = $service->submitFeed($request);     
            echo ("Service Response\n");
            echo ("=============================================================================\n");
        
            echo("        SubmitFeedResponse\n");
            if ($response->isSetSubmitFeedResult()) { 
                echo("            SubmitFeedResult\n");
                $submitFeedResult = $response->getSubmitFeedResult();
                if ($submitFeedResult->isSetFeedSubmissionInfo()) { 
                    echo("                FeedSubmissionInfo\n");
                    $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
                    if ($feedSubmissionInfo->isSetFeedSubmissionId()) {
                        echo("                    FeedSubmissionId\n");
                        echo("                        " . $feedSubmissionInfo->getFeedSubmissionId() . "\n");
                        $feedSubmissionId = $feedSubmissionInfo->getFeedSubmissionId();
                    }
                    if ($feedSubmissionInfo->isSetFeedType()) {
                        echo("                    FeedType\n");
                        echo("                        " . $feedSubmissionInfo->getFeedType() . "\n");
                    }
                    if ($feedSubmissionInfo->isSetSubmittedDate()) {
                        echo("                    SubmittedDate\n");
                        echo("                        " . $feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
                    }
                    if ($feedSubmissionInfo->isSetFeedProcessingStatus()) {
                        echo("                    FeedProcessingStatus\n");
                        echo("                        " . $feedSubmissionInfo->getFeedProcessingStatus() . "\n");
                    }
                    if ($feedSubmissionInfo->isSetStartedProcessingDate()) {
                        echo("                    StartedProcessingDate\n");
                        echo("                        " . $feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT) . "\n");
                    }
                    if ($feedSubmissionInfo->isSetCompletedProcessingDate()) {
                        echo("                    CompletedProcessingDate\n");
                        echo("                        " . $feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT) . "\n");
                    }
                } 
            } 
            if ($response->isSetResponseMetadata()) { 
                echo("            ResponseMetadata\n");
                $responseMetadata = $response->getResponseMetadata();
                if ($responseMetadata->isSetRequestId()) {
                    echo("                RequestId\n");
                    echo("                    " . $responseMetadata->getRequestId() . "\n");
                }
            } 
            echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
        } catch (MarketplaceWebService_Exception $ex) {
            echo("Caught Exception: " . $ex->getMessage() . "\n");
            echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            echo("Error Code: " . $ex->getErrorCode() . "\n");
            echo("Error Type: " . $ex->getErrorType() . "\n");
            echo("Request ID: " . $ex->getRequestId() . "\n");
            echo("XML: " . $ex->getXML() . "\n");
            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        }
        return $feedSubmissionId;
    }
    function invokeGetFeedSubmissionResult(MarketplaceWebService_Interface $service, $request) 
    {
        try {
            $response = $service->getFeedSubmissionResult($request);
            echo ("Service Response\n");
            echo ("=============================================================================\n");
            echo("        GetFeedSubmissionResultResponse\n");
            if ($response->isSetGetFeedSubmissionResultResult()) {
                $getFeedSubmissionResultResult = $response->getGetFeedSubmissionResultResult(); 
                echo ("            GetFeedSubmissionResult");
                if ($getFeedSubmissionResultResult->isSetContentMd5()) {
                    echo ("                ContentMd5");
                    echo ("                " . $getFeedSubmissionResultResult->getContentMd5() . "\n");
                }
            }
            if ($response->isSetResponseMetadata()) { 
                echo("            ResponseMetadata\n");
                $responseMetadata = $response->getResponseMetadata();
                if ($responseMetadata->isSetRequestId()) 
                {
                    echo("                RequestId\n");
                    echo("                    " . $responseMetadata->getRequestId() . "\n");
                }
            } 
            echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
        } catch (MarketplaceWebService_Exception $ex) {
            echo("Caught Exception: " . $ex->getMessage() . "\n");
            echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            echo("Error Code: " . $ex->getErrorCode() . "\n");
            echo("Error Type: " . $ex->getErrorType() . "\n");
            echo("Request ID: " . $ex->getRequestId() . "\n");
            echo("XML: " . $ex->getXML() . "\n");
            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        }
    }
}
?>
