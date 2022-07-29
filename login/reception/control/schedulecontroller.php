<?php 
use login\reception\model\BookingAppointment;

require "../model/BookingAppointment.php";

if(isset($_POST['appointment']))
{
    $appointment = new BookingAppointment();
    $appointment->scheduleMonthYear();
}else if(isset($_POST['month_day']))
{
    $month_day = $_POST["month_day"];
    $appointment = new BookingAppointment();
    $appointment->scheduleMonthDay($month_day);
}else if(isset($_POST['appointment_date']) && isset($_POST['appointment_reason']) && isset($_POST['patient_id'])){
    $app_date = $_POST['appointment_date'];
    $app_reason = $_POST['appointment_date'];
    $patient_id = $_POST['patient_id'];
    
    $appointment = new BookingAppointment();
}else{
    echo json_encode([false, "not set"]);
}
?>