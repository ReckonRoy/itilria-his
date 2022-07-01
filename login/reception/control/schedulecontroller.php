<?php 
use login\reception\model\BookingAppointment;

require "../model/BookingAppointment.php";

$appointment = new BookingAppointment();
$appointment->scheduleMonthYear();
?>