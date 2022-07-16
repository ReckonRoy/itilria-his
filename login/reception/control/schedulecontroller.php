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
}else{
    echo json_encode([false, "not set"]);
}
?>