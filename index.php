<?php
session_start();

if (isset($_SESSION['user']) && $_SESSION['user']!= "Unknown"){
    $current_user_name = $_SESSION['user'];
}else{
    $current_user_name = "Unknown";
}
?>
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
//  error_reporting(E_ALL);
//  ini_set('display_errors', 1);
// setlocale(LC_ALL, 'ru_RU');
// date_default_timezone_set('Europe/Moscow');
// header('Content-type: text/html; charset=utf-8');

/* klients_projects

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
/* users_logpas

    1 	id  	    int 			                        Нет Нет AUTO_INCREMENT  Изменить    Удалить 
    2 	login 	    varchar(255) 	utf8_general_ci 		Нет Нет 			    Изменить    Удалить 
    3 	password 	varchar(255) 	utf8_general_ci 		Нет Нет 			    Изменить    Удалить 
    4 	temp 	    int 			                        Нет	Нет                 Изменить    Удалить 	    
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
    header("Location: /");
         
}

if (strlen($_GET["details_row"]) > 0 ){
    $row_for_details = $_GET["details_row"];
    $query_DR = "SELECT * FROM klients_projects WHERE id= $row_for_details";
    $sth = $dbh->prepare($query_DR);
    $sth->execute();   
    $details_row = $sth->fetchAll(PDO::FETCH_ASSOC);
}

if (strlen($_GET["save_edit_row"]) > 0){

    array_pop($_GET);   // убираем save_edit_row - последний элемент массива
    $id = $_GET["id"];  
    array_shift($_GET); // убираем id - первый элемент массива
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
    header("Location: /");
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
    header("Location: /");
}
/******/
if (strlen($_POST["reg_new_user"]) > 0){
    $user_login = $_POST["user_login"];
    $user_pass = md5($_POST["user_pass"]);
    $query_CNU = "INSERT INTO users_logpas ( user_login, user_password ) VALUES ( :user_login, :user_pass)";
    $sth = $dbh->prepare($query_CNU);    
    $sth->bindValue('user_pass', $user_pass);
    $sth->bindValue('user_login',$user_login);
    $sth->execute();  
}

if (strlen($_POST["user_login_enter"]) > 0 ){
    $login = $_POST["user_login"];
    $pass = $_POST["user_pass"];
    $query_FU = "SELECT * FROM users_logpas WHERE user_login= :user_login";
    $sth = $dbh->prepare($query_FU);
    $sth->bindValue('user_login',$login);
    $sth->execute();    
    $current_user = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
    if (md5($pass) == $current_user["user_password"] ){
        $current_user_name = $current_user['user_login'];
    }else{
        $current_user_name = "Unknown";
    }
    $_SESSION["user"] = $current_user_name;
}

if(strlen($_POST["user_logout"]) > 0 ){
    session_destroy();
    header('Location: /');
}


echo "<pre>"; 
//var_dump($_SESSION);
echo "</pre>";
?>
<header>
  <div class="container">
      <div class="row">
          <div class="col-md-6">
                <div class="user-name">
                 Текущий пользователь: 
                 <b>   
                <?php               
                    echo $current_user_name; 
                ?>            
                </b>
                </div>
          </div>
          <div class="col-md-6">

        <?php if ($current_user_name == false || $current_user_name == "Unknown"):?>
            <div class="login-form">                        
                    <form action="" method="post">
                        <input type="text" placeholder="Login" name="user_login">
                        <input type="text" placeholder="Password" name="user_pass">
                        <button type="submit" name="user_login_enter" class="btn btn-info" value="1">Log In -></button>
                    </form>
                </div>
          </div>
        <?php else:?>
          <div class="logout-form">
              <form action="" method="post">
                    <button type="submit" name="user_logout" class="btn btn-link" value="1">LogOut</button>
              </form>
          </div>          
        <?php endif;?>

      </div>
  </div>  

