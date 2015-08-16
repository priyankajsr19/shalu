<?php
class MeasurementControllerCore extends FrontController
{
    public function __construct() {
        $this->auth = false;
        $this->php_self = 'measurement.php';
        $this->authRedirection = 'measurement.php';
        $this->ssl = true;
    
        parent::__construct();
    }
    
    public function preProcess() {
        global $cookie;
        $id_customer = $cookie->id_customer;
        if(Tools::getValue('modal')) {
            if(Tools::getValue('m') && Tools::getValue('type') == 1)
                $this->getMeasurementModal ();
            else if(Tools::getValue('m') && Tools::getValue('type') == 2)
                $this->getSkirtMeasurementModal ();
            else if(Tools::getValue('m') && Tools::getValue('type') == 3)
                $this->getKurtaMeasurementModal (1);
            else if(Tools::getValue('m') && Tools::getValue('type') == 4)
                $this->getSalwarMeasurementModal ();
            else if(Tools::getValue('m') && Tools::getValue('type') == 5)
                $this->getKurtaMeasurementModal (2);
            else if(Tools::getValue('bs'))
                $this->getBlouseStylesModal();
            else if(Tools::getValue('iss'))
                $this->getInskirtStylesModal();
        }
        else if(Tools::getValue('SubmitMeasurement') && Tools::getValue('type_measurement') == 1) {
            $this->handleBlouseMeasurement ();
        }
        else if(Tools::getValue('SubmitMeasurement') && Tools::getValue('type_measurement') == 2) {
            $this->handleSkirtMeasurement ();
        }
        else if(Tools::getValue('SubmitMeasurement') && Tools::getValue('type_measurement') == 3) {
            $this->handleKurtaMeasurement (1);
        }
        else if(Tools::getValue('SubmitMeasurement') && Tools::getValue('type_measurement') == 4) {
            $this->handleSalwarMeasurement ();
        }
        else if(Tools::getValue('SubmitMeasurement') && Tools::getValue('type_measurement') == 5) {
            $this->handleKurtaMeasurement (2);
        }
        else if($id_measurement = Tools::getValue('id_measurement')) {
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement FROM ps_blouse_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement 
                                                where m.id_measurement =" . $id_measurement);
            self::$smarty->assign("measurement", $res[0]);
        }
        else {
            if(Tools::getValue("delete")) {
                $id_measurement = Tools::getValue('id');
                $res = Db::getInstance()->ExecuteS("UPDATE ps_customer_measurements mc SET mc.is_deleted = 1 WHERE mc.id = " . $id_measurement);
                Tools::redirect("measurements.php");
            }
            
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement, mc.id as 'customer_measurement_id' FROM ps_blouse_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement where coalesce(mc.is_deleted, 0) < 1 and mc.type_measurement = 1 and mc.id_customer = " . $id_customer);
            if(count($res))
                self::$smarty->assign("blouse_measurements", $res);
            
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement, mc.id as 'customer_measurement_id' FROM ps_kurta_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement where coalesce(mc.is_deleted, 0) < 1 and mc.type_measurement = 3 and m.id_style=1 and mc.id_customer = " . $id_customer);
            if(count($res))
                self::$smarty->assign("kurta_measurements", $res);
            
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement, mc.id as 'customer_measurement_id' FROM ps_kurta_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement where coalesce(mc.is_deleted, 0) < 1 and mc.type_measurement = 3 and m.id_style=2 and mc.id_customer = " . $id_customer);
            if(count($res))
                self::$smarty->assign("anarkali_measurements", $res);
            
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement, mc.id as 'customer_measurement_id' FROM ps_skirt_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement where coalesce(mc.is_deleted, 0) < 1 and mc.type_measurement = 2 and mc.id_customer = " . $id_customer);
            if(count($res))
                self::$smarty->assign("skirt_measurements", $res);
            
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement, mc.id as 'customer_measurement_id' FROM ps_salwar_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement where coalesce(mc.is_deleted, 0) < 1 and mc.type_measurement = 4 and mc.id_customer = " . $id_customer);
            if(count($res))
                self::$smarty->assign("salwar_measurements", $res);
        }
    }
    
