<?php

    $con = mysqli_connect("localhost","root","","texlocker");

    if(isset($_POST)){
        $clue = $_POST["clue"];
    }

    $clue = mysqli_real_escape_string($con,$clue);

    $query = "SELECT `data` FROM `text-data` WHERE clue = '$clue'";

    $fire = mysqli_query($con,$query);

    $row = mysqli_fetch_array($fire);


    if(!$row){
        echo 'Data Not Found !!!';
    }
    else{
        echo $row['data'];
    }

    mysqli_close($con);

?>