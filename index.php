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


$dsn = 'mysql:dbname=testDB;host=localhost;charset=utf8';
$user = 'test_user';
$password = '123123';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$dbh = new PDO($dsn, $user, $password,$opt);

$show_all_tables = function ($dbh){
    $query_ST = "SHOW TABLES";
    $sth = $dbh->prepare($query_ST);
    $sth->execute();
    return $sth->fetch(PDO::FETCH_ASSOC);
};
/* 
* create new project\site(table)
* $query_CT = "CREATE TABLE `testDB`.`klient-project-name` ( `id` INT NOT NULL AUTO_INCREMENT , `site-name` VARCHAR(255) , `site-login` TINYTEXT NOT NULL , `site-password` TINYTEXT NOT NULL , `ftp-host` TINYTEXT NOT NULL , `ftp-login` TINYTEXT NOT NULL , `ftp-password` TINYTEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
* $query_II = "INSERT INTO `klient-project-name`( `site-name`, `site-login`, `site-password`, `ftp-host`, `ftp-login`, `ftp-password`) VALUES ('[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')";
* show all project
* $query_ST = "SHOW TABLES";



$sth = $dbh->prepare($query);
$sth->execute();
*/

$query_II = "INSERT INTO `klient-project-name`( `site-name`, `site-login`, `site-password`, `ftp-host`, `ftp-login`, `ftp-password`) VALUES ('[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')";

$query_TR = "SELECT * FROM `klient-project-name`";

$sth = $dbh->prepare($query_TR);

$sth->execute();
$data = $sth->fetchAll();



echo "<pre>";
//print_r($data);
echo "</pre>"
/******/
?>
<main>
    
<div class="container">
    <div class="row">
        <div class="col-md-3 bg-info">
            <?php
                foreach($show_all_tables($dbh) as $name){
                        echo "<p>".$name."</p>";
                }
            ?>
        </div>     
    <?php
    if ($data > 0){       
    ?>
        <div class="col-md-9">
            <table class="table table-striped table-bordered">
                <tr>
                <?php
                    foreach($data[0] as $k=>$v):?>
                        <th>
                            <?php
                            echo $k;
                            ?>
                        </th>            
                <?php
                    endforeach;?>
                </tr>
                
                <?php
                foreach($data as $array){?>
                <tr>
                <?php 
                    foreach($array as $value){?>        
                    <td>
                        <?php
                        echo $value;
                        ?>
                    </td>
            
                    <?php
                    }
                    ?>
                </tr>
                <?php                
                }
                ?>          
            </table>
        </div>
        <?php
        }
        ?>
    </div>
</div>

</main>

</body>
</html>