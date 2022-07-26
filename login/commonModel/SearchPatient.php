<?php
class SearchPatient{

    //search patient by patient id
    //if patient exist display patient results
    //return patient name, surname and patient id
    function searchPatientID($mysqli, $p_id){
        $query = "SELECT patient_id, name, surname FROM patient WHERE patient_id LIKE '".$p_id.'%'."' LIMIT 6";
        $result = $mysqli->query($query);
        if($result->num_rows != 0)
        {
            while($row = $result->fetch_array(MYSQLI_ASSOC))
            {
                $all_rows[] = $row;
            }
            echo json_encode([true, $all_rows]);
        }else{
            $this->error_msg .= "PatientId does not exist!".$mysqli->error;
            echo json_encode([false, $this->error_msg]);
        }
    }
}
?>