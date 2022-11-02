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
            if($companies){
                return $this->view->response($companies, 200);
            } else{
                return $this->view->response("La base de datos esta vacia", 204);
            }
        }
        function showCompany($params = null){
            $id = $params[":ID"];
            $company = $this->model->getCompany($id);
            if($company){
                return $this->view->response($company, 200);
            } else{
                return $this->view->response("La emprasa con el tiker $id no existe", 404);
            }
        } 
        
        function deleteCompany($params = null) {
            $id=$params[":ID"];
            $company = $this->model->getCompany($id);
            if($company){
                $this->model->deleteCompnayByname($id);
                return $this->view->response("El tiker $id fue borrado con exito", 200);
            } else{
                return $this->view->response("no se pudo eliminar $id ", 400);
            }
        }

    }