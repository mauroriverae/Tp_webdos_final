<?php
require_once 'libs/smarty-4.2.1/libs/Smarty.class.php';
class FinanceView {
    private $smarty;

    public function __construct() {

        $this->smarty = new Smarty();
    }
    
    function showCompany($companies) {
        $this->smarty->assign("companies", $companies);
        $this->smarty->display('templates/companytable.tpl');
    }
    
    function showSector($type, $sector){
        $this->smarty->assign("sector", $sector);
        $this->smarty->assign("type", $type);
        $this->smarty->display('templates/sectorT.tpl');
    }


    function showLoginLocation(){
        header("location: " .BASE_URL."login");
    }

    function UpdateCompany($company) {
        $this->smarty->assign("company", $company);
        $this->smarty->display('templates/update.tpl');
    }
}

        
