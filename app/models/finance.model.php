<?php

class FinanceModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=finance;charset=utf8', 'root', '');
    }

    public function getAllCompany($order, $sort) {
        if($order == "Sector" && $sort == "DESC"){
            echo "Ordenado por $order y de forma $sort";
            $query = $this->db->prepare("SELECT * FROM companies ORDER BY Sector DESC");
            $query->execute([]);
            $company = $query->fetchAll(PDO::FETCH_OBJ); 
            return $company;
        }
        if(($order == "Sector" && $sort == "ASC")){
            echo "Ordenado por $order y de forma $sort";
            $query = $this->db->prepare("SELECT * FROM companies ORDER BY Sector ASC");
            $query->execute([]);
            $company = $query->fetchAll(PDO::FETCH_OBJ); 
            return $company;
        } else{
            echo "No hay orden declarado";
            $query = $this->db->prepare("SELECT * FROM companies");
            $query->execute([]);
            $company = $query->fetchAll(PDO::FETCH_OBJ); 
            return $company;
        }
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

    function FilterCompany($sector){
        $query = $this->db->prepare('SELECT * FROM companies WHERE Sector = ?');
        $query->execute([$sector]); 
        $companySector = $query->fetchall(PDO::FETCH_OBJ);
        return $companySector;
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

