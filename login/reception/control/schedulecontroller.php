<?php 
use login\reception\model\BookingAppointment;
require "../../../config/config.php";
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
}else if(isset($_POST['appointment_date']) && isset($_POST['appointment_reason']) && isset($_POST['patient_id']) && isset($_POST['staff_id'])){
    $appointment_date = $_POST['appointment_date'];
    $reason_for_appointment = $_POST['appointment_reason'];
    $patient_id = $_POST['patient_id'];
    $staff_id = $_POST['staff_id'];
    
    $appointment = new BookingAppointment();
    $appointment->setSaveAppointmentParams($patient_id, $reason_for_appointment, $appointment_date, date("h:m"));
    $appointment->saveAppointment($staff_id, $mysqli);
}else{
    echo json_encode([false, "not set", "error"]);
}
?>