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
    <link rel="stylesheet" type="text/css" href="assets/fontawesome/css/all.css">    

    
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script defer src="assets/js/my-script.js"></script>

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

$show_all_names = function ($dbh){
    $query_ST = "SELECT `id`, `site-name`, `cms-adress`,`site-login`,`site-password` FROM `klients-projects`";
    $sth = $dbh->prepare($query_ST);
    $sth->execute();    
    return $sth->fetchAll(PDO::FETCH_ASSOC);
    
};
$show_names_pass = $show_all_names($dbh);

 
if (strlen($_GET["delete-row"]) > 0 ){
        $row_for_delete = $_GET["delete-row"];
        $query_DT = "DELETE FROM `klients-projects` WHERE `id`= $row_for_delete";
        $sth = $dbh->prepare($query_DT);
        $sth->execute();   
         
}

if (strlen($_GET["details-row"]) > 0 ){
    $row_for_details = $_GET["details-row"];
    $query_DR = "SELECT * FROM `klients-projects` WHERE `id`= $row_for_details";
    $sth = $dbh->prepare($query_DR);
    $sth->execute();   
    $details_row = $sth->fetchAll(PDO::FETCH_ASSOC);
}

if (strlen($_GET["save-edit-row"]) > 0){
    array_pop($_GET);
    $id = $_GET["id"]; ///???

    //UPDATE `klients-projects` SET `ftp-password` = 'assword', `db-login` = 'db-log' WHERE `klients-projects`.`id` = 7 
    $query_UT = "UPDATE `klients-projects` SET `site-name`=':site-name', `cms-adress`=':cms-adress', `site-login`=':site-login', `site-password`=':site-password', `ftp-host`=':ftp-host', `ftp-login`=':ftp-login', `ftp-password`=':ftp-password',`db-name`=':db-name', `db-login`=':db-login',`db-password`=':db-password',`more-info`=':more-info' WHERE `id`= $id";
    $sth = $dbh->prepare($query_UT);
    foreach($_GET as $key=>$value){
        $sth->bindValue($key,$value);
    }
    $sth->execute();    

}

/* 
* create new project\site(table)
* $query_CT = "CREATE TABLE `testDB`.`klients-projects` ( `id` INT NOT NULL AUTO_INCREMENT , `site-name` VARCHAR(255) , `csm-adress` VARCHAR(255) , `site-login` VARCHAR(255)  , `site-password` VARCHAR(255)  , `ftp-host` VARCHAR(255)  , `ftp-login` VARCHAR(255)  , `ftp-password` VARCHAR(255)  ,`db-name` VARCHAR(255), `db-login` VARCHAR(255) ,`db-password` VARCHAR(255) ,`more-info` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
* $query_II = "INSERT INTO `klients-projects`( `site-name`, `cms-adress`, `site-login`, `site-password`, `ftp-host`, `ftp-login`, `ftp-password`,`db-name`, `db-login`,`db-password`,`more-info`) VALUES ('site name', 'cms url', 'site login', 'site password', 'ftp url', 'ftp login', 'ftp password','db name', 'db login','db password','more info')";
 
$sth = $dbh->prepare($query);
$sth->execute();
*/


if (strlen($_GET["new-project-input"]) > 0  && strlen($_GET["site-name"]) > 0 ){
    array_pop($_GET);
    $str_values = implode("','",$_GET);
    $str_values = "'".$str_values."'";
    $query_create_new_project = "INSERT INTO `klients-projects`( `site-name`, `cms-adress`, `site-login`, `site-password`, `ftp-host`, `ftp-login`, `ftp-password`,`db-name`, `db-login`,`db-password`,`more-info`) VALUES ($str_values)";
    $sth = $dbh->prepare($query_create_new_project);
    $sth->execute();    
}
echo "<pre>"; 
var_dump($_GET);
echo "</pre>";
/******/

