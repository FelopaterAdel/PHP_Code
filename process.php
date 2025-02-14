<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (empty($_POST['first_name'])) {
    echo "<h1 > No data received! </h1>";
    exit();
}


$first_name = htmlspecialchars($_POST['first_name']);
$last_name = htmlspecialchars($_POST['last_name']);
$address = htmlspecialchars($_POST['address']);
$gender = htmlspecialchars($_POST['gender']);
$skills = isset($_POST['skills']) ?$_POST['skills'] : ["None"];

$title = ($gender == "Male") ? "Mr." : "Miss";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Submission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Review</h2>
        <p>Thanks (<?php echo $title; ?>) <?php echo $first_name . " " . $last_name; ?></p>
        <h4>Please Review Your Information:</h4>
        <ul>
            <li><strong>Name:</strong> <?php echo $first_name . " " . $last_name; ?></li>
            <li><strong>Address:</strong> <?php echo $address; ?></li>
            <li><strong>Your Skills:</strong> <?php echo implode(", ", $skills); ?></li>
            <li><strong>Department:</strong> OpenSource</li>
        </ul>
    </div>
</body>
</html>
