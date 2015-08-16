<?php
class MarketplaceWebService_Config {
    public static $access_key = 'AKIAJSM6LGXZKIHYXRXQ';
    public static $secret_key = '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';
    public static $merchant_id = 'A1SU36RA1MD71E';
    public static $marketplace_id = 'ATVPDKIKX0DER';
    public static $merchant_token = 'M_INDUSDIVA_13534751';

    public static $amazon_service_url = 'https://mws.amazonservices.com';

    public static function getConfig($country = 'US') {
        return array(
                        'access_key' => self::$access_key,
                        'secret_key' => self::$secret_key,
                        'merchant_id' => self::$merchant_id,
                        'marketplace_id' => self::$marketplace_id,
                        'merchant_token' => self::$merchant_token,
                        'url' => self::$amazon_service_url
                    );
    }

}

?>
