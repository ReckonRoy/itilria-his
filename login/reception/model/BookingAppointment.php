<?php
namespace login\reception\model;

class BookingAppointment
{
    private $patient_id = null;
    private $reason_for_appointment = null;
    private $appointment_date = null;
    private $date_heading = null;
    private $appointment_time = null;
    private $status = null;
    private $patient_come_into_hospital = null;
    
    function scheduleMonthYear(){
        $exploded_date = date("Y-m-d");
        $exploded_date = explode('-', $exploded_date);
        $year = $exploded_date[0];
        $month = $exploded_date[1];
        $dates_array = array();
        
        //this for loop dtermines the next 24 months starting from the current month
        for($count = 0; $count < 24; $count++)
        {
            $displaydate = date("F Y", mktime(0, 0, 0, $month, 1, $year));
            $month = $month + 1;
            
            if($month > 12) {
                $month = 1;
                $year = $year+1;
            }
            array_push($dates_array, $displaydate);
        }
        echo json_encode([true, $dates_array, "appointment"]);
    }
    
    function scheduleMonthDay($month_day){
        $days = array();
        $month_day = explode(' ', $month_day);
        $year = $month_day[1];
        $month_key = $month_day[0];
        $months = array(
            'January'=>1, 'February'=>2, 'March'=>3, 'April'=>4, 'May'=>5, 'June'=>6, 'July'=>7, 'August'=>8,
            'September'=>9, 'October'=>10, 'November'=>11, 'December'=>12);
        
        if(array_key_exists($month_key, $months))
        {
            $month = $months[$month_key];
        }
        
        //get current month and year 
        $todayyear = date("Y");
        $todaymonth = date("n");
        $todayday = date("d");
        
        //get number of days in this month
        $numdays = date("t", mktime(0, 0, 0, $month, 1, $year));
        
        
        $count = 1;
        if(($todaymonth == $month) && ($todayyear == $year))
        {
            $count = $todayday;
        }else{
            $count = 1;
        }
        do{
            $display = date("jS", mktime(0, 0, 0, $month, $count, $year));
            $day = date("l", mktime(0, 0, 0, $month, $count, $year));
            $day_date = $day." ".$display." ".$month_key." ".$year;
            array_push($days, $day_date);
            $count++;            
        }while($count <= $numdays);
        echo json_encode([true, $days, "month_day"]);
    }
    
    /*
     * save the appointment date to database
     * the patient must be under linked to the hospital they have the appointment on and registered with
     * get the company the booking employee is on
     */
    function escapeString($arg1, $arg2){
       return mysqli_real_escape_string($arg1, $arg2);
    }
    
    /**
     * 
     * @param int $p_id
     * @param string $reason_for_appointment
     * @param string $appointment_date
     * @param string $status
     * @param string $patient_come_into_hospital
     */
    
    function setSaveAppointmentParams($p_id, $reason_for_appointment, $appointment_date, $appointment_time/*, $status, $patient_come_into_hospital*/){
        $this->patient_id = $p_id;
        $this->reason_for_appointment = $reason_for_appointment;
        $this->date_heading = $appointment_date;
        $date_array = explode(" ", $appointment_date);
        $day_name = $date_array[0];
        $day = substr($date_array[1], 0, strlen($date_array[1])-2);
        $month_key = $date_array[2];
        $year = $date_array[3];
        
        $months = array(
            'January'=>1, 'February'=>2, 'March'=>3, 'April'=>4, 'May'=>5, 'June'=>6, 'July'=>7, 'August'=>8,
            'September'=>9, 'October'=>10, 'November'=>11, 'December'=>12);
        $month = null;
        if(array_key_exists($month_key, $months))
        {
            $month = $months[$month_key];
        }
        $this->appointment_date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
        $this->appointment_time = $appointment_time;
    }
    
    function setAppointmentParams($p_id, $reason_for_appointment, $appointment_date, $appointment_time, $status, $patient_come_into_hospital){
        $this->patient_id = $p_id;
        $this->reason_for_appointment = $reason_for_appointment;
        $this->appointment_time = $appointment_time;
        $this->status = $status;
        $this->patient_come_into_hospital = $patient_come_into_hospital;
    }
    
    /**
     * get params
     */
    function getPatientId(){
        return $this->patient_id;
    }
    
    function getReasonAppointment(){
        return $this->reason_for_appointment;
    }
    
    function getAppointmentDateHeading(){
        return $this->date_heading;
    }
    
    function getAppointmentDate(){
        return $this->appointment_date;
    }
    
    function getAppointmentTime(){
        return $this->appointment_time;
    }
    function getStatus()
    {
        return $this->status;
    }
    
    function getPatientComeIntoHospital() {
        return $this->patient_come_into_hospital;
    }
    /*******************************************************************************************************************************************/
    function saveAppointment($staff_id, $mysqli)
    {
        //get company id
        $query = "SELECT co_id FROM credentials WHERE id='". mysqli_real_escape_string($mysqli, $staff_id)."'";
        $result = $mysqli->query($query);
        if($result->num_rows != 0){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $co_id = $row['co_id'];
            
            //save appointment
            $query = "INSERT INTO appointment_table(co_id, receptionist_id, patient_id, reason_for_appointment, appointment_date_heading, appointment_date, appointment_time, date_of_booking, time_of_booking) VALUES('".$this->escapeString($mysqli, $co_id)."', '".$this->escapeString($mysqli, $staff_id)."', '".$this->escapeString($mysqli, $this->getPatientId())."','".$this->escapeString($mysqli, $this->getReasonAppointment())."','".$this->escapeString($mysqli, $this->getAppointmentDateHeading())."','".$this->escapeString($mysqli, $this->getAppointmentDate())."','".$this->escapeString($mysqli, $this->getAppointmentTime())."', '".date('Y-m-d')."', '".date('H:m')."')";
            $result = $mysqli->query($query);
            if($result)
            {
                echo json_encode(['true', 'appointment_saved', 'success']);
            }else{
                echo json_encode(['false', $mysqli->error, 'error']);
            }
        }else{
            echo json_encode(['false', $mysqli->error, 'error']);
        }
        
        
    }
}