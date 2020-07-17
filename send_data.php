<?php

    $con = mysqli_connect("localhost","root","","texlocker");

    if(isset($_POST)){
        $clue = $_POST["text-title"];
        $data = $_POST["text-body"];
    }

    $clue = mysqli_real_escape_string($con,$clue);
    $data = mysqli_real_escape_string($con,$data);

    $query_check_clue = "SELECT `clue` FROM `text-data` WHERE `clue` = '$clue'";

    $check = mysqli_query($con,$query_check_clue);

    $checker = mysqli_num_rows($check);

    if($checker > 0){
        $query_submit_data = "UPDATE `text-data` SET `data` = '$data' WHERE `clue` = '$clue'";
    }
    else{
        $query_submit_data = "INSERT INTO `text-data`(`clue`,`data`) VALUES ('$clue','$data')";
    }

    $fire = mysqli_query($con,$query_submit_data);

    mysqli_close($con);

?>