<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (empty($_POST['first_name'])) {
    echo "<h1 > No data received! </h1>";
    exit();
}
$first_name = ($_POST['first_name']);
$last_name = ($_POST['last_name']);
$address = ($_POST['address']);
$gender = ($_POST['gender']);
$skills = ($_POST['skills']) ?$_POST['skills'] : ["None"];
$title = ($gender == "Male") ? "Mr." : "Miss";



$file=fopen("info.txt" ,"w");
fwrite($file ,$first_name."\n");
fwrite($file ,$last_name."\n");
fwrite($file ,$address."\n");
fwrite($file ,$gender."\n");
fwrite($file ,implode(" - ", $skills)."\n");
fclose($file);



echo '
    <style>
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            font-size: 18px;
        }
        table, th, td {
            border: 3px solid black;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
    </style>

    <div class="container mt-5">
        <h2 class="text-center">Review</h2>

        <p class="text-center">Thanks ' . $title . ' ' . ($first_name) . ' ' . ($last_name) . '</p>
        
        <h4 class="text-center">Please Review Your Information:</h4>

        <table class="table table-striped">
            <tr>
                <th>Name</th>
                <td>' . ($first_name) . ' ' . ($last_name) . '</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>' . ($address) . '</td>
            </tr>
            <tr>
                <th>Your Skills</th>
                <td>' . (implode(" - ", $skills)) . '</td>
            </tr>
            <tr>
                <th>Department</th>
                <td>OpenSource</td>
            </tr>
            <tr>
              <tr>
            <th><a href="#">Update</a></th>
            <td><a href="#">Delete</a></td>
        </tr> </tr>
        </table>
    </div>';

?>
