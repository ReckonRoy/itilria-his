<?php
use login\admin\model\Dashboard;

require "../../../config/config.php";
require "../model/Dashboard.php";

if(isset($_POST['patient_id'])){
    $dashboard = new Dashboard();
    $dashboard->getPatientStatistics($mysqli);
    $dashboard->getDoctorStatistics($mysqli);
    $dashboard->getNurseStatistics($mysqli);
    $dashboard->getReceptionStatistics($mysqli);
    $dashboard->getStatsCount();
}else{
    json_encode([false, "variable is not set"]);
}