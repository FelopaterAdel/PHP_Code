<?php

include('template/header.php');
include('template/content.php');
?>


<?php
if (isset($_POST['submit'])) {

    
$name = ($_POST['name']);
$Email = ($_POST['email']);
$password = ($_POST['password']);
$ext = ($_POST['ext']);
$room_no = ($_POST['room_no']) ;


$file=fopen("info.txt" ,"a");
fwrite($file ,$name."\n");
fwrite($file ,$Email."\n");
fwrite($file ,$password."\n");
fwrite($file ,$ext."\n");
fwrite($file ,$room_no."\n");

move_uploaded_file($_FILES['Image']['tmp_name'],'imgs/'.basename($_FILES['Image']['name']));

fclose($file);

    
}


?>