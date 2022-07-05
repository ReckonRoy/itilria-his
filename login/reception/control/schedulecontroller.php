<?php 
use login\reception\model\BookingAppointment;

require "../model/BookingAppointment.php";

if(isset($_POST['appointment']))
{
    $appointment = new BookingAppointment();
    $appointment->scheduleMonthYear();
}
?>