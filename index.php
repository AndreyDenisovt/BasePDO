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

//phpinfo();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
// setlocale(LC_ALL, 'ru_RU');
// date_default_timezone_set('Europe/Moscow');
// header('Content-type: text/html; charset=utf-8');
/*
    1	id              int(11)			                    Нет	Нет	AUTO_INCREMENT	Изменить	Удалить
	2	site_name	    varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	3	cms_adress	    varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	4	site_login	    varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	5	site_password	varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	6	ftp_host	    varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	7	ftp_login	    varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	8	ftp_password	varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	9	db_name	        varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	10	db_login	    varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	11	db_password	    varchar(255)	utf8_general_ci		Да	NULL		        Изменить	Удалить
	12	more_info	    text	        utf8_general_ci		Нет	Нет		            Изменить	Удалить
	13	date_start	    datetime			                Нет	CURRENT_TIMESTAMP	Изменить	Удалить	
	14	status	        varchar(2)	    utf8_general_ci		Да	0	                Изменить	Удалить
*/

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
    $query_ST = "SELECT id, site_name, cms_adress,site_login,site_password FROM klients_projects";
    $sth = $dbh->prepare($query_ST);
    $sth->execute();    
    return $sth->fetchAll(PDO::FETCH_ASSOC);
    
};
$show_names_pass = $show_all_names($dbh);

 
if (strlen($_GET["delete_row"]) > 0 ){
    $row_for_delete = $_GET["delete_row"];
    $query_DT = "DELETE FROM klients_projects WHERE id= $row_for_delete";
    $sth = $dbh->prepare($query_DT);
    $sth->execute();   
         
}

if (strlen($_GET["details_row"]) > 0 ){
    $row_for_details = $_GET["details_row"];
    $query_DR = "SELECT * FROM klients_projects WHERE id= $row_for_details";
    $sth = $dbh->prepare($query_DR);
    $sth->execute();   
    $details_row = $sth->fetchAll(PDO::FETCH_ASSOC);
}

if (strlen($_GET["save_edit_row"]) > 0){

    array_pop($_GET);   // убираем save_edit_row
    $id = $_GET["id"];  
    array_shift($_GET); // убираем id
    $query_UT = "UPDATE klients_projects SET site_name= :site_name, cms_adress=:cms_adress, site_login=:site_login, site_password=:site_password, ftp_host=:ftp_host, ftp_login=:ftp_login, ftp_password=:ftp_password, db_name=:db_name, db_login=:db_login,db_password=:db_password,more_info=:more_info, status=:status WHERE id= $id";
    $sth = $dbh->prepare($query_UT);
    foreach($_GET as $key=>$value){
        if($key=="date_start"){
            continue;  
        }else{
            $sth->bindValue($key,$value);
        }
    }
    $sth->execute();
    //print_r($_GET);

}

/* 
* create new project\site(table)
* $query_CT = "CREATE TABLE `testDB`.klients_projects ( id INT NOT NULL AUTO_INCREMENT , site_name VARCHAR(255) , csm_adress VARCHAR(255) , site_login VARCHAR(255)  , site_password VARCHAR(255)  , ftp_host VARCHAR(255)  , ftp_login VARCHAR(255)  , ftp_password VARCHAR(255)  , db_name VARCHAR(255), db_login VARCHAR(255) ,db_password VARCHAR(255) ,more_info TEXT NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB";
* $query_II = "INSERT INTO klients_projects( site_name, cms_adress, site_login, site_password, ftp_host, ftp_login, ftp_password, db_name, db_login,db_password,more_info) VALUES ('site name', 'cms url', 'site login', 'site password', 'ftp url', 'ftp login', 'ftp password','db name', 'db login','db password','more info')";
 
$sth = $dbh->prepare($query);
$sth->execute();
*/


if (strlen($_GET["new_project_input"]) > 0  && strlen($_GET["site_name"]) > 0 ){
    array_pop($_GET);
    $str_values = implode("','",$_GET);
    $str_values = "'".$str_values."'";
    $query_create_new_project = "INSERT INTO klients_projects( site_name, cms_adress, site_login, site_password, ftp_host, ftp_login, ftp_password, db_name, db_login,db_password,more_info) VALUES ($str_values)";
    $sth = $dbh->prepare($query_create_new_project);
    $sth->execute();    
}
echo "<pre>"; 
//var_dump($_GET);
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
                        <input type="text" name="site_name" placeholder="site_name" value="">
                        <input type="text" name="cms_adress" placeholder="cms_adress" value="">
                        <input type="text" name="site_login" placeholder="site_login" value="">
                        <input type="text" name="site_password" placeholder="site_password" value="">
                        <input type="text" name="ftp_host" placeholder="ftp_host" value="">
                        <input type="text" name="ftp_login" placeholder="ftp_login" value="">
                        <input type="text" name="ftp_password" placeholder="ftp_password" value="">
                        <input type="text" name="db_name" placeholder="db_name" value="">
                        <input type="text" name="db_login" placeholder="db_login" value="">
                        <input type="text" name="db_password" placeholder="db_password" value="">
                        <textarea name="more_info"></textarea>
                        <button type="submit" name="new_project_input" value="1" class="btn btn-info new-project-input">Сохранить</button>
                    </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            
            // $("form.new-project-form").on("submit",function(e){
            //         e.eventPreventDefault;
            //         data = $(this).serialise;
            //         $.post({
            //             url:"/index.php",
            //             data:data,
            //             success:function(){
            //                 console.log("OK")
            //             }
            //         });
            // });
            console.log("JQ")
        });
        
    </script>
    <hr>
    <?php if (strlen($_GET["details_row"]) > 0 ){?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-warning p-2">
                    <div class="h1 text-center">Редактирование записи <b><?php echo $details_row[0]["site_name"];?></b></div>
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
                                        <?php if($name_row=="id" || $name_row=="date_start"){?>    

                                                <input type="text" hidden size="6" name="<?php echo $name_row;?>" value="<?php echo $values;?>"> 
                                                <?php echo $values;?>
                                       
                                        <?php }else{?>
                                                <input type="text" name="<?php echo $name_row;?>" value="<?php echo $values;?>">                            
                                        <?php }?>
                                    </td>
                                    <?php endforeach;?>   
                                </tr>                
                        </table>
                        <button type="submit" name="save_edit_row" value="1" class="btn btn-light" >Сохранить изменения</button>
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
                    echo "<div class='m-1 p-1'>".$name["site_name"]."</div>";
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
                            <button class="btn btn-light" name="details_row" value="<?php echo $array["id"] ?>" type="submit">                                
                                <i class="far fa-arrow-alt-circle-right text-success"></i>
                            </button>                        
                        </form>
                        <form class="d-none" action="">
                            <button class="btn btn-light" name="delete_row" value="<?php echo $array["id"] ?>" type="submit">
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