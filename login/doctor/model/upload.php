<?php
session_start();
require '../../../config/config.php';

$targetDir = "../../uploads/";
$fileName = baseName($_FILES["image"]["name"]);

$targetFilePath = $targetDir.$fileName;
$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

if(isset($_POST["chargesheet_pid"]) && isset($_POST["upload_date"]) && !empty($_FILES["image"]["name"]))
{
    //allow certains formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
    $patient_id = $_POST["chargesheet_pid"];
    echo $patient_id;
    $uploaded_on = $_POST["upload_date"];
    if(in_array($fileType, $allowTypes))
    {
        //upload file to save
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
            //insert image filename into db
            $query = "INSERT INTO images(patient_id, file_name, uploaded_on) VALUES('".$patient_id."', '".$fileName."', '".$uploaded_on."')";
            $result = $mysqli->query($query);
            if($result)
            {
                $statusMsg = "The file ".$fileName." has been iploaded successfuly.".$mysqli->error;
            }else{
                $statusMsg = "File upload failed please try again.".$mysqli->error;
            }
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = "Sorry, only JPG, JPEG, PNG, GIF and PDF allowed";
    }
}else{
    $statusMsg = "Please select a file to upload";
}

echo $statusMsg;
?>