<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TesT_DB</title>   
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-4/css/bootstrap.css">              			
    <link rel="stylesheet" type="text/css" href="assets/my-style.css">    
    
    <script src="assets/js/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// setlocale(LC_ALL, 'ru_RU');
// date_default_timezone_set('Europe/Moscow');
// header('Content-type: text/html; charset=utf-8');


$dsn = 'mysql:dbname=testDB;host=localhost';
$user = 'test_user';
$password = '123123';

$dbh = new PDO($dsn, $user, $password);

print_r($dbh);

?>
<main>
    
    
<div class="container">
    <div class="col-md-6 bg-info">-</div>
</div>


</main>

</body>
</html>