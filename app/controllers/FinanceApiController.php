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
        
        function showCompany($params = null){
            $tiker = $params[":ID"];
            $company = $this->model->getCompany($tiker);
            if($company)
                return $this->view->response($company, 200);
            else
                return $this->view->response("El tiker = $tiker no exite", 404);
        } 

        function updateCompany($params = null){
            $tiker = $params[":ID"];
            $body = $this->getBody();
            $company = $this->model->getCompany($tiker);
            if($company){
                $this->model->updateCompany($body->Company , $body->Sector, $body->Tiker);
                return $this->view->response("El tiker = $tiker fue modificado con exito", 200);
            }
            else{
                return $this->view->response("El tiker $tiker no fue modificado", 400);
            }
        } 
        
        function deleteCompany($params = null){
            $tiker = $params[":ID"];
            $company = $this->model->getCompany($tiker);
            if($company){
                $this->model->deleteCompnayByname($tiker);
                return $this->view->response("Borrado con exito", 200);
            } else{
                return $this->view->response("El tiker $tiker no existe", 404);
            }
        }


        function addCompany($params = null){
            //Refactorizar BD, agregarle id como primary
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