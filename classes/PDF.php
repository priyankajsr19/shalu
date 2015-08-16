<?php

include_once(_PS_FPDF_PATH_.'fpdf.php');
include_once('Barcode.php');

class PDF_PageGroupCore extends FPDF
{
	var $NewPageGroup;   // variable indicating whether a new group was requested
	var $PageGroups;	 // variable containing the number of pages of the groups
	var $CurrPageGroup;  // variable containing the alias of the current page group

	// create a new page group; call this before calling AddPage()
	function StartPageGroup()
	{
		$this->NewPageGroup=true;
	}

	// current page in the group
	function GroupPageNo()
	{
		return $this->PageGroups[$this->CurrPageGroup];
	}

	// alias of the current page group -- will be replaced by the total number of pages in this group
	function PageGroupAlias()
	{
		return $this->CurrPageGroup;
	}

	function _beginpage($orientation, $arg2)
	{
		parent::_beginpage($orientation, $arg2);
		if($this->NewPageGroup)
		{
			// start a new group
			$n = sizeof($this->PageGroups)+1;
			$alias = "{nb$n}";
			$this->PageGroups[$alias] = 1;
			$this->CurrPageGroup = $alias;
			$this->NewPageGroup=false;
		}
		elseif($this->CurrPageGroup)
			$this->PageGroups[$this->CurrPageGroup]++;
	}

	function _putpages()
	{
		$nb = $this->page;
		if (!empty($this->PageGroups))
		{
			// do page number replacement
			foreach ($this->PageGroups as $k => $v)
				for ($n = 1; $n <= $nb; $n++)
					$this->pages[$n]=str_replace($k, $v, $this->pages[$n]);
		}
		parent::_putpages();
	}
}

class PDFCore extends PDF_PageGroupCore
{
	protected static $order = NULL;
	protected static $orderQuantity = NULL;
	protected static $orderReturn = NULL;
	protected static $orderSlip = NULL;
	protected static $delivery = NULL;
	protected static $_priceDisplayMethod;

	/** @var object Order currency object */
	protected static $currency = NULL;

	protected static $_iso;

	/** @var array Special PDF params such encoding and font */

	protected static $_pdfparams = array();
	protected static $_fpdf_core_fonts = array('courier', 'helvetica', 'helveticab', 'helveticabi', 'helveticai', 'symbol', 'times', 'timesb', 'timesbi', 'timesi', 'zapfdingbats');

	/**
	* Constructor
	*/
	public function __construct($orientation='P', $unit='mm', $format='A4')
	{
		global $cookie;

		if (!isset($cookie) OR !is_object($cookie))
			$cookie->id_lang = (int)(Configuration::get('PS_LANG_DEFAULT'));
		self::$_iso = strtoupper(Language::getIsoById($cookie->id_lang));
		FPDF::FPDF($orientation, $unit, $format);
		$this->_initPDFFonts();
	}

	protected function _initPDFFonts()
	{
		if (!$languages = Language::getLanguages())
			die(Tools::displayError());
		foreach ($languages AS $language)
		{
			$isoCode = strtoupper($language['iso_code']);
			$conf = Configuration::getMultiple(array('PS_PDF_ENCODING_'.$isoCode, 'PS_PDF_FONT_'.$isoCode));
			self::$_pdfparams[$isoCode] = array(
				'encoding' => (isset($conf['PS_PDF_ENCODING_'.$isoCode]) AND $conf['PS_PDF_ENCODING_'.$isoCode] == true) ? $conf['PS_PDF_ENCODING_'.$isoCode] : 'iso-8859-1',
				'font' => (isset($conf['PS_PDF_FONT_'.$isoCode]) AND $conf['PS_PDF_FONT_'.$isoCode] == true) ? $conf['PS_PDF_FONT_'.$isoCode] : 'helvetica'
			);
		}

		if ($font = self::embedfont())
		{
			$this->AddFont($font);
			$this->AddFont($font, 'B');
		}
	}

	/**
	* Invoice header
	*/
	public function Header()
	{
		global $cookie;

		$conf = Configuration::getMultiple(array('PS_SHOP_NAME', 'PS_SHOP_ADDR1', 'PS_SHOP_CODE', 'PS_SHOP_CITY', 'PS_SHOP_COUNTRY', 'PS_SHOP_STATE'));
		$conf['PS_SHOP_NAME'] = isset($conf['PS_SHOP_NAME']) ? Tools::iconv('utf-8', self::encoding(), $conf['PS_SHOP_NAME']) : 'Your company';
		$conf['PS_SHOP_ADDR1'] = isset($conf['PS_SHOP_ADDR1']) ? Tools::iconv('utf-8', self::encoding(), $conf['PS_SHOP_ADDR1']) : 'Your company';
		$conf['PS_SHOP_CODE'] = isset($conf['PS_SHOP_CODE']) ? Tools::iconv('utf-8', self::encoding(), $conf['PS_SHOP_CODE']) : 'Postcode';
		$conf['PS_SHOP_CITY'] = isset($conf['PS_SHOP_CITY']) ? Tools::iconv('utf-8', self::encoding(), $conf['PS_SHOP_CITY']) : 'City';
		$conf['PS_SHOP_COUNTRY'] = isset($conf['PS_SHOP_COUNTRY']) ? Tools::iconv('utf-8', self::encoding(), $conf['PS_SHOP_COUNTRY']) : 'Country';
		$conf['PS_SHOP_STATE'] = isset($conf['PS_SHOP_STATE']) ? Tools::iconv('utf-8', self::encoding(), $conf['PS_SHOP_STATE']) : '';

		//$this->line(20, 30, 70, 30);
		if (file_exists(_PS_IMG_DIR_.'/logo_invoice.jpg'))
		$this->Image(_PS_IMG_DIR_.'/logo_invoice.jpg', 10, 11, 0, 10);
		else if (file_exists(_PS_IMG_DIR_.'/logo.jpg'))
		$this->Image(_PS_IMG_DIR_.'/logo.jpg', 10, 11, 0, 10);
		
		$this->SetY(12);
		$this->SetFont(self::fontname(), 'B', 10);
		//$this->Cell(15);

		//$this->Cell(77, 10, self::l('TAX INVOICE').' '.Tools::iconv('utf-8', self::encoding(), Configuration::get('PS_INVOICE_PREFIX', (int)($cookie->id_lang))).sprintf('%06d', self::$order->invoice_number), 0, 1, 'R');
		if (self::$orderReturn)
			$this->Cell(77, 10, self::l('RETURN #').' '.sprintf('%06d', self::$orderReturn->id), 0, 1, 'R');
		elseif (self::$orderSlip)
			$this->Cell(77, 10, self::l('SLIP #').' '.sprintf('%06d', self::$orderSlip->id), 0, 1, 'R');
		elseif (self::$delivery)
			$this->Cell(77, 10, self::l('DELIVERY SLIP #').' '.Tools::iconv('utf-8', self::encoding(), Configuration::get('PS_DELIVERY_PREFIX', (int)($cookie->id_lang))).sprintf('%06d', self::$delivery), 0, 1, 'R');
		elseif (self::$order->invoice_number)
			$this->Cell(0, 10, self::l('TAX INVOICE - Order #'.self::$order->id), 'B', 1, 'R');
		else
			$this->Cell(77, 10, self::l('ORDER #').' '.sprintf('%06d', self::$order->id), 0, 1, 'R');
   }

   /*
    * Return the complete Address format
    */
   private function _getCompleteUSAddressFormat($conf)
   {
   	$shopCity = (isset($conf['PS_SHOP_CITY']) && !empty($conf['PS_SHOP_CITY'])) ? $conf['PS_SHOP_CITY'] : '';
		$shopState = ((isset($conf['PS_SHOP_STATE']) && !empty($conf['PS_SHOP_STATE'])) ? $conf['PS_SHOP_STATE'] : '');
		$shopZipcode = (isset($conf['PS_SHOP_CODE']) && !empty($conf['PS_SHOP_CODE'])) ? $conf['PS_SHOP_CODE'] : '';

		// Build the complete address with good separators
		$completeAddressShop = $shopCity.
			((!empty($shopState) && !empty($shopCity)) ? ', '.$shopState.((!empty($shopZipcode)) ? ' ' : '') :
			((!empty($shopState)) ? $shopState. ((!empty($shopZipcode)) ? ' ' : '') :
			((!empty($shopCity) && !empty($shopZipcode)) ? ' ' : ''))).
			$shopZipcode;

		// Clean the string
		return ($completeAddressShop = trim($completeAddressShop, ' '));
   }