<?php /*if ($current_user_name == false || $current_user_name == "Unknown"):?>
  <div class="container bg-warning">
      <div class="row">
        <div class="col-md-6">
                <div class="register-form">                
                    <form action="" method="post">
                        <input type="text" placeholder="Login new user" name="user_login">
                        <input type="text" placeholder="Password new user" name="user_pass">
                        <button type="submit" name="reg_new_user" class="btn btn-info" value="new_user">Создать</button>
                    </form>
                </div>
            </div>
        </div>
  </div>
<?php endif;*/?>

</header>

<?php 
 
if ($current_user_name == false || $current_user_name == "Unknown"):?> 

<main>
<hr>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-center h2">
                    <a href="/">SYStem<i class="fas fa-key"></i>KEYs</a>
                </div>
            </div>
        </div>
    </div>
<hr>
<div class="h1 text-center">
    Требуется войти в учетную запись 
</div>
<?php else:?>
    <main>
    <hr>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
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
                <div class="btn btn-success new-project-btn mt-2">Создать новый проект</div>
                    <form class="new-project-form mt-3 mb-3 pt-2 pb-2" action="">   
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="site_name" class="form-control mt-1"  placeholder="site_name*" value="">
                                </div>                     
                                <div class="col-md-4">
                                    <input type="text" name="cms_adress" class="form-control mt-1" placeholder="cms_adress" value="">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="site_login" class="form-control mt-1" placeholder="site_login" value="">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="site_password" class="form-control mt-1" placeholder="site_password" value="">
                                </div>
                            </div>
                        </div>
                        <div class="container mt-1">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="ftp_host" class="form-control mt-1" placeholder="ftp_host" value="">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="ftp_login" class="form-control mt-1" placeholder="ftp_login" value="">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="ftp_password" class="form-control mt-1" placeholder="ftp_password" value="">
                                </div>
                            </div>
                        </div>
                        <div class="container mt-1">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="db_name" class="form-control mt-1" placeholder="db_name" value="">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="db_login" class="form-control mt-1" placeholder="db_login" value="">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="db_password" class="form-control mt-1" placeholder="db_password" value="">
                                </div>
                            </div>
                        </div>         
                        <div class="container mt-1">
                            <div class="row">
                                <div class="col-md-10">
                                    <textarea name="more_info" class="form-control mt-1" placeholder="other info"></textarea>
                                </div>
                                <div class="col-md-2 d-flex justify-content-end">
                                    <button type="submit" name="new_project_input" value="1" class="btn btn-info new-project-input align-self-end">Сохранить</button>
                                </div>
                            </div>
                        </div> 
                    </form>
            </div>
        </div>
    </div>
 
    <hr>
    <?php if (strlen($_GET["details_row"]) > 0 ){?>
        <div class="container mt-3 mb-3">
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
                <input type="search" class="mt-2 mb-2 form-control" disabled placeholder="Поиск проекта" title="временно недоступно">
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
                <table class="table table-striped table-hover table-bordered bg-light text-center">
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
                    foreach($show_names_pass as $key=>$array){?>
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
                            <div class="btns-options d-flex" data-rowid="<?php echo $key; ?>">
                                <form class="details-row" action="">
                                    <button class="btn btn-light " name="details_row" value="<?php echo $array["id"] ?>" type="submit">                                
                                        <i class="far fa-arrow-alt-circle-right text-success"></i>
                                    </button>                        
                                </form>
                                <form class="form-delete-row" action="">
                                    <div class="btn btn-light btn-delete-row" data-rowid="<?php echo $key; ?>">
                                        <i class="far fa-trash-alt text-danger"></i>                                    
                                    </div>                            
                                    <button class="btn btn-light confirm-btn-delete-row" name="delete_row" value="<?php echo $array["id"] ?>" type="submit">
                                        <i class="far fa-check-square border-danger text-success"></i>
                                    </button>
                                </form>
                            </div>                           
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
<?php endif;?>
</main>


<footer>
<div class="container">
<div class="row">
    <div class="col-md-3">
        <i class="fab fa-github"></i>     
        <a href="https://github.com/AndreyDenisovt/BasePDO" target="_blank">AndreyDenisovt</a>    
    </div>
</div>
</div>
</footer>
</body>
</html>