<?php
    require_once './app/models/finance.model.php';
    require_once './app/views/FinanceApiView.php';

    class FinanceApiController {
        private $model;
        private $view;

        public function __construct() {
            $this->model = new FinanceModel();
            $this->view = new FinanceApiView();
        }

        function showCompanies(){
            $companies = $this->model->getAllCompany();
            return $this->view->response($companies, 200);
        }
        function showCompany($params = []){
            $id = $params[":ID"];
            $companies = $this->model->getCompany($id);
            return $this->view->response($companies, 200);
        }




    }