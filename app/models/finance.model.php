<?php

class FinanceModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=finance;charset=utf8', 'root', '');
    }
    // filter
    //Prevenir inyeccion por contreller y la paginacion tiene dos parametros 
  

    function getAllCompanyPage($page){
        $cant = ($page-1) * 5;
        echo $cant;
        $query = $this->db->prepare("SELECT * FROM companies LIMIT 5 OFFSET $cant");
        $query->execute([]);
        $company = $query->fetchAll(PDO::FETCH_OBJ); 
        return $company;
    }


    function getAllCompany(){
        $query = $this->db->prepare("SELECT * FROM companies");
        $query->execute([]);
        $company = $query->fetchAll(PDO::FETCH_OBJ); 
        return $company;
    }

    function searchTiker($column, $name){
        $query = $this->db->prepare("SELECT * FROM companies WHERE $column LIKE '%$name%'");
        $query->execute([]);
        $company = $query->fetchAll(PDO::FETCH_OBJ); 
        return $company;
    }
    
    function getAllCompanyOrder($order , $sort) {
            echo "Ordenado por $order y de forma $sort ";
            $query = $this->db->prepare("SELECT * FROM companies ORDER BY $order $sort");
            $query->execute([]);
            $company = $query->fetchAll(PDO::FETCH_OBJ); 
            return $company;
    }

    function FilterCompany($sector, $order, $sort){
        echo "Filtrado por: $sector en orden de columna : $order y  de forma: $sort ";
        $query = $this->db->prepare("SELECT * FROM companies WHERE Sector = ? ORDER BY $order $sort");
        $query->execute([$sector]); 
        $companySector = $query->fetchall(PDO::FETCH_OBJ);
        return $companySector;
    }
   

    

    function getCompany($id) {
        $query = $this->db->prepare("SELECT * FROM companies WHERE id=?");
        $query->execute([$id]);
        $company = $query->fetch(PDO::FETCH_OBJ);
        return $company;
    }

    function deleteCompnayByname($id) {
       $query = $this->db->prepare('DELETE FROM companies WHERE id = ?');
       $query->execute([$id]);
   }

    
    function insertCompany($company , $sector , $tiker) {
        $query = $this->db->prepare("INSERT INTO companies (Company, Sector, Tiker) VALUES (?, ?, ?)");
        $query->execute([$company, $sector, $tiker]);
        return $this->db->lastInsertId();
    }

    function updateCompany($company , $sector , $tiker, $id){
        $query = $this->db->prepare("UPDATE companies SET Company=?, Sector=?, Tiker=? WHERE id=?");
        $query->execute([$company , $sector , $tiker, $id ]);
    }
}