?>
<main>
 
    <div class="container">
        <div class="row">
            <div class="col-md-12 m-2">
                <div class="d-flex justify-content-center h2">
                    <a href="/">SYStem<i class="fas fa-key"></i>KEYs</a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="btn btn-success new-project-btn">Создать новый проект</div>
                    <form class="new-project-form active" action="">                        
                        <input type="text" name="site-name" placeholder="site-name" value="">
                        <input type="text" name="cms-adress" placeholder="cms-adress" value="">
                        <input type="text" name="site-login" placeholder="site-login" value="">
                        <input type="text" name="site-password" placeholder="site-password" value="">
                        <input type="text" name="ftp-host" placeholder="ftp-host" value="">
                        <input type="text" name="ftp-login" placeholder="ftp-login" value="">
                        <input type="text" name="ftp-password" placeholder="ftp-password" value="">
                        <input type="text" name="db-name" placeholder="db-name" value="">
                        <input type="text" name="db-login" placeholder="db-login" value="">
                        <input type="text" name="db-password" placeholder="db-password" value="">
                        <textarea name="more-info"></textarea>
                        <button type="submit" name="new-project-input" value="1" class="btn btn-info">Сохранить</button>
                    </form>
            </div>
        </div>
    </div>
    <hr>
    <?php if (strlen($_GET["details-row"]) > 0 ){?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-warning p-2">
                    <div class="h1 text-center">Редактирование записи <b><?php echo $details_row[0]["site-name"];?></b></div>
                    <form action="">   
                        <table class="table table-striped table-bordered table-responsive text-center">
                                <tr>
                            <?php foreach($details_row[0] as $name_row=>$values):?>                        
                                    <th>
                                        <?php echo $name_row;?>
                                    </th>
                                    <?php endforeach;?>    
                                </tr>
                                <tr>
                                <?php foreach($details_row[0] as $name_row=>$values):?>                        
                                    <td>
                                        <?php if($name_row=="id" || $name_row=="date-start"){?>    

                                                <input type="text" hidden size="6" name="<?php echo $name_row;?>" value="<?php echo $values;?>"> 
                                                <?php echo $values;?>
                                        <?php }else{?>
                                                <input type="text" name="<?php echo $name_row;?>" value="<?php echo $values;?>">                            
                                        <?php }?>
                                    </td>
                                    <?php endforeach;?>   
                                </tr>                
                        </table>
                        <button type="submit" name="save-edit-row" class="btn btn-light" >Сохранить изменения</button>
                </form>
                </div>
            </div>
        </div>
     <?php }?>   
<div class="container">
    <div class="row">
        <div class="col-md-3 bg-light d-flex align-items-center flex-column">
            <?php
                foreach($show_names_pass as $name){                    
                    echo "<div class='m-1 p-1'>".$name["site-name"]."</div>";
                }
            ?>
        </div>     
    <?php
    if ($show_names_pass > 0){       
    ?>
        <div class="col-md-9">
            <table class="table table-striped table-bordered text-center">
                <tr>
                <?php
                    foreach($show_names_pass[0] as $k=>$v):?>
                    <?php if($k == "id"){continue;}?>
                        <th>
                            <?php                           
                            echo $k;
                            ?>
                        </th>            
                <?php
                    endforeach;?>
                    <th></th>
                </tr>
                
                <?php
                foreach($show_names_pass as $array){?>
                <tr>
                <?php 
                    foreach($array as $name_column=>$value){
                        if($name_column == "id"){continue;}
                        ?>       
                    <td>
                        <?php                           
                            echo $value;
                        ?>
                    </td>
            
                    <?php
                    }
                    ?>
                    <td class="ctrl-btns">
                        <form action="">
                            <button class="btn btn-light" name="details-row" value="<?php echo $array["id"] ?>" type="submit">                                
                                <i class="far fa-arrow-alt-circle-right text-success"></i>
                            </button>                        
                        </form>
                        <form class="d-none" action="">
                            <button class="btn btn-light" name="delete-row" value="<?php echo $array["id"] ?>" type="submit">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
                        </form>
                    </td>
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