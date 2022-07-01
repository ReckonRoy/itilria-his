<?php
namespace login\admin\model;

class Dashboard
{
    private $userstats_array = array();
    
    function getPatientStatistics($mysqli){
        //***stats the hospital or facility we are pulling the results from
        $query = "SELECT count(id) FROM patient";
        $result = $mysqli->query($query);
        $row = $result->fetch_array(MYSQLI_NUM);
        $record = $row[0];
        $this->userstats_array["patients"] = $record;
    }
    
    function getDoctorStatistics($mysqli){
        //***stats the hospital or facility we are pulling the results from
        $profession = "doctor";
        $query = "SELECT count(id) FROM employee_details WHERE profession='".$profession."'";
        $result = $mysqli->query($query);
        $row = $result->fetch_array(MYSQLI_NUM);
        $record = $row[0];
        $this->userstats_array["doctors"] = $record;
    }
    
    function getNurseStatistics($mysqli){
        //***stats the hospital or facility we are pulling the results from
        $profession = "nurse";
        $query = "SELECT count(id) FROM employee_details WHERE profession='".$profession."'";
        $result = $mysqli->query($query);
        $row = $result->fetch_array(MYSQLI_NUM);
        $record = $row[0];
        $this->userstats_array["nurses"] = $record;
    }
    
    function getReceptionStatistics($mysqli){
        //***stats the hospital or facility we are pulling the results from
        $profession = "receptionist";
        $query = "SELECT count(id) FROM employee_details WHERE profession='".$profession."'";
        $result = $mysqli->query($query);
        $row = $result->fetch_array(MYSQLI_NUM);
        $record = $row[0];
        $this->userstats_array["receptionist"] = $record;
    }
    
    function getStatsCount()
    {
        echo json_encode([true, $this->userstats_array]);
    }
}

