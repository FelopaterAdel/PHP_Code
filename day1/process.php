<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

if ($_POST['verification_code']!=="Sh68Sa") {
    echo "<h1 >wrong verification_code  </h1>";
    exit();
}
$first_name = ($_POST['first_name']);
$last_name = ($_POST['last_name']);
$address = ($_POST['address']);
$gender = ($_POST['gender']);
$skills = ($_POST['skills']) ?$_POST['skills'] : ["None"];

$title = ($gender == "Male") ? "Mr." : "Miss";


echo '
    <div class="container mt-5">
        <h2 class="text-center">Review</h2>

        <p>Thanks (' . $title . ') ' . $first_name . ' ' . $last_name . '</p>
        
        <h4>Please Review Your Information:</h4>
        <ul>
            <li><strong>Name:</strong> ' . $first_name . ' ' . $last_name . '</li>
            <li><strong>Address:</strong> ' . $address . '</li>
            <li><strong>Your Skills:</strong> ' . implode(", ", $skills) . '</li>
            <li><strong>Department:</strong> OpenSource</li>
        </ul>
    </div>';
?>
