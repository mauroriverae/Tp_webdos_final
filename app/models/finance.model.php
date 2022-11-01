<?php

class FinanceModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=finance;charset=utf8', 'root', '');
    }

    public function getAllCompany() {
        $query = $this->db->prepare("SELECT * FROM companies");
        $query->execute();
        $company = $query->fetchAll(PDO::FETCH_OBJ); 
        return $company;
    }
    //NO ANDA 
    function getCompany($id) {
        $query = $this->db->prepare("SELECT * FROM companies WHERE Tiker=?");
        $query->execute([$id]);
        $company = $query->fetch(PDO::FETCH_OBJ);
        return $company;
    }

    function deleteCompnayByname($company) {
       $query = $this->db->prepare('DELETE FROM companies WHERE Company = ?');
       $query->execute([$company]);
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

    function updateCompany($company , $sector , $tiker){
        $query = $this->db->prepare("UPDATE companies SET Company=?, Sector=?, Tiker=? WHERE Tiker=?");
        $query->execute([$company , $sector , $tiker, $tiker ]);
    }

}