    private function handleSkirtMeasurement() {
        $name = Tools::getValue('name_measurement');

        $A = Tools::getValue('A');
        $B = Tools::getValue('B');
        $C = Tools::getValue('C');
    
        if($id_measurement = Tools::getValue('id_measurement')) {
            $sql = "UPDATE ps_skirt_measurements SET "
                    . " A = " . $A . ", "
                    . " B = " . $B . ", "
                    . " C = " . $C . " "
                    . " WHERE id_measurement = " . $id_measurement;
            Db::getInstance()->Execute($sql);
                
            if(Tools::getValue('ajax')) {
                die( Tools::jsonEncode(array(
                        'status' => 'succeeded',
                        'id_measurement' => $id_measurement
                )));
            }
            else {
                $res = Db::getInstance()->ExecuteS("SELECT m.* FROM ps_skirt_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement
                        where m.id_measurement =" . $id_measurement);
                self::$smarty->assign("measurement", $res[0]);
            }
        }
        else {
            Db::getInstance()->Execute("INSERT INTO ps_skirt_measurements (A, B, C, name)
                    VALUES ("
                    . $A . ", "
                    . $B . ", "
                    . $C . ", '"
                    . $name . "'
            )");
                
            if (!$id_measurement = Db::getInstance()->Insert_ID()) {
                self::$smarty->assign("error", "Error saving the measurement.");
                if(Tools::getValue('ajax')) {    
                    die( Tools::jsonEncode(array(
                            'status' => 'error'
                    )));
                }
            }
            else {
                $query = "INSERT INTO ps_customer_measurements(id_measurement, id_customer, name_measurement, type_measurement) VALUES("
                . $id_measurement. ", "
                . self::$cookie->id_customer . ", '"
                . $name . "', 2)";
                    
                Db::getInstance()->Execute($query);
                    
                $res = Db::getInstance()->ExecuteS("SELECT * FROM ps_skirt_measurements where id_measurement = " . $id_measurement);
                self::$smarty->assign("measurement", $res);
                    
                if(Tools::getValue('ajax')) {
                    die( Tools::jsonEncode(array(
                            'status' => 'succeeded',
                            'id_measurement' => $id_measurement,
                            'name' => $name
                    )));
                }
            }
        }
    }
    
    private function handleBlouseMeasurement($res, $query) {
        $name = Tools::getValue('name_measurement');
        
        $A = Tools::getValue('A');
        $B = Tools::getValue('B');
        $C = Tools::getValue('C');
        $D = Tools::getValue('D');
        $E = Tools::getValue('E');
        $F = Tools::getValue('F');
        $G = Tools::getValue('G');
        $H = Tools::getValue('H');
        $I = Tools::getValue('I');
        $J = Tools::getValue('J');
        $K = Tools::getValue('K');
        $L = Tools::getValue('L', 0);
        
        if($id_measurement = Tools::getValue('id_measurement')) {
            Db::getInstance()->Execute("UPDATE ps_blouse_measurements SET "
                    . " A = " . $A . ", "
                    . " B = " . $B . ", "
                    . " C = " . $C . ", "
                    . " D = " . $D . ", "
                    . " E = " . $E . ", "
                    . " F = " . $F . ", "
                    . " G = " . $G . ", "
                    . " H = " . $H . ", "
                    . " I = " . $I . ", "
                    . " J = " . $J . ", "
                    . " K = " . $K . ", "
                    . " L = " . $L 
                    . " WHERE id_measurement = " . $id_measurement);
            
            if(Tools::getValue('ajax')) {
                die( Tools::jsonEncode(array(
                        'status' => 'succeeded',
                        'id_measurement' => $id_measurement
                )));
            }
            else {
                $res = Db::getInstance()->ExecuteS("SELECT m.* FROM ps_blouse_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement
                        where m.id_measurement =" . $id_measurement);
                self::$smarty->assign("measurement", $res[0]);
            }
        }
        else
        {
            Db::getInstance()->Execute("INSERT INTO ps_blouse_measurements (A, B, C, D, E, F, G, H, I, J, K, L, name)
                    VALUES ("
                    . $A . ", "
                    . $B . ", "
                    . $C . ", "
                    . $D . ", "
                    . $E . ", "
                    . $F . ", "
                    . $G . ", "
                    . $H . ", "
                    . $I . ", "
                    . $J . ", "
                    . $K . ", "
                    . $L . ", '"
                    . $name . "'
            )");
            
            if (!$id_measurement = Db::getInstance()->Insert_ID()) {
                self::$smarty->assign("error", "Error saving the measurement.");
                if(Tools::getValue('ajax'))
                {
                    die( Tools::jsonEncode(array(
                            'status' => 'error'
                    )));
                }
            }
            else {
                $query = "INSERT INTO ps_customer_measurements(id_measurement, id_customer, name_measurement, type_measurement) VALUES("
                . $id_measurement. ", "
                . self::$cookie->id_customer . ", '"
                . $name . "', 1)";
                    
                Db::getInstance()->Execute($query);
                    
                $res = Db::getInstance()->ExecuteS("SELECT * FROM ps_blouse_measurements where id_measurement = " . $id_measurement);
                self::$smarty->assign("measurement", $res);
                    
                if(Tools::getValue('ajax')) {
                    die( Tools::jsonEncode(array(
                            'status' => 'succeeded',
                            'id_measurement' => $id_measurement,
                            'name' => $name
                    )));
                }
            }
        }
    }
    
    private function handleKurtaMeasurement($id_style) {
        $name = Tools::getValue('name_measurement');
    
        $A = Tools::getValue('A');
        $B = Tools::getValue('B');
        $C = Tools::getValue('C');
        $D = Tools::getValue('D');
        $E = Tools::getValue('E');
        $F = Tools::getValue('F');
        $G = Tools::getValue('G');
        $H = Tools::getValue('H');
        $I = Tools::getValue('I');
        $J = Tools::getValue('J');
        $K = Tools::getValue('K');
    
        if($id_measurement = Tools::getValue('id_measurement')) {
            Db::getInstance()->Execute("UPDATE ps_kurta_measurements SET "
                    . " A = " . $A . ", "
                    . " B = " . $B . ", "
                    . " C = " . $C . ", "
                    . " D = " . $D . ", "
                    . " E = " . $E . ", "
                    . " F = " . $F . ", "
                    . " G = " . $G . ", "
                    . " H = " . $H . ", "
                    . " I = " . $I . ", "
                    . " J = " . $J . ", "
                    . " K = " . $K
                    . " WHERE id_measurement = " . $id_measurement);
                
            if(Tools::getValue('ajax')) {
                die( Tools::jsonEncode(array(
                        'status' => 'succeeded',
                        'id_measurement' => $id_measurement
                )));
            }
            else {
                $res = Db::getInstance()->ExecuteS("SELECT m.* FROM ps_kurta_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement
                        where m.id_measurement =" . $id_measurement);
                self::$smarty->assign("measurement", $res[0]);
            }
        }
        else {
            Db::getInstance()->Execute("INSERT INTO ps_kurta_measurements (A, B, C, D, E, F, G, H, I, J, K, name, is_std, id_style)
                    VALUES ("
                    . $A . ", "
                    . $B . ", "
                    . $C . ", "
                    . $D . ", "
                    . $E . ", "
                    . $F . ", "
                    . $G . ", "
                    . $H . ", "
                    . $I . ", "
                    . $J . ", "
                    . $K . ", '"
                    . $name . "', 0, "
                    . $id_style ."
            )");
                
            if (!$id_measurement = Db::getInstance()->Insert_ID()) {
                self::$smarty->assign("error", "Error saving the measurement.");
                if(Tools::getValue('ajax')) {
                    die( Tools::jsonEncode(array(
                            'status' => 'error'
                    )));
                }
            }
            else {
                $query = "INSERT INTO ps_customer_measurements(id_measurement, id_customer, name_measurement, type_measurement) VALUES("
                . $id_measurement. ", "
                . self::$cookie->id_customer . ", '"
                . $name . "', 3)";
                    
                Db::getInstance()->Execute($query);
                    
                $res = Db::getInstance()->ExecuteS("SELECT * FROM ps_kurta_measurements where id_measurement = " . $id_measurement);
                self::$smarty->assign("measurement", $res);
                    
                if(Tools::getValue('ajax')) {
                    die( Tools::jsonEncode(array(
                            'status' => 'succeeded',
                            'id_measurement' => $id_measurement,
                            'name' => $name
                    )));
                }
            }
        }
    }
    
    private function handleSalwarMeasurement($res, $query) {
        $name = Tools::getValue('name_measurement');
        $A = Tools::getValue('A');
        $B = Tools::getValue('B');
        $C = Tools::getValue('C');
        $D = Tools::getValue('D');
        $E = Tools::getValue('E');
        $F = Tools::getValue('F');
    
        if($id_measurement = Tools::getValue('id_measurement'))
        {
            $sql = "UPDATE ps_salwar_measurements SET "
                    . " A = " . $A . ", "
                    . " B = " . $B . ", "
                    . " C = " . $C . ", "
                    . " D = " . $D . ", "
                    . " E = " . $E . ", "
                    . " F = " . $F
                    . " WHERE id_measurement = " . $id_measurement;
            Db::getInstance()->Execute($sql);
    
            if(Tools::getValue('ajax')) {
                die( Tools::jsonEncode(array(
                        'status' => 'succeeded',
                        'id_measurement' => $id_measurement
                )));
            }
            else {
                $res = Db::getInstance()->ExecuteS("SELECT m.* FROM ps_salwar_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement
                        where mc.type_measurement = 4 and m.id_measurement =" . $id_measurement);
                self::$smarty->assign("measurement", $res[0]);
            }
        }
        else {
            Db::getInstance()->Execute("INSERT INTO ps_salwar_measurements (A, B, C, D, E, F, name)
                    VALUES ("
                    . $A . ", "
                    . $B . ", "
                    . $C . ", "
                    . $D . ", "
                    . $E . ", "
                    . $F . ", '"
                    . $name . "'
            )");
    
            if (!$id_measurement = Db::getInstance()->Insert_ID()) {
                self::$smarty->assign("error", "Error saving the measurement.");
                if(Tools::getValue('ajax')) {
                    die( Tools::jsonEncode(array(
                            'status' => 'error'
                    )));
                }
            } else {
                $query = "INSERT INTO ps_customer_measurements(id_measurement, id_customer, name_measurement, type_measurement) VALUES("
                . $id_measurement. ", "
                . self::$cookie->id_customer . ", '"
                . $name . "', 4)";
                    
                Db::getInstance()->Execute($query);
                    
                $res = Db::getInstance()->ExecuteS("SELECT * FROM ps_salwar_measurements where id_measurement = " . $id_measurement);
                self::$smarty->assign("measurement", $res);
                    
                if(Tools::getValue('ajax')) {
                    die( Tools::jsonEncode(array(
                            'status' => 'succeeded',
                            'id_measurement' => $id_measurement,
                            'name' => $name
                    )));
                }
            }
        }
    }

    
    private function getMeasurementModal(){
        if($id_measurement = Tools::getValue('id_measurement')) {
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement FROM ps_blouse_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement 
                                            where mc.type_measurement = 1 and m.id_measurement =" . $id_measurement);
            self::$smarty->assign("measurement", $res[0]);
        }
        $size_data = array(
            array("&nbsp;","BUST SIZE (inches):","32","34","36","38","40","42"),
            array("A","Front Length","12.5","14","14.5","14.5","14.5","16"),
            array("B","Back Length","12.5","13","14","14","15","15"),
            array("C","Neck Deep","7.5","8","8","8.5","8.5","8.5"),
            array("D","Front Shape","11.5","12","12.5","12.5","14","14"),
            array("E","Bust","32.5","34.5","36","38","40","42"),
            array("F","Upper Waist","25.5","27","30","32","34","37"),
            array("G","Arm Hole","17","18.5","19","19.5","20","20.5"),
            array("H","Sleeve Length","4","5","5.5","6","6.5","7"),
            array("I","Sleeve Loose","11.5","12","12.5","13","14.5","15"),
            array("J","Back Deep","10","10","10","11","11","11"),
            array("K","Shoulder","14.5","15","15","15.5","16","17"),
            array("L","Long Choli Front Length","19","20","20","21","21","22")
        );
        self::$smarty->assign("size_data", $size_data);
        $spl_instr = array(
            "Please select a standard measurement by waist size or select \"Customized\" and enter your body measurement.",
            "The Designer blouses comes with padding up to bust size 42. The blouses above the specified size shall be designed without the padding.",
            "Classic Blouse Styles or Long Choli Styles shall not come with padding, irrespective of the size chosen."
        );
        self::$smarty->assign("uid_measurement","blouse_measurement_id");
        self::$smarty->assign("spl_instr", $spl_instr);
        self::$smarty->assign("measurement_indeces","A B C D E F G H I J K L");
        self::$smarty->assign("base_measurement","Bust");
        self::$smarty->assign("size_image","styles/blouse-measurement-choli.jpeg");
        self::$smarty->assign("type_measurement","1");
        self::$smarty->assign("chart_title","NEW MEASUREMENT");
        die(self::$smarty->display(_PS_THEME_DIR_.'common-measurement-form.tpl'));
    }
    
    private function getSkirtMeasurementModal() {
        if($id_measurement = Tools::getValue('id_measurement')) {
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement FROM ps_skirt_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement
                    where mc.type_measurement = 2 and m.id_measurement =" . $id_measurement);
            self::$smarty->assign("measurement", $res[0]);
        }
        $size_data = array(
            array("&nbsp;","WAIST SIZE (inches):","28","29","30","32","34","36"),
            array("A","Length","39","39.5","40","40.5","41","42"),
            array("B","Waist","28","29.5","30","32","34","36.5"),
            array("C","Hips","34.5","36","38.5","40.5","44.5","48.5"),
        );
        self::$smarty->assign("size_data", $size_data);
        $spl_instr = array(
            "Please select a standard measurement by waist size or select \"Customized\" and enter your body measurement.",
        );
        self::$smarty->assign("uid_measurement","skirt_measurement_id");
        self::$smarty->assign("spl_instr", $spl_instr);
        self::$smarty->assign("measurement_indeces","A B C");
        self::$smarty->assign("base_measurement","Waist");
        self::$smarty->assign("size_image","styles/skirt-measurement.jpg");
        self::$smarty->assign("type_measurement","2");
        self::$smarty->assign("chart_title","NEW MEASUREMENT");
        die(self::$smarty->display(_PS_THEME_DIR_.'common-measurement-form.tpl'));
    }
    
    private function getKurtaMeasurementModal($id_style) {
        if($id_measurement = Tools::getValue('id_measurement')) {
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement FROM ps_kurta_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement where mc.type_measurement = 3 and m.id_style = ".$id_style." AND m.id_measurement =" . $id_measurement);
            self::$smarty->assign("measurement", $res[0]);
        }
        
        //this size_data is tightly coupled with the sizechart tpl
        if($id_style == 1) {  // Kurta
            $size_data = array(
                array("&nbsp;","BUST SIZE (inches):","32","34","36","38","40","42"),
                array("A","Top Length","36","37","38","38.5","39","40"),
                array("B","Body Length","12.5","13","14","14","14.5","14.5"),
                array("C","Shoulder","14.5","15","15","15.5","16","17"),
                array("D","Arm Hole","19","19","19.5","19.5","20","20.5"),
                array("E","Sleeve Length","5.5","5.5","5.5","6","6","6"),
                array("F","Sleeve Loose","11.5","12","12.5","13","14","15"),
                array("G","Neck Deep","7.5","7.5","7.5","7.5","8","8.5"),
                array("H","Front Shape","11.5","12","12.5","12.5","13","14"),
                array("I","Chest","32","34","36","38","40","42"),
                array("J","Waist","28","30","32","36.5","38.5","40.5"),
                array("K","Hips","34.5","36","38.5","40.5","44.5","48.5"),
            );
            $spl_instr_post = array(
                "*All Measurements in Inches",
            );
            self::$smarty->assign("spl_instr_post", $spl_instr_post);
            self::$smarty->assign("size_data", $size_data);
            self::$smarty->assign("size_image","styles/kurta2.png");
            self::$smarty->assign("type_measurement","3");
            self::$smarty->assign("chart_title","KURTA MEASUREMENT");
        }
        else { //Anarkali
            $size_data = array(
                array("&nbsp;","BUST SIZE (inches):","32","34","36","38","40","42"),
                array("A","Top Length","42","42","43","43","44","44"),
                array("B","Body Length","12.5","13","13.5","13.5","14","14.5"),
                array("C","Shoulder","14.5","15","15","15.5","16","17"),
                array("D","Arm Hole","19","19","19.5","19.5","20","20.5"),
                array("E","Sleeve Length","5.5","5.5","5.5","6","6","6"),
                array("F","Sleeve Loose","11.5","12","12.5","13","14","15"),
                array("G","Neck Deep","7.5","7.5","7.5","7.5","8","8.5"),
                array("H","Front Shape","11.5","12","12.5","12.5","13","14"),
                array("I","Chest","32","34","36","38","40","42"),
                array("J","Waist","28","30","32","36.5","38.5","40.5"),
                array("K","Hips ","34.5","36","38.5","40.5","44.5 ","48.5")
            );
            $spl_instr_post = array(
                "*All Measurements in Inches",
                "*The minimum length for an Anarkali is 40 inches as recommended by the IndusDiva Design Studio"
            );
            self::$smarty->assign("spl_instr_post", $spl_instr_post);
            self::$smarty->assign("size_data", $size_data);
            self::$smarty->assign("size_image","styles/anarkali-2.png");
            self::$smarty->assign("type_measurement","5");
            self::$smarty->assign("chart_title","ANARKALI MEASUREMENT");
        }
        $spl_instr = array(
            "Please select a standard measurement by bust size or select \"Customized\" and enter your body measurement.",
            "The measurements provided in our form are body measurements. If you are feeding in your own customized dimensions, even then please provide us with body measurements. These are sought to understand your body size better so that we can give you the exact same look as you see in the image ( the pattern of the kurta will be as per the picture and so will be the sleeves ). Our Design Studio shall decide the garment measurements according to the body measurements provided and design the outfit to fit you best."
        );
        self::$smarty->assign("uid_measurement","kurta_measurement_id");
        self::$smarty->assign("base_measurement","Bust");
        self::$smarty->assign("measurement_indeces","A B C D E F G H I J K");
        self::$smarty->assign("spl_instr", $spl_instr);
        die(self::$smarty->display(_PS_THEME_DIR_.'common-measurement-form.tpl'));
    }
    
    private function getSalwarMeasurementModal() {
        if($id_measurement = Tools::getValue('id_measurement')) {
            $res = Db::getInstance()->ExecuteS("SELECT m.*, mc.name_measurement FROM ps_salwar_measurements m inner join ps_customer_measurements mc on mc.id_measurement = m.id_measurement
                    where mc.type_measurement = 4 and m.id_measurement =" . $id_measurement);
            self::$smarty->assign("measurement", $res[0]);
        }
        $size_data = array(
            array("&nbsp;","WAIST SIZE (inches):","28","29","30","32","34","36"),
            array("A","Waist","28","29.5","30","32","34","36.5"),
            array("B","Length","39","40","41","42","42","43"),
            array("C","Knee Length","20","21.5","21","22","22.5","23"),
            array("D","Knee Loose","17","18","19","19.5","20","21"),
            array("E","Thigh","22","24","26","28","30","32"),
            array("F","Ankle Loose","9.5","10","10","10.5","10.5","11"),
        );
        self::$smarty->assign("size_data", $size_data);
        $spl_instr = array(
            "Please select a standard measurement by waist size or select \"Customized\" and enter your body measurement.",
        );
        self::$smarty->assign("uid_measurement","salwar_measurement_id");
        self::$smarty->assign("spl_instr", $spl_instr);
        self::$smarty->assign("measurement_indeces","A B C D E F");
        self::$smarty->assign("base_measurement","Waist");
        self::$smarty->assign("size_image","styles/salwar-measurement.jpg");
        self::$smarty->assign("type_measurement","4");
        self::$smarty->assign("chart_title","SALWAR MEASUREMENT");
        die(self::$smarty->display(_PS_THEME_DIR_.'common-measurement-form.tpl'));
    }
    
    private function getBlouseStylesModal(){
        $res = Db::getInstance()->ExecuteS("SELECT * FROM ps_styles WHERE style_type = 1");
        self::$smarty->assign("styles", $res);
        die(self::$smarty->display(_PS_THEME_DIR_.'blouse-styles-form.tpl'));
    }
    
    private function getInskirtStylesModal(){
        if(Tools::getValue('lehenga'))
            self::$smarty->assign('default_displayed', true);
        die(self::$smarty->display(_PS_THEME_DIR_.'petticoat-styles-form.tpl'));
    }
    
    public function displayContent()
    {
        parent::displayContent();
        self::$smarty->display(_PS_THEME_DIR_.'measurements.tpl');
    }
}

