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
        
        echo json_encode([true, $dates_array, "appointment"]);
    }
    
    function scheduleMonthDay($month_day){
        
        $month_day = explode(' ', $month_day);
        $year = $month_day[1];
        $month = $month_day[0];
        $months = array(
            'January'=>1, 'February'=>2, 'March'=>3, 'April'=>4, 'May'=>5, 'June'=>6, 'July'=>7, 'August'=>8,
            'September'=>9, 'October'=>10, 'November'=>11, 'December'=>12
            
        );
        
        if(array_key_exists($month, $months))
        {
            $month = $months[$month];
        }
        
        //get current month and year 
        $todayyear = date("Y");
        $todaymonth = date("n");
        $todayday = date("d");
        
        //get number of days in this month
        $numdays = date("t", mktime(0, 0, 0, $month, 1, $year));
        $count = 0;
        if(($todaymonth == $month) && ($todayyear == $year))
        {
            $count = $todayday;
        }else{
            $count = 1;
        }
        do{
            
            $display = date("jS", mktime(0, 0, 0, $month, $count, $year));
            echo json_encode([true, $display, "month_day"]);
            $count++;
        }while($count <= $numdays + 1);
       
    }
}

