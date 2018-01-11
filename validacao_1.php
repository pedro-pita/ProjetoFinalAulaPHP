<?php
/*  Verificar se houve envio POST e se o user existe
 ou a password existe ou nao é vazio */
// && <=> AND
// || <=> OR
if(!empty($_POST) AND (empty($_POST['user']) OR empty($_POST['password']))){
    header("Location: index.php");
    exit;
}
//servidor mysql
$connection = mysqli_connect('localhost','root','') or trigger_error(mysqli_error());
//Db mysql
mysqli_select_db($connection,'projeto') or trigger_error(mysql_error());

//var de autenticação
$user     = mysqli_real_escape_string($connection,$_POST['user']);
$password = mysqli_real_escape_string($connection,$_POST['password']);
$sql = "SELECT * FROM `users` WHERE (`user` = '".$user."') ". " AND (`password` = '". sha1($password)."') AND (`ativo` = 1) LIMIT 1";
$query = mysqli_query($connection, $sql);
if(mysqli_num_rows($query) != 1){
    echo "Login inválido!!!!";
    //header("Location: index.php");
    exit;
} else {
    //Persistir os dados
    $resultado = mysqli_fetch_assoc($query);
    //Se a sessao nao existe criamos
    if(!isset($_SESSION)){
        session_start();
    }
    //Persistir var de session
    $_SESSION['UserID'] = $resultado['id'];
    $_SESSION['UserNome'] = $resultado['nome'];
    $_SESSION['UserNivel'] = $nivel = $resultado['nivel'];
    $_SESSION['UserEmail'] = $resultado['email'];
    
    //Redicionar em função do nivel de acesso
    switch ($nivel){
        case 1:
            header("Location: restritoAdmin.php");
            echo "1";
            break;
        case 2:
            header("Location: restrito_1.php");
            break;
        default:
            echo "User sem permissões!!!";
            
    }
    
}
?>