   /*
    * Build the the detailed footer of the merchant
    */
   private function _builMerchantFooterDetail($conf)
   {
   	$footerText;

   	// If the country is USA
   	if ($conf['PS_SHOP_COUNTRY_ID'] == 21)
   	{
   		$completeAddressShop = $this->_getCompleteUSAddressFormat($conf);

   		$footerText = self::l('Headquarters:')."\n".
				$conf['PS_SHOP_NAME_UPPER']."\n".
				(isset($conf['PS_SHOP_ADDR1']) && !empty($conf['PS_SHOP_ADDR1']) ? $conf['PS_SHOP_ADDR1']."\n" : '').
				(isset($conf['PS_SHOP_ADDR2']) && !empty($conf['PS_SHOP_ADDR2']) ? $conf['PS_SHOP_ADDR2']."\n" : '').
				(!empty($completeAddressShop) ? $completeAddressShop."\n" : '').
				(isset($conf['PS_SHOP_COUNTRY']) && !empty($conf['PS_SHOP_COUNTRY']) ? $conf['PS_SHOP_COUNTRY']."\n" : '').
				((isset($conf['PS_SHOP_PHONE']) && !empty($conf['PS_SHOP_PHONE'])) ? self::l('PHONE:').' '.$conf['PS_SHOP_PHONE'] : '');
   	}
   	else
   	{
   		$footerText = $conf['PS_SHOP_NAME_UPPER'].(!empty($conf['PS_SHOP_ADDR1']) ? ' - '.self::l('Headquarters:').' '.$conf['PS_SHOP_ADDR1'].
   			(!empty($conf['PS_SHOP_ADDR2']) ? ' '.$conf['PS_SHOP_ADDR2'] : '').' '.$conf['PS_SHOP_CODE'].' '.$conf['PS_SHOP_CITY'].
   			((isset($conf['PS_SHOP_STATE']) AND !empty($conf['PS_SHOP_STATE'])) ? (', '.$conf['PS_SHOP_STATE']) : '').' '.$conf['PS_SHOP_COUNTRY'] : '').
   			"\n".(!empty($conf['PS_SHOP_DETAILS']) ? self::l('Details:').' '.$conf['PS_SHOP_DETAILS'].' - ' : '').
				(!empty($conf['PS_SHOP_PHONE']) ? self::l('PHONE:').' '.$conf['PS_SHOP_PHONE'] : '');
   	}
		//return $footerText;
		//default to site address
		return 'www.indusdiva.com';
   }

	/**
	* Invoice footer
	*/
	public function Footer()
	{
		$arrayConf = array(
			'PS_SHOP_NAME',
			'PS_SHOP_ADDR1',
			'PS_SHOP_ADDR2',
			'PS_SHOP_CODE',
			'PS_SHOP_CITY',
			'PS_SHOP_COUNTRY',
			'PS_SHOP_COUNTRY_ID',
			'PS_SHOP_DETAILS',
			'PS_SHOP_PHONE',
			'PS_SHOP_STATE');

		$conf = Configuration::getMultiple($arrayConf);
		$conf['PS_SHOP_NAME_UPPER'] = Tools::strtoupper($conf['PS_SHOP_NAME']);
		$y_delta = array_key_exists('PS_SHOP_DETAILS', $conf) ? substr_count($conf['PS_SHOP_DETAILS'],"\n") : 0;

		foreach($conf as $key => $value)
			$conf[$key] = Tools::iconv('utf-8', self::encoding(), $value);
		foreach ($arrayConf as $key)
			if (!isset($conf[$key]))
				$conf[$key] = '';

		$merchantDetailFooter = $this->_builMerchantFooterDetail($conf);
		$totalLineDetailFooter = count(explode("\n", $merchantDetailFooter));

		// A point equals 1/72 of inch, that is to say about 0.35 mm (an inch being 2.54 cm).
		// This is a very common unit in typography; font sizes are expressed in that unit.
		// 8 point = 2.8mm and the cell height = 4mm
		$this->SetY(-(21.0 + (4 * $totalLineDetailFooter)) - ($y_delta * 7.0));
		$this->SetFont(self::fontname(), '', 7);
		$this->Cell(96, 5, 'E. & O.E.', 'T', 0, 'L');
		$this->Cell(96, 5, ' '."\n".Tools::iconv('utf-8', self::encoding(), 'P. ').$this->GroupPageNo().' / '.$this->PageGroupAlias(), 'T', 1, 'R');

		/*
		 * Display a message for customer
		 */
		if (!self::$delivery)
		{
			$this->SetFont(self::fontname(), '', 8);
			if (self::$orderSlip)
				$textFooter = self::l('An electronic version of this invoice is available in your account.');
			else
				$textFooter = self::l('An electronic version of this invoice is available in your account.');
			$this->Cell(0, 10, $textFooter, 0, 0, 'C', 0);
			$this->Ln(4);
			$this->Cell(0, 10, 'To access it, please log in to IndusDiva.com using your e-mail address and password.',  0, 0,'C');
		}
		else
			$this->Ln(4);
		$this->Ln(9);

		$this->SetFillColor(240, 240, 240);
		$this->SetTextColor(0, 0, 0);
		$this->SetFont(self::fontname(), '', 8);

		$this->MultiCell(0.0, 4.0, $merchantDetailFooter, 0, 'C', 1);
	}

	public static function multipleInvoices($invoices)
	{
		$pdf = new PDF('P', 'mm', 'A4');
		foreach ($invoices AS $id_order)
		{
			$orderObj = new Order((int)$id_order);
			if (Validate::isLoadedObject($orderObj))
				PDF::invoice($orderObj, 'D', true, $pdf);
		}
		return $pdf->Output('invoices.pdf', 'D');
	}

	public static function multipleOrderSlips($orderSlips)
	{
		$pdf = new PDF('P', 'mm', 'A4');
		foreach ($orderSlips AS $id_order_slip)
		{
			$orderSlip = new OrderSlip((int)$id_order_slip);
			$order = new Order((int)$orderSlip->id_order);
			$order->products = OrderSlip::getOrdersSlipProducts($orderSlip->id, $order);
			if (Validate::isLoadedObject($orderSlip) AND Validate::isLoadedObject($order))
				PDF::invoice($order, 'D', true, $pdf, $orderSlip);
		}
		return $pdf->Output('order_slips.pdf', 'D');
	}

	public static function multipleDelivery($slips)
	{
		$pdf = new PDF('P', 'mm', 'A4');
		foreach ($slips AS $id_order)
		{
			$orderObj = new Order((int)$id_order);
			if (Validate::isLoadedObject($orderObj))
				PDF::invoice($orderObj, 'D', true, $pdf, false, $orderObj->delivery_number);
		}
		return $pdf->Output('invoices.pdf', 'D');
	}

