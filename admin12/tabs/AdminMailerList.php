<?php
@ini_set('max_execution_time', 0);

class AdminMailerList extends AdminTab
{
    
    
    public function postProcess()
    {
        global $currentIndex, $cookie, $smarty;
        $id_employee = (int)($cookie->id_employee);
        $db = Db::getInstance();
        $smarty->assign("preview", 'false');

        $sql = "select 
                m.id_campaign, 
                m.campaign_name,
                m.scheduled_time,
                m.date_add, 
                m.status, 
                m.template, 
                concat(e.firstname, ' ' , e.lastname) as created_by
                from ps_mailers m
                inner join ps_employee e
                    on m.id_employee = e.id_employee";
    
        $campaigns = $db->ExecuteS($sql);
        $smarty->assign("campaigns", $campaigns);
        $smarty->assign('currentIndex', $currentIndex);
        $smarty->assign('token', $this->token);
    }

    public function display()
    {
        global $smarty;
        $smarty->display(_PS_THEME_DIR_.'admin/mailer_list.tpl');
    }

}
