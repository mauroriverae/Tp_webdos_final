<?php
    require_once './app/models/finance.model.php';
    require_once './app/views/FinanceApiView.php';

    class FinanceApiController {
        private $model;
        private $view;
        private $data;

        public function __construct() {
            $this->model = new FinanceModel();
            $this->view = new FinanceApiView();
            $this->data = file_get_contents("php://input");
        }

    

        function showCompanies(){
            //faltan validaciones
            //http://localhost/web2/TpFinal/Tp_webdos_final/api/company?order=Tiker&sort=ASC
            //ORDEN 
            if(isset($_GET['column']) and isset($_GET['search'])){
                $column = $_GET['column'];
                $name = $_GET['search'];
                if($column === "Sector" ||$column === "Tiker" || $column === "Company" || $column === "id" ){
                    $company = $this->model->searchTiker($column, $name);
                    if($company)
                     return $this->view->response($company, 200);
                    else
                        return $this->view->response("El Tiker no existe o el parametro es incorrecto", 404);
                }
                else{
                    return $this->view->response("La columna es incorrecta", 404);
                }
            }

            if( isset($_GET['order']) || isset($_GET['sort']) || isset($_GET['filter'])){

                if(isset($_GET['order']) and isset($_GET['sort'])){
                    $order = ucfirst($_GET['order']);
                    $sort = strtoupper($_GET['sort']);
                    if($order === "Sector" || $order === "Tiker" || $order === "Company" and $sort === "ASC" || $sort === "DESC" ){
                        $companies = $this->model->getAllCompanyOrder($order, $sort);
                        return $this->view->response($companies, 200);
                    }
                    else{   
                        return $this->view->response("El parametro ingresado es incorrecto", 400); //revisa si no va un 200 y p
                    }
                }

                // FILTRO + ORDEN + ASC O DESC
                elseif (isset($_GET['filter']) and isset($_GET['column']) and isset($_GET['sort'])){
                    $filter = $_GET['filter'];
                    $order = ucfirst($_GET['column']);
                    $sort = strtoupper($_GET['sort']);
                    if ($filter === 'Tecnologia' || $filter==='Servicios de comunicacion'  || $filter==='Materiales Basicos' || $filter==='Industriales' || $filter==='Energia' || $filter==='Servicios financieros' || $filter==='Consumo discrecional'and $sort === "ASC" || $sort=== "DESC" and $order === "Sector" || $order === "Tiker" || $order === "id" || $order === "Company") {
                        $companies = $this->model->FilterCompany($filter, $order, $sort);
                        return $this->view->response($companies, 200);  
                    }else{
                        return $this->view->response("El parametro ingresado es incorrecto", 400); //revisa si no va un 200 y p
                    }
                }
                // SOLO FILTRO
                elseif(isset($_GET['filter'])){
                    $filter = ucfirst($_GET['filter']);
                    if ($filter === 'Tecnologia' || $filter==='Servicios de comunicacion'  || $filter==='Materiales Basicos' || $filter==='Industriales' || $filter==='Energia' || $filter==='Servicios financieros' || $filter==='Consumo discrecional') {
                        $companies = $this->model->FilterCompany($filter, "Company", "ASC");
                        return $this->view->response($companies, 200);  
                    }else{
                        return $this->view->response("El parametro ingresado es incorrecto", 400); //revisa si no va un 200 y p
                    }
                }
            }
            else{
                if(isset($_GET['page'])){
                    if( is_numeric($_GET['page'])){
                        $page= $_GET['page'];
                            $companies = $this->model->getAllCompanyPage($page);
                            return $this->view->response($companies, 200);
                    } else{
                        return $this->view->response("Para paginar debe ingresar un valor numerico", 404);
                    }
                }else{
                    $companies = $this->model->getAllCompany();
                    return $this->view->response($companies, 200);
                }
            }
        }

        
        function showCompany($params = null){
            $id = $params[":ID"];
            if(is_numeric($id)){
                $company = $this->model->getCompany($id);
                if($company)
                    return $this->view->response($company, 200);
                else
                    return $this->view->response("El tiker con $id no exite", 404);
            } else{
                return $this->view->response("El id tiene que ser numerico", 404);
            }
        } 

        function showSector($params = null){
            $sector = $params[":ID"];
            echo $sector;
            $companies = $this->model->FilterCompany($sector);
            if($companies)
                return $this->view->response($companies, 200);
            else
                return $this->view->response("El $sector no existe", 404);
        } 

        function updateCompany($params = null){
            $id = $params[":ID"];
            $body = $this->getBody();
            $company = $this->model->getCompany($id);
            if($company){
                if(!empty($body->Company)&& !empty($body->Sector) &&!empty($body->Tiker)){
                    $tiker = strtoupper($body->Tiker);
                    $company = ucwords($body->Company);
                    $this->model->updateCompany($company, $body->Sector, $tiker, $id);
                    $company = $this->model->getCompany($id);
                    return $this->view->response($company , 200);
                } else{
                    return $this->view->response("Complete todos los campos para modificar", 409);
                }
            }
            else{
                return $this->view->response("El tiker con $id no fue modificado", 400);
            }
        } 
        
        function deleteCompany($params = null){
            $id = $params[":ID"];
            $company = $this->model->getCompany($id);
            if($company){
                $this->model->deleteCompnayByname($id);
                return $this->view->response("Borrado con exito", 200);
            } else{
                return $this->view->response("El tiker $tiker no existe", 404);
            }
        }


        function addCompany($params = null){
            //Refactorizar BD, agregarle id como primary
            $body = $this->getBody();
            $tiker = strtoupper($body->Tiker);
            $company = ucwords($body->Company);
            if(!empty($company)&& !empty($body->Sector)&& !empty($tiker)){
                $id = $this->model->insertCompany(ucwords($body->Company) , $body->Sector , $tiker);
                $company = $this->model->getCompany($id);
                return $this->view->response($company, 201);
            }else {
                return $this->view->response("Faltan completar campos", 409);
            }
           
        }

        private function getBody(){
            return  json_decode($this->data);
        }
 
    }