<?php
namespace login\reception\model;

class BookingAppointment
{
    function scheduleMonthYear(){
        
        $exploded_date = date("Y-m-d");
        $exploded_date = explode('-', $exploded_date);
        $year = $exploded_date[0];
        $month = $exploded_date[1];
        $numdays = date("t", mktime(0, 0, 0, $month, 1, $year));
        $dates_array = array();
        
        //this for loop dtermines the next 24 months starting from the current month
        for($count = 0; $count < 24; $count++)
        {
            $displaydate = date("F Y", mktime(0, 0, 0, $month, 1, $year));
            $month = $month + 1;
            $nextmonth = ($month)."-".$year;
            
            if($month > 12) {
                $month = 1;
                $year = $year+1;
                $nextmonth = $month.'-' . ($year);
            }else{
                $nextmonth = ($month) . "-" . $year;
            }
            
            array_push($dates_array, $displaydate);
        }
        
        json_encode([true, $dates_array]);
    }
}

