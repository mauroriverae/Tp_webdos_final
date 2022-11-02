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


        //Refactorizar BD, agregarle id como primary
        function addCompany(){
            $body = $this->getBody();

            if(!empty($body->Company)&& !empty($body->Sector)&& !empty($body->Tiker)){
                $this->model->insertCompany($body->Company , $body->Sector , $body->Tiker);
                return $this->view->response("Agregado con exito", 200);
            }else {
                return $this->view->response("Faltan completar campos", 400);
            }
        }

        private function getBody(){
            $bodyString= file_get_contents("php://input");
            return  json_decode($bodyString);
        }

    }