	public static function orderReturn($orderReturn, $mode = 'D', $multiple = false, &$pdf = NULL)
	{
		$pdf = new PDF('P', 'mm', 'A4');
		self::$orderReturn = $orderReturn;
		$order = new Order($orderReturn->id_order);
		self::$order = $order;
		$pdf->SetAutoPageBreak(true, 35);
		$pdf->StartPageGroup();
		$pdf->AliasNbPages();
		$pdf->AddPage();

		/* Display address information */
		$arrayConf = array('PS_SHOP_NAME', 'PS_SHOP_ADDR1', 'PS_SHOP_ADDR2', 'PS_SHOP_CODE', 'PS_SHOP_CITY', 'PS_SHOP_COUNTRY', 'PS_SHOP_DETAILS', 'PS_SHOP_PHONE', 'PS_SHOP_STATE');
		$conf = Configuration::getMultiple($arrayConf);
		foreach ($conf as $key => $value)
			$conf[$key] = Tools::iconv('utf-8', self::encoding(), $value);
		foreach ($arrayConf as $key)
			if (!isset($conf[$key]))
				$conf[$key] = '';

		$width = 100;
		$pdf->SetX(10);
		$pdf->SetY(25);
		$pdf->SetFont(self::fontname(), '', 9);

		$addressType = array(
			'invoice' => array(),
			'delivery' => array());

		$patternRules = array(
				'avoid' => array(
					'address2',
					'company',
					'phone',
					'phone_mobile'));

		$addressType = self::generateHeaderAddresses($pdf, $order, $addressType, $patternRules, $width);

		/*
		 * display order information
		 */
		$pdf->Ln(12);
		$pdf->SetFillColor(240, 240, 240);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont(self::fontname(), '', 9);
		$pdf->Cell(0, 6, self::l('RETURN #').sprintf('%06d', self::$orderReturn->id).' '.self::l('from') . ' ' .Tools::displayDate(self::$orderReturn->date_upd, self::$order->id_lang), 1, 2, 'L');
		$pdf->Cell(0, 6, self::l('We have logged your return request.'), 'TRL', 2, 'L');
		$pdf->Cell(0, 6, self::l('Your package must be returned to us within').' '.Configuration::get('PS_ORDER_RETURN_NB_DAYS').' '.self::l('days of receiving your order.'), 'BRL', 2, 'L');
		$pdf->Ln(5);
		$pdf->Cell(0, 6, self::l('List of items marked as returned :'), 0, 2, 'L');
		$pdf->Ln(5);
		$pdf->ProdReturnTab();
		$pdf->Ln(5);
		$pdf->SetFont(self::fontname(), 'B', 10);
		$pdf->Cell(0, 6, self::l('Return reference:').' '.self::l('RET').sprintf('%06d', self::$order->id), 0, 2, 'C');
		$pdf->Cell(0, 6, self::l('Please include this number on your return package.'), 0, 2, 'C');
		$pdf->Ln(5);
		$pdf->SetFont(self::fontname(), 'B', 9);
		$pdf->Cell(0, 6, self::l('REMINDER:'), 0, 2, 'L');
		$pdf->SetFont(self::fontname(), '', 9);
		$pdf->Cell(0, 6, self::l('- All products must be returned in their original packaging without damage or wear.'), 0, 2, 'L');
		$pdf->Cell(0, 6, self::l('- Please print out this document and slip it into your package.'), 0, 2, 'L');
		$pdf->Cell(0, 6, self::l('- The package should be sent to the following address:'), 0, 2, 'L');
		$pdf->Ln(5);
		$pdf->SetFont(self::fontname(), 'B', 10);
		$pdf->Cell(0, 5, Tools::strtoupper($conf['PS_SHOP_NAME']), 0, 1, 'C', 1);
		$pdf->Cell(0, 5, (!empty($conf['PS_SHOP_ADDR1']) ? self::l('Headquarters:').' '.$conf['PS_SHOP_ADDR1'].(!empty($conf['PS_SHOP_ADDR2']) ? ' '.$conf['PS_SHOP_ADDR2'] : '').' '.$conf['PS_SHOP_CODE'].' '.$conf['PS_SHOP_CITY'].' '.$conf['PS_SHOP_COUNTRY'].((isset($conf['PS_SHOP_STATE']) AND !empty($conf['PS_SHOP_STATE'])) ? (', '.$conf['PS_SHOP_STATE']) : '') : ''), 0, 1, 'C', 1);
		$pdf->Ln(5);
		$pdf->SetFont(self::fontname(), '', 9);
		$pdf->Cell(0, 6, self::l('Upon receiving your package, we will notify you by e-mail. We will then begin processing the reimbursement of your order total.'), 0, 2, 'L');
		$pdf->Cell(0, 6, self::l('Let us know if you have any questions.'), 0, 2, 'L');
		$pdf->Ln(5);
		$pdf->SetFont(self::fontname(), 'B', 10);
		$pdf->Cell(0, 6, self::l('If the conditions of return listed above are not respected,'), 'TRL', 2, 'C');
		$pdf->Cell(0, 6, self::l('we reserve the right to refuse your package and/or reimbursement.'), 'BRL', 2, 'C');

		return $pdf->Output(sprintf('%06d', self::$order->id).'.pdf', $mode);
	}

	/**
	* Product table with references, quantities...
	*/
	public function ProdReturnTab()
	{
		$header = array(
			array(self::l('Description'), 'L'),
			array(self::l('Reference'), 'L'),
			array(self::l('Qty'), 'C')
		);
		$w = array(110, 25, 20);
		$this->SetFont(self::fontname(), 'B', 8);
		$this->SetFillColor(240, 240, 240);
		for ($i = 0; $i < sizeof($header); $i++)
			$this->Cell($w[$i], 5, $header[$i][0], 'T', 0, $header[$i][1], 1);
		$this->Ln();
		$this->SetFont(self::fontname(), '', 7);

		$products = OrderReturn::getOrdersReturnProducts(self::$orderReturn->id, self::$order);
		foreach ($products AS $product)
		{
			$before = $this->GetY();
			$this->MultiCell($w[0], 5, Tools::iconv('utf-8', self::encoding(), $product['product_name']), 'B');
			$lineSize = $this->GetY() - $before;
			$this->SetXY($this->GetX() + $w[0], $this->GetY() - $lineSize);
			$this->Cell($w[1], $lineSize, ($product['product_reference'] != '' ? Tools::iconv('utf-8', self::encoding(), $product['product_reference']) : '---'), 'B');
			$this->Cell($w[2], $lineSize, $product['product_quantity'], 'B', 0, 'C');
			$this->Ln();
		}
	}
	
	public function addBarcode($code)
	{
		$fontSize = 2.40;
		$marge    = 1;   // between barcode and hri in pixel
		$x        = $this->GetX() + 45;  // barcode center
		$y        = $this->GetY() + 6;  // barcode center
		$height   = 9;   // barcode height in 1D ; module size in 2D
		$width    = 0.37;    // barcode height in 1D ; not use in 2D
		$angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation

		$type     = 'code39';
		$black    = '000000'; // color in hexa
		
		//$this->SetFont('Arial','B',$fontSize);
		$data = Barcode::fpdf($this, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
		
		//$this->SetFont('Arial','B',$fontSize);
  		//$this->SetTextColor(0, 0, 0);
  		$len = $this->GetStringWidth($data['hri']);
  		Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
  		$this->TextWithRotation($x + $xt, $y + $yt, $data['hri'], $angle);
  		$this->setLineWidth(0.12);
	}
	
	public function TextWithRotation($x, $y, $txt, $txt_angle, $font_angle=0)
    {
        $font_angle+=90+$txt_angle;
        $txt_angle*=M_PI/180;
        $font_angle*=M_PI/180;
    
        $txt_dx=cos($txt_angle);
        $txt_dy=sin($txt_angle);
        $font_dx=cos($font_angle);
        $font_dy=sin($font_angle);
    
        $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',$txt_dx,$txt_dy,$font_dx,$font_dy,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
        if ($this->ColorFlag)
            $s='q '.$this->TextColor.' '.$s.' Q';
        $this->_out($s);
    }

	/*
	 * Generate the header addresses for pdf File
	 */
	public static function generateHeaderAddresses(&$pdf, $order, $addressType, $patternRules, $width)
	{
		$maxY = 0;
		$pdf->setY($pdf->GetY() + 5);
		$customer = new Customer($order->id_customer);
		foreach($addressType as $type => $idNameAttribute)
		{
			$currentY = $pdf->GetY();

			$attributeName = 'id_address_'.$type;
			$addressType[$type]['displayed'] = '';
			$addressType[$type]['addressObject'] = new Address((int)($order->$attributeName));
			$addressType[$type]['addressFields'] = AddressFormat::getOrderedAddressFields($addressType[$type]['addressObject']->id_country);
			$addressType[$type]['addressFormatedValues'] = AddressFormat::getFormattedAddressFieldsValues(
				$addressType[$type]['addressObject'],
				$addressType[$type]['addressFields']);

			foreach ($addressType[$type]['addressFields'] as $line)
				if (($patternsList = explode(' ', $line)))
				{
					$tmp = '';
					foreach($patternsList as $pattern)
						if (!in_array($pattern, $patternRules['avoid']))
							$tmp .= ((isset($addressType[$type]['addressFormatedValues'][$pattern]) &&
								!empty($addressType[$type]['addressFormatedValues'][$pattern])) ?
								(Tools::iconv('utf-8', self::encoding(), $addressType[$type]['addressFormatedValues'][$pattern]).' ') : '');
					$tmp = trim($tmp);
					$addressType[$type]['displayed'] .= (!empty($tmp)) ? $tmp."\n" : '';
				}
				$addressType[$type]['displayed'] .= $customer->email."\n" ;
				$pdf->MultiCell($width, 4.0, $addressType[$type]['displayed'], 0, 'L', 0);

				if ($pdf->GetY() > $maxY)
					$maxY = $pdf->GetY();

				$pdf->SetY($currentY);
				$pdf->SetX($width + 10);
		}

		$pdf->SetY($maxY);
		if ($maxY)
			$pdf->Ln(5);
		return $addressType;
	}

	/**
	* Main
	*
	* @param object $order Order
	* @param string $mode Download or display (optional)
	*/
	public static function invoice($order, $mode = 'D', $multiple = false, &$pdf = NULL, $slip = false, $delivery = false)
	{
	 	global $cookie;

		if (!Validate::isLoadedObject($order) OR (!$cookie->id_employee AND (!OrderState::invoiceAvailable($order->getCurrentState()) AND !$order->invoice_number)))
			die('Invalid order or invalid order state');
		self::$order = $order;
		self::$orderSlip = $slip;
		self::$delivery = $delivery;
		self::$_iso = strtoupper(Language::getIsoById((int)(self::$order->id_lang)));
		if ((self::$_priceDisplayMethod = $order->getTaxCalculationMethod()) === false)
			die(self::l('No price display method defined for the customer group'));

		if (!$multiple)
			$pdf = new PDF('P', 'mm', 'A4');

		$pdf->SetAutoPageBreak(true, 35);
		$pdf->StartPageGroup();

		self::$currency = Currency::getCurrencyInstance((int)(self::$order->id_currency));

		$pdf->AliasNbPages();
		$pdf->AddPage();

		$width = 100;
		$pdf->SetX(10);
		$pdf->SetY(25);
		$pdf->SetFont(self::fontname(), '', 12);
		$pdf->Cell($width, 10, self::l('Billing Address'), 0, 'L');
		$pdf->Cell($width, 10, self::l('Delivery Address'), 0, 'L');
		$pdf->Ln(5);
		$pdf->SetFont(self::fontname(), '', 9);

		$addressType = array(
			'invoice' => array(),
			'delivery' => array()
		);

		$patternRules = array(
				'optional' => array(
					'address2',
					'company'),
				'avoid' => array(
					'State:iso_code'));

		$addressType = self::generateHeaderAddresses($pdf, $order, $addressType, $patternRules, $width);

		if (Configuration::get('VATNUMBER_MANAGEMENT') AND !empty($addressType['invoice']['addressObject']->vat_number))
		{
			$vat_delivery = '';
			if ($addressType['invoice']['addressObject']->id != $addressType['delivery']['addressObject']->id)
				$vat_delivery = $addressType['delivery']['addressObject']->vat_number;
			$pdf->Cell($width, 10, Tools::iconv('utf-8', self::encoding(), $vat_delivery), 0, 'L');
			$pdf->Cell($width, 10, Tools::iconv('utf-8', self::encoding(), $addressType['invoice']['addressObject']->vat_number), 0, 'L');
			$pdf->Ln(5);
		}

		if ($addressType['invoice']['addressObject']->dni != NULL)
			$pdf->Cell($width, 10,
				self::l('Tax ID number:').' '.Tools::iconv('utf-8', self::encoding(),
				$addressType['invoice']['addressObject']->dni), 0, 'L');

		/*
		 * display order information
		 */
		$boxTop = $pdf->GetY();
		$pdf->Rect(10, $boxTop, 90, 45);
		$pdf->Rect(110, $boxTop, 90, 45);
		//$pdf->SetY(70);
		$pdf->SetFillColor(240, 240, 240);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(90, 6, self::l('Order Details'), 1, 2, 'C', 1);
		
		$carrier = new Carrier(self::$order->id_carrier);
		if ($carrier->name == '0')
				$carrier->name = Configuration::get('PS_SHOP_NAME');
		$history = self::$order->getHistory(self::$order->id_lang);
		foreach($history as $h)
			if ($h['id_order_state'] == _PS_OS_SHIPPING_)
				$shipping_date = $h['date_add'];
		//$pdf->Ln(12);
		
		//Initialize price calculations
		$priceBreakDown = array();
		$pdf->priceBreakDownCalculation($priceBreakDown);
		if (!self::$orderSlip OR (self::$orderSlip AND self::$orderSlip->shipping_cost))
		{
			$priceBreakDown['totalWithoutTax'] += Tools::ps_round($priceBreakDown['shippingCostWithoutTax'], 2) + Tools::ps_round($priceBreakDown['wrappingCostWithoutTax'], 2);
			$priceBreakDown['totalWithTax'] += self::$order->total_shipping + self::$order->total_wrapping + self::$order->total_cod + $priceBreakDown['customizationCost'];
		}
		if (!self::$orderSlip)
		{
			$taxDiscount = self::$order->getTaxesAverageUsed();
			if ($taxDiscount != 0)
				$priceBreakDown['totalWithoutTax'] -= Tools::ps_round(self::$order->total_discounts / (1 + self::$order->getTaxesAverageUsed() * 0.01), 2);
			else
				$priceBreakDown['totalWithoutTax'] -= self::$order->total_discounts;
			$priceBreakDown['totalWithTax'] -= self::$order->total_discounts;
		}
				
		$pdf->SetFont(self::fontname(), '', 9);
		/*if (self::$orderSlip)
			$pdf->Cell(0, 6, self::l('SLIP #').' '.sprintf('%06d', self::$orderSlip->id).' '.self::l('from') . ' ' .Tools::displayDate(self::$orderSlip->date_upd, self::$order->id_lang), 1, 2, 'L', 1);
		elseif (self::$delivery)
			$pdf->Cell(0, 6, self::l('DELIVERY SLIP #').Tools::iconv('utf-8', self::encoding(), Configuration::get('PS_DELIVERY_PREFIX', (int)($cookie->id_lang))).sprintf('%06d', self::$delivery).' '.self::l('from') . ' ' .Tools::displayDate(self::$order->delivery_date, self::$order->id_lang), 1, 2, 'L', 1);
		else
			$pdf->Cell(0, 6, self::l('Order Details'), 1, 2, 'L', 1);*/
		$pdf->SetFontSize(10);
		$pdf->Ln(3);
		$pdf->Cell(90, 6, self::l('Order No. :').' '.sprintf('%06d', self::$order->id), 0, 2, 'C');
		$pdf->Cell(90, 6, self::l('Order Date:').' '.Tools::displayDate($order->invoice_date, self::$order->id_lang), 0, 2, 'C');
		$pdf->Cell(90, 6, 'Invoice No.'.' '.Tools::iconv('utf-8', self::encoding(), Configuration::get('PS_INVOICE_PREFIX', (int)($cookie->id_lang))).sprintf('%06d', self::$order->invoice_number), 0, 2, 'C');
		
		$pdf->SetY($boxTop);
		$pdf->SetX(110);
		
		$pdf->SetFontSize(10);
		$pdf->Cell(90, 6, self::l('Shipment Details'), 1, 2, 'C', 1);
		
		$pdf->SetFontSize(10);
		//$pdf->Cell(45, 6, self::l('Payment:').($order->gift ? ' '.Tools::iconv('utf-8', self::encoding(), $carrier->name) : ''), 0, 0, 'C');
		if(strpos($order->payment, 'COD') === false)
		{
			$pdf->Cell(90, 6, 'Payment: '.Tools::iconv('utf-8', self::encoding(), 'Online Payment'), 0, 2, 'C');
			$pdf->Cell(90, 6, 'PAID', 'B', 2, 'C');
		}
		else
		{
			$pdf->Cell(90, 6, 'Payment: '.Tools::iconv('utf-8', self::encoding(), 'COD'), 0, 2, 'C');
			$pdf->Cell(90, 6, 'Collect: '.self::convertSign(Tools::displayPrice((self::$_priceDisplayMethod == PS_TAX_EXC ? $priceBreakDown['totalWithoutTax'] : $priceBreakDown['totalWithTax']), self::$currency, true)), 'B', 2, 'C');
		}
			
		
		$pdf->Cell(90, 6, self::l('Shipping: ').$carrier->name, 0, 2, 'C');
		//$pdf->Ln(5);
		
		$tracking_number = '';
		
		if($order->shipping_number)
		{
			$tracking_number = 'Tracking code: '.$order->shipping_number;
			$pdf->Cell(90, 6, $tracking_number, 'B', 2, 'C');
			$pdf->addBarcode($order->shipping_number);
		}
		
		
		
		$pdf->SetY($boxTop + 45);
		$pdf->Ln(5);
		
		$pdf->ProdTab((self::$delivery ? true : ''));

		/* Exit if delivery */
		if (!self::$delivery)
		{
			//if (!self::$orderSlip)
				//$pdf->DiscTab();
			

			

			if(self::$orderQuantity)
			{
				$pdf->Ln(3);
				$pdf->SetFont(self::fontname(), 'B', 8);
				$width = 165;
				$pdf->Cell(150, 4, self::l('Total Quantity').' : ', 'B', 0, 'R');
				$pdf->Cell(0, 4, self::$orderQuantity, 'B', 2, 'L');
				$pdf->Ln(6);
			}
			/*
			 * Display price summation
			 */
			if (Configuration::get('PS_TAX') OR $order->total_products_wt != $order->total_products)
			{
				/*$pdf->Ln(5);
				$pdf->SetFont(self::fontname(), 'B', 8);
				$width = 165;
				$pdf->Cell($width, 0, self::l('Order Total').' : ', 0, 0, 'R');
				$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['totalProductsWithoutTax'], self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);
				*/
				/*
				$pdf->SetFont(self::fontname(), 'B', 8);
				$width = 165;
				$pdf->Cell($width, 0, self::l('Total products (tax incl.)').' : ', 0, 0, 'R');
				$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['totalProductsWithTax'], self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);
				*/
			}
			else
			{
				$pdf->Ln(5);
				$pdf->SetFont(self::fontname(), 'B', 8);
				$width = 165;
				$pdf->Cell($width, 0, self::l('Total products ').' : ', 0, 0, 'R');
				$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['totalProductsWithoutTax'], self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);
			}

			

			if(isset(self::$order->total_wrapping) and ((float)(self::$order->total_wrapping) > 0))
			{
				$pdf->Cell($width, 0, self::l('Total gift-wrapping').' : ', 0, 0, 'R');
				if (self::$_priceDisplayMethod == PS_TAX_EXC)
					$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['wrappingCostWithoutTax'], self::$currency, true)), 0, 0, 'R');
				else
					$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(self::$order->total_wrapping, self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);
			}

			/*
			$pdf->Cell($width, 0, self::l('Tax').' : ', 0, 0, 'R');
			$pdf->Cell(0, 0, self::convertSign(Tools::displayPrice($priceBreakDown['totalProductsWithTax'] - $priceBreakDown['totalProductsWithoutTax'], self::$currency, true)), 0, 0, 'R');
			$pdf->Ln(4);
			*/
			if($priceBreakDown['customizationCost'] > 0)
			{
			    $pdf->Cell($width, 0, self::l('Stitching and Customizations').' : ', 0, 0, 'R');
			    if (self::$_priceDisplayMethod == PS_TAX_EXC)
			        $pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['customizationCost'], self::$currency, true)), 0, 0, 'R');
			    else
			        $pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['customizationCost'], self::$currency, true)), 0, 0, 'R');
			    $pdf->Ln(4);
			}
			
			if(isset(self::$order->total_cod) and ((float)(self::$order->total_cod) > 0))
			{
				$pdf->Cell($width, 0, self::l('COD Charges').' : ', 0, 0, 'R');
				if (self::$_priceDisplayMethod == PS_TAX_EXC)
					$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(self::$order->total_cod, self::$currency, true)), 0, 0, 'R');
				else
					$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(self::$order->total_cod, self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);
			}
			
			if (self::$order->total_shipping != '0.00' AND (!self::$orderSlip OR (self::$orderSlip AND self::$orderSlip->shipping_cost)))
			{
				$pdf->Cell($width, 0, self::l('Shipping').' : ', 0, 0, 'R');
				if (self::$_priceDisplayMethod == PS_TAX_EXC)
					$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(Tools::ps_round($priceBreakDown['shippingCostWithoutTax'], 2), self::$currency, true)), 0, 0, 'R');
				else
					$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(self::$order->total_shipping, self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);
			}
			
			if (!self::$orderSlip AND self::$order->total_discounts != '0.00')
			{
				$pdf->Cell($width, 0, self::l('Discounts').' : ', 0, 0, 'R');
				$pdf->Cell(0, 0, (!self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(self::$order->total_discounts, self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);
				
				/*$pdf->Cell($width, 0, self::l('Sub-total').' : ', 0, 0, 'R');
				$pdf->Cell(0, 0, self::convertSign(Tools::displayPrice($priceBreakDown['totalProductsWithoutTax'] - self::$order->total_discounts, self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);*/
			}

			if (Configuration::get('PS_TAX') OR $order->total_products_wt != $order->total_products)
			{
				$pdf->Cell($width, 0, self::l('Total').' '.(self::$_priceDisplayMethod == PS_TAX_EXC ? self::l(' (tax excl.)') : self::l(' (tax incl.)')).' : ', 0, 0, 'R');
				$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice((self::$_priceDisplayMethod == PS_TAX_EXC ? $priceBreakDown['totalWithoutTax'] : $priceBreakDown['totalWithTax']), self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);
			}
			else
			{
				$pdf->Cell($width, 0, self::l('Total').' : ', 0, 0, 'R');
				$pdf->Cell(0, 0, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(($priceBreakDown['totalWithoutTax']), self::$currency, true)), 0, 0, 'R');
				$pdf->Ln(4);
			}

			$pdf->TaxTab($priceBreakDown);
			$pdf->addShopAddress1();
		}
		Hook::PDFInvoice($pdf, self::$order->id);

		if (!$multiple)
			return $pdf->Output('IndusDiva Order #'.sprintf('%06d', self::$order->id).'.pdf', $mode);
	}

	public function ProdTabHeader($delivery = false)
	{
		if (!$delivery)
		{
			$header = array(
				array(self::l('Description'), 'L'),
				array(self::l(''), 'L'),
				array(self::l('Unit Price'), 'R'),
				array(self::l('Qty'), 'C'),
				array(self::l('Total'), 'R')
			);
			$w = array(100, 15, 30, 15, 30);
		}
		else
		{
			$header = array(
				array(self::l('Description'), 'L'),
				array(self::l(''), 'L'),
				array(self::l('Qty'), 'C'),
			);
			$w = array(120, 30, 10);
		}
		$this->SetFont(self::fontname(), 'B', 8);
		$this->SetFillColor(240, 240, 240);
		if ($delivery)
			$this->SetX(25);
		for($i = 0; $i < sizeof($header); $i++)
			$this->Cell($w[$i], 5, $header[$i][0], 'T', 0, $header[$i][1], 1);
		$this->Ln();
		$this->SetFont(self::fontname(), '', 8);
	}

	/**
	* Product table with price, quantities...
	*/
	public function ProdTab($delivery = false)
	{
		self::$orderQuantity = 0;
		if (!$delivery)
			$w = array(100, 15, 30, 15, 30);
		else
			$w = array(120, 30, 10);
		self::ProdTabHeader($delivery);
		if (!self::$orderSlip)
		{
			if (isset(self::$order->products) AND sizeof(self::$order->products))
				$products = self::$order->products;
			else
				$products = self::$order->getProducts();
		}
		else
			$products = self::$orderSlip->getProducts();
		$customizedDatas = Product::getAllCustomizedDatas((int)(self::$order->id_cart));
		Product::addCustomizationPrice($products, $customizedDatas);

		$counter = 0;
		$lines = 25;
		$lineSize = 0;
		$line = 0;

		foreach($products AS $product)
			if (!$delivery OR ((int)($product['product_quantity']) - (int)($product['product_quantity_refunded']) > 0))
			{
				if($counter >= $lines)
				{
					$this->AddPage();
					$this->Ln();
					self::ProdTabHeader($delivery);
					$lineSize = 0;
					$counter = 0;
					$lines = 40;
					$line++;
				}
				$counter = $counter + ($lineSize / 5) ;

				$i = -1;

				// Unit vars
				$unit_without_tax = $product['product_price'] + $product['ecotax'];
				$unit_with_tax = $product['product_price_wt'];
				if (self::$_priceDisplayMethod == PS_TAX_EXC)
					$unit_price = &$unit_without_tax;
				else
					$unit_price = &$unit_with_tax;
				$productQuantity = $delivery ? ((int)($product['product_quantity']) - (int)($product['product_quantity_refunded'])) : (int)($product['product_quantity']);

				if ($productQuantity <= 0)
					continue ;

				// Total prices
				$total_with_tax = Tools::ps_round($unit_with_tax) * $productQuantity;
				$total_without_tax = Tools::ps_round($unit_without_tax) * $productQuantity;
				// Spec
				if (self::$_priceDisplayMethod == PS_TAX_EXC)
					$final_price = &$total_without_tax;
				else
					$final_price = &$total_with_tax;
				// End Spec

				if (isset($customizedDatas[$product['product_id']][$product['product_attribute_id']]))
				{
					$custoLabel = '';

					foreach($customizedDatas[$product['product_id']][$product['product_attribute_id']] as $customizedData)
					{
						$customizationGroup = $customizedData['datas'];
						$nb_images = 0;

						if (array_key_exists(_CUSTOMIZE_FILE_, $customizationGroup))
							$nb_images = sizeof($customizationGroup[_CUSTOMIZE_FILE_]);

						/*if (array_key_exists(_CUSTOMIZE_TEXTFIELD_, $customizationGroup))
							foreach($customizationGroup[_CUSTOMIZE_TEXTFIELD_] as $customization)
								if(!empty($customization['name'])) $custoLabel .= '- '.$customization['name'].': '.$customization['value']."\n";
						*/

						if ($nb_images > 0)
							$custoLabel .= '- '.$nb_images. ' '. self::l('image(s)')."\n";

						$custoLabel .= "---\n";
					}

					$custoLabel = rtrim($custoLabel, "---\n");

					$productQuantity = (int)($product['product_quantity']) - (int)($product['customizationQuantityTotal']);
					if ($delivery)
						$this->SetX(25);
					$before = $this->GetY();
					$this->MultiCell($w[++$i], 5, Tools::iconv('utf-8', self::encoding(), $product['product_name'])." \n".Tools::iconv('utf-8', self::encoding(), $custoLabel), 'B');
					$lineSize = $this->GetY() - $before;
					$this->SetXY($this->GetX() + $w[0] + ($delivery ? 15 : 0), $this->GetY() - $lineSize);
					$this->Cell($w[++$i], $lineSize, ($product['product_reference'] ? $product['product_reference'] : ''), 'B');
					if (!$delivery)
						$this->Cell($w[++$i], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($unit_price, self::$currency, true)), 'B', 0, 'R');
					$this->Cell($w[++$i], $lineSize, (int)($product['customizationQuantityTotal']), 'B', 0, 'C');
					if (!$delivery)
						$this->Cell($w[++$i], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(round($unit_price) * (int)($product['customizationQuantityTotal']), self::$currency, true)), 'B', 0, 'R');
					$this->Ln();
					$i = -1;
					$total_with_tax = Tools::ps_round($unit_with_tax) * $productQuantity;
					$total_without_tax = Tools::ps_round($unit_without_tax) * $productQuantity;
				}
				
				self::$orderQuantity += $product['product_quantity'];
				
				if ($delivery)
					$this->SetX(25);
				if ($productQuantity)
				{
					$before = $this->GetY();
					$this->MultiCell($w[++$i], 5, Tools::iconv('utf-8', self::encoding(), $product['product_name']), 'B');
					$lineSize = $this->GetY() - $before;
					$this->SetXY($this->GetX() + $w[0] + ($delivery ? 15 : 0), $this->GetY() - $lineSize);
					$this->Cell($w[++$i], $lineSize, ($product['product_reference'] ? $product['product_reference'] : ''), 'B');
					if (!$delivery)
						$this->Cell($w[++$i], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($unit_price, self::$currency, true)), 'B', 0, 'R');
					$this->Cell($w[++$i], $lineSize, $productQuantity, 'B', 0, 'C');
					if (!$delivery)
						$this->Cell($w[++$i], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($final_price, self::$currency, true)), 'B', 0, 'R');
					$this->Ln();
				}
			}

		if (!sizeof(self::$order->getDiscounts()) AND !$delivery)
			$this->Cell(array_sum($w), 0, '');
	}

	/**
	* Discount table with value, quantities...
	*/
	public function DiscTab()
	{
		$w = array(90, 25, 15, 10, 25, 25);
		$this->SetFont(self::fontname(), 'B', 7);
		$discounts = self::$order->getDiscounts();

		foreach($discounts AS $discount)
		{
			$this->Cell($w[0], 6, self::l('Discount:').' '.$discount['name'], 'B');
			$this->Cell($w[1], 6, '', 'B');
			$this->Cell($w[2], 6, '', 'B');
			$this->Cell($w[3], 6, '', 'B', 0, 'R');
			$this->Cell($w[4], 6, '1', 'B', 0, 'C');
			$this->Cell($w[5], 6, ((!self::$orderSlip AND $discount['value'] != 0.00) ? '-' : '').self::convertSign(Tools::displayPrice($discount['value'], self::$currency, true)), 'B', 0, 'R');
			$this->Ln();
		}

		if (sizeof($discounts))
			$this->Cell(array_sum($w), 0, '');
	}
	
	function getProductCustomizationCost($id_product)
	{
		global $cookie;
		if (!$result = Db::getInstance()->ExecuteS('
				SELECT cd.`id_customization`, c.`id_product`, c.`quantity`, cfl.`id_customization_field`, c.`id_product_attribute`, cd.`type`, cd.`index`, cd.`value`, cfl.`name`
				FROM `'._DB_PREFIX_.'customized_data` cd
				NATURAL JOIN `'._DB_PREFIX_.'customization` c
				LEFT JOIN `'._DB_PREFIX_.'customization_field_lang` cfl ON (cfl.id_customization_field = cd.`index` AND id_lang = '.$cookie->id_lang.')
				WHERE c.`id_cart` = '.$this->id.'
				AND c.id_product = ' . $id_product . '
				ORDER BY `id_product`, `id_product_attribute`, `type`, `index`'))
			return 0;
	
		$total_customization_cost = 0;
		foreach ($result as $row)
		{
			if($row['id_customization_field'] == 1)
				$total_customization_cost += ID_PRESTITCHED_SAREE_FEE * $row['quantity'];
			elseif($row['id_customization_field'] == 2)
			$total_customization_cost += ID_PRESTITCHED_BLOUSE_FEE * $row['quantity'];
			elseif($row['id_customization_field'] == 3)
			$total_customization_cost += ID_PRESTITCHED_INSKIRT_FEE * $row['quantity'];
			elseif($row['id_customization_field'] == 4)
			$total_customization_cost += ID_PRESTITCHED_SKD_FEE * $row['quantity'];
		}
	
		return $total_customization_cost;
	}

	public function priceBreakDownCalculation(&$priceBreakDown)
	{
		$priceBreakDown['totalsWithoutTax'] = array();
		$priceBreakDown['totalsWithTax'] = array();
		$priceBreakDown['totalsEcotax'] = array();
		$priceBreakDown['wrappingCostWithoutTax'] = 0;
		$priceBreakDown['shippingCostWithoutTax'] = 0;
		$priceBreakDown['totalWithoutTax'] = 0;
		$priceBreakDown['totalWithTax'] = 0;
		$priceBreakDown['totalProductsWithoutTax'] = 0;
		$priceBreakDown['totalProductsWithTax'] = 0;
		$priceBreakDown['hasEcotax'] = 0;
		$priceBreakDown['totalsProductsWithTaxAndReduction'] = array();
		$priceBreakDown['customizationCost'] = Cart::getCustomizationCostStatic(self::$order->id_cart);
		
		if (self::$order->total_paid == '0.00' AND self::$order->total_discounts == 0)
			return ;

		// Setting products tax
		if (isset(self::$order->products) AND sizeof(self::$order->products))
			$products = self::$order->products;
		else
			$products = self::$order->getProducts();
		$amountWithoutTax = 0;
		$taxes = array();
		/* Firstly calculate all prices */
		foreach ($products AS &$product)
		{
			if (!isset($priceBreakDown['totalsWithTax'][$product['tax_rate']]))
				$priceBreakDown['totalsWithTax'][$product['tax_rate']] = 0;
			if (!isset($priceBreakDown['totalsEcotax'][$product['tax_rate']]))
				$priceBreakDown['totalsEcotax'][$product['tax_rate']] = 0;
			if (!isset($priceBreakDown['totalsWithoutTax'][$product['tax_rate']]))
				$priceBreakDown['totalsWithoutTax'][$product['tax_rate']] = 0;
			if (!isset($taxes[$product['tax_rate']]))
				$taxes[$product['tax_rate']] = 0;
			if (!isset($priceBreakDown['totalsProductsWithTaxAndReduction'][$product['tax_rate']]))
				$priceBreakDown['totalsProductsWithTaxAndReduction'][$product['tax_rate']] = 0;


			/* Without tax */
			if (self::$_priceDisplayMethod == PS_TAX_EXC)
				$product['priceWithoutTax'] = Tools::ps_round((float)($product['product_price']) + (float)$product['ecotax'], 2);
			else
				$product['priceWithoutTax'] = ($product['product_price_wt_but_ecotax'] / (1 + $product['tax_rate'] / 100)) + (float)$product['ecotax'];

			$product['priceWithoutTax'] =  $product['priceWithoutTax'] * (int)($product['product_quantity']);

			$amountWithoutTax += $product['priceWithoutTax'];
			/* With tax */
			$product['priceWithTax'] = (float)($product['product_price_wt']) * (int)($product['product_quantity']);
			$product['priceEcotax'] = $product['ecotax'] * (1 + $product['ecotax_tax_rate'] / 100);
		}

		$priceBreakDown['totalsProductsWithoutTax'] = $priceBreakDown['totalsWithoutTax'];
		$priceBreakDown['totalsProductsWithTax'] = $priceBreakDown['totalsWithTax'];

		$tmp = 0;
		$product = &$tmp;
		/* And secondly assign to each tax its own reduction part */
		$discountAmount = (float)(self::$order->total_discounts);
		foreach ($products as $product)
		{
			$ratio = $amountWithoutTax == 0 ? 0 : $product['priceWithoutTax'] / $amountWithoutTax;
			$priceWithTaxAndReduction = $product['priceWithTax'] - $discountAmount * $ratio;
			$discountAmountWithoutTax = Tools::ps_round(($discountAmount * $ratio) / (1 + ($product['tax_rate'] / 100)), 2);
			if (self::$_priceDisplayMethod == PS_TAX_EXC)
			{
				$vat = $priceWithTaxAndReduction - Tools::ps_round($priceWithTaxAndReduction / $product['product_quantity'] / (((float)($product['tax_rate']) / 100) + 1), 2) * $product['product_quantity'];
				$priceBreakDown['totalsWithoutTax'][$product['tax_rate']] += $product['priceWithoutTax'] ;
				$priceBreakDown['totalsProductsWithoutTax'][$product['tax_rate']] += $product['priceWithoutTax'];
				$priceBreakDown['totalsProductsWithoutTaxAndReduction'][$product['tax_rate']] = Tools::ps_round($product['priceWithoutTax'] - (float)$discountAmountWithoutTax, 2);
			}
			else
			{
				$vat = (float)($product['priceWithoutTax']) * ((float)($product['tax_rate'])  / 100) * $product['product_quantity'];
				$priceBreakDown['totalsWithTax'][$product['tax_rate']] += $product['priceWithTax'];
				$priceBreakDown['totalsProductsWithTax'][$product['tax_rate']] += $product['priceWithTax'];
				$priceBreakDown['totalsProductsWithoutTax'][$product['tax_rate']] += $product['priceWithoutTax'];
				$priceBreakDown['totalsProductsWithTaxAndReduction'][$product['tax_rate']] += $priceWithTaxAndReduction;
			}

			$priceBreakDown['totalsEcotax'][$product['tax_rate']] += ($product['priceEcotax']  * $product['product_quantity']);
			if ($priceBreakDown['totalsEcotax'][$product['tax_rate']])
				$priceBreakDown['hasEcotax'] = 1;
			$taxes[$product['tax_rate']] += $vat;
		}

		$carrier_tax_rate = (float)self::$order->carrier_tax_rate;
		if (($priceBreakDown['totalsWithoutTax'] == $priceBreakDown['totalsWithTax']) AND (!$carrier_tax_rate OR $carrier_tax_rate == '0.00') AND (!self::$order->total_wrapping OR self::$order->total_wrapping == '0.00'))
			return ;

		foreach ($taxes AS $tax_rate => &$vat)
		{
			if (self::$_priceDisplayMethod == PS_TAX_EXC)
			{
				$priceBreakDown['totalsWithoutTax'][$tax_rate] = Tools::ps_round($priceBreakDown['totalsWithoutTax'][$tax_rate], 2);
				$priceBreakDown['totalsProductsWithoutTax'][$tax_rate] = Tools::ps_round($priceBreakDown['totalsWithoutTax'][$tax_rate], 2);
				$priceBreakDown['totalsWithTax'][$tax_rate] = Tools::ps_round($priceBreakDown['totalsWithoutTax'][$tax_rate] * (1 + $tax_rate / 100), 2);
				$priceBreakDown['totalsProductsWithTax'][$tax_rate] = Tools::ps_round($priceBreakDown['totalsProductsWithoutTax'][$tax_rate] * (1 + $tax_rate / 100), 2);
				$priceBreakDown['totalsProductsWithTaxAndReduction'][$product['tax_rate']] += Tools::ps_round($priceBreakDown['totalsProductsWithoutTaxAndReduction'][$product['tax_rate']] * (1 + $tax_rate / 100), 2);
			}
			else
			{
				$priceBreakDown['totalsWithoutTax'][$tax_rate] = $priceBreakDown['totalsProductsWithoutTax'][$tax_rate];
				$priceBreakDown['totalsProductsWithoutTax'][$tax_rate] = Tools::ps_round($priceBreakDown['totalsProductsWithoutTax'][$tax_rate], 2);
				$priceBreakDown['totalsProductsWithoutTaxAndReduction'][$tax_rate] = $priceBreakDown['totalsProductsWithTaxAndReduction'][$tax_rate] / (1 + ($tax_rate / 100));
			}

			$priceBreakDown['totalWithTax'] += $priceBreakDown['totalsWithTax'][$tax_rate];
			$priceBreakDown['totalWithoutTax'] += $priceBreakDown['totalsWithoutTax'][$tax_rate];
			$priceBreakDown['totalProductsWithoutTax'] += $priceBreakDown['totalsProductsWithoutTax'][$tax_rate];
			$priceBreakDown['totalProductsWithTax'] += $priceBreakDown['totalsProductsWithTax'][$tax_rate];

		}
		$priceBreakDown['taxes'] = $taxes;
		$priceBreakDown['shippingCostWithoutTax'] = ($carrier_tax_rate AND $carrier_tax_rate != '0.00') ? (self::$order->total_shipping / (1 + ($carrier_tax_rate / 100))) : self::$order->total_shipping;
		if (self::$order->total_wrapping AND self::$order->total_wrapping != '0.00')
		{
			$wrappingTax = new Tax(Configuration::get('PS_GIFT_WRAPPING_TAX'));
			$priceBreakDown['wrappingCostWithoutTax'] = self::$order->total_wrapping / (1 + ((float)($wrappingTax->rate) / 100));
		}
	}

	/**
	* Tax table
	*/
	public function TaxTab(&$priceBreakDown)
	{

     $invoiceAddress = new Address(self::$order->id_address_invoice);
		if (Configuration::get('VATNUMBER_MANAGEMENT') AND !empty($invoiceAddress->vat_number) AND $invoiceAddress->id_country != Configuration::get('VATNUMBER_COUNTRY'))
		{
			$this->Ln();
			$this->Cell(30, 0, self::l('Exempt of VAT according section 259B of the General Tax Code.'), 0, 0, 'L');
			return;
		}

		if (self::$order->total_paid == '0.00' OR (!(int)(Configuration::get('PS_TAX')) AND self::$order->total_products == self::$order->total_products_wt))
			return ;

    	$carrier_tax_rate = (float)self::$order->carrier_tax_rate;
		if (($priceBreakDown['totalsWithoutTax'] == $priceBreakDown['totalsWithTax']) AND (!$carrier_tax_rate OR $carrier_tax_rate == '0.00') AND (!self::$order->total_wrapping OR self::$order->total_wrapping == '0.00'))
			return ;

		// Displaying header tax
		if ($priceBreakDown['hasEcotax'])
		{
			$header = array(self::l('Tax detail'), self::l('Tax'), self::l('Pre-Tax Total'), self::l('Total Tax'), self::l('Ecotax (Tax Incl.)'), self::l('Total with Tax'));
			$w = array(60, 20, 40, 20, 30, 20);
		}
		else
		{
			$header = array(self::l('Tax detail'), self::l('Tax Rate'), self::l('Pre-Tax Total'), self::l('Total Tax'), self::l('Total with Tax'));
			$w = array(60, 30, 40, 30, 30);
		}
		$this->SetFont(self::fontname(), 'B', 8);
		for($i = 0; $i < sizeof($header); $i++)
			$this->Cell($w[$i], 5, $header[$i], 0, 0, 'R');

		$this->Ln();
		$this->SetFont(self::fontname(), '', 7);

		$nb_tax = 0;

		// Display product tax
		foreach ($priceBreakDown['taxes'] AS $tax_rate => $vat)
		{
			if ($tax_rate != '0.00' AND $priceBreakDown['totalsProductsWithTax'][$tax_rate] != '0.00')
			{
				$nb_tax++;
				$before = $this->GetY();
				$lineSize = $this->GetY() - $before;
				$this->SetXY($this->GetX(), $this->GetY() - $lineSize + 3);
				$this->Cell($w[0], $lineSize, self::l('VAT'), 0, 0, 'R');
				$this->Cell($w[1], $lineSize, number_format($tax_rate, 2, '.', ' ').' %', 0, 0, 'R');
				$this->Cell($w[2], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['totalsProductsWithoutTaxAndReduction'][$tax_rate], self::$currency, true)), 0, 0, 'R');
				$this->Cell($w[3], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['totalsProductsWithTaxAndReduction'][$tax_rate] - $priceBreakDown['totalsProductsWithoutTaxAndReduction'][$tax_rate], self::$currency, true)), 0, 0, 'R');
				if ($priceBreakDown['hasEcotax'])
					$this->Cell($w[4], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['totalsEcotax'][$tax_rate], self::$currency, true)), 0, 0, 'R');
				$this->Cell($w[$priceBreakDown['hasEcotax'] ? 5 : 4], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['totalsProductsWithTaxAndReduction'][$tax_rate], self::$currency, true)), 0, 0, 'R');
				$this->Ln();
			}
		}

		// Display carrier tax
		if ($carrier_tax_rate AND $carrier_tax_rate != '0.00' AND ((self::$order->total_shipping != '0.00' AND !self::$orderSlip) OR (self::$orderSlip AND self::$orderSlip->shipping_cost)))
		{
			$nb_tax++;
			$before = $this->GetY();
			$lineSize = $this->GetY() - $before;
			$this->SetXY($this->GetX(), $this->GetY() - $lineSize + 3);
			$this->Cell($w[0], $lineSize, self::l('Carrier'), 0, 0, 'R');
			$this->Cell($w[1], $lineSize, number_format($carrier_tax_rate, 3, ',', ' ').' %', 0, 0, 'R');
			$this->Cell($w[2], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['shippingCostWithoutTax'], self::$currency, true)), 0, 0, 'R');
			$this->Cell($w[3], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(self::$order->total_shipping - $priceBreakDown['shippingCostWithoutTax'], self::$currency, true)), 0, 0, 'R');
			if ($priceBreakDown['hasEcotax'])
				$this->Cell($w[4], $lineSize, (self::$orderSlip ? '-' : '').'', 0, 0, 'R');
			$this->Cell($w[$priceBreakDown['hasEcotax'] ? 5 : 4], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(self::$order->total_shipping, self::$currency, true)), 0, 0, 'R');
			$this->Ln();
		}

		// Display wrapping tax
		if (self::$order->total_wrapping AND self::$order->total_wrapping != '0.00')
		{
			$tax = new Tax((int)(Configuration::get('PS_GIFT_WRAPPING_TAX')));
			$taxRate = $tax->rate;

			$nb_tax++;
			$before = $this->GetY();
			$lineSize = $this->GetY() - $before;
			$this->SetXY($this->GetX(), $this->GetY() - $lineSize + 3);
			$this->Cell($w[0], $lineSize, self::l('Gift-wrapping'), 0, 0, 'R');
			$this->Cell($w[1], $lineSize, number_format($taxRate, 3, ',', ' ').' %', 0, 0, 'R');
			$this->Cell($w[2], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice($priceBreakDown['wrappingCostWithoutTax'], self::$currency, true)), 0, 0, 'R');
			$this->Cell($w[3], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(self::$order->total_wrapping - $priceBreakDown['wrappingCostWithoutTax'], self::$currency, true)), 0, 0, 'R');
			$this->Cell($w[4], $lineSize, (self::$orderSlip ? '-' : '').self::convertSign(Tools::displayPrice(self::$order->total_wrapping, self::$currency, true)), 0, 0, 'R');
		}

		if (!$nb_tax)
			$this->Cell(190, 10, self::l('No tax'), 0, 0, 'C');
	}
	
	public function addShopAddress()
	{
		$address_head = 'Zing Ecommerce Pvt Ltd';
		$address = '#32A/189, Ground Floor, 7th Cross';
		$address .= "\n".'Gururaja Layout, Doddanekundi';
		$address .= "\n".'Bangalore - 560037';
		$address .= "\n".'Phone: +91-80-67309079';
		$address .= "\n".'Email: care@indusdiva.com';
		$address .= "\n".'TIN NO. - 29960626977';
		
		$this->SetY($this->GetY() + 10);
		$this->SetFont(self::fontname(), 'B', 11);
		$this->Cell(120, 10, $address_head, 'D', 1);
		$this->SetFont(self::fontname(), '', 8);
		$this->MultiCell(70, 5.0, $address, 0, 'L', 0);
		//$pdf->MultiCell(70, 6.0, $addressType[$type]['displayed'], 0, 'L', 0);
	}
	
	public function addShopAddress1()
	{
		$address_head = 'Zing Ecommerce Pvt Ltd';
		$address = 'No. 54, 5th Main';
		$address .= ' Kodihalli, HAL II nd Stage, Behind Leela Palace Hotel,';
		$address .= ' Bangalore - 560008';
		$address .= "\n".'Phone: +91-80-67309079 | ';
		$address .= 'Email: care@indusdiva.com | ';
		$address .= 'TIN - 29960626977';
	
		$this->SetY(-(21.0 + (4 * 7)));
		$this->SetFont(self::fontname(), 'B', 8);
		$this->Cell(120, 8, $address_head, 'D', 1);
		$this->SetY($this->GetY() - 2);
		$this->SetFont(self::fontname(), '', 8);
		$this->MultiCell(0, 4.0, $address, 0, 'L', 0);
		//$pdf->MultiCell(70, 6.0, $addressType[$type]['displayed'], 0, 'L', 0);
	}

	static protected function convertSign($s)
	{
		$arr['before'] = array('€', '£', '¥');
		$arr['after'] = array(chr(128), chr(163), chr(165));
		return str_replace($arr['before'], $arr['after'], $s);
	}

	static protected function l($string)
	{
		global $cookie;
		$iso = Language::getIsoById((isset($cookie->id_lang) AND Validate::isUnsignedId($cookie->id_lang)) ? $cookie->id_lang : Configuration::get('PS_LANG_DEFAULT'));

		if (@!include(_PS_TRANSLATIONS_DIR_.$iso.'/pdf.php'))
			die('Cannot include PDF translation language file : '._PS_TRANSLATIONS_DIR_.$iso.'/pdf.php');

		if (!isset($_LANGPDF) OR !is_array($_LANGPDF))
			return str_replace('"', '&quot;', $string);
		$key = md5(str_replace('\'', '\\\'', $string));
		$str = (key_exists('PDF_invoice'.$key, $_LANGPDF) ? $_LANGPDF['PDF_invoice'.$key] : $string);

		return (Tools::iconv('utf-8', self::encoding(), $str));
	}

	static public function encoding()
	{
		return (isset(self::$_pdfparams[self::$_iso]) AND is_array(self::$_pdfparams[self::$_iso]) AND self::$_pdfparams[self::$_iso]['encoding']) ? self::$_pdfparams[self::$_iso]['encoding'] : 'iso-8859-1';
	}

	static public function embedfont()
	{
		return (((isset(self::$_pdfparams[self::$_iso]) AND is_array(self::$_pdfparams[self::$_iso]) AND self::$_pdfparams[self::$_iso]['font']) AND !in_array(self::$_pdfparams[self::$_iso]['font'], self::$_fpdf_core_fonts)) ? self::$_pdfparams[self::$_iso]['font'] : false);
	}

	static public function fontname()
	{
		$font = self::embedfont();
		if (in_array(self::$_pdfparams[self::$_iso]['font'], self::$_fpdf_core_fonts))
			$font = self::$_pdfparams[self::$_iso]['font'];
		return $font ? $font : 'Arial';
 	}

}

