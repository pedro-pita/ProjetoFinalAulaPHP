<?php
//variaveis globais da aplicacao
$host = $_SERVER['HTTP_HOST'];//localhost
//rtrim limpar todo o conteudo a dt parametro
//uri = /Projeto
$uri = rtrim(dirname($_SERVER['PHP_SELF']),"/\\");
$extra = "restritoAdmin.php";
define('HOME_URL',"http://$host$uri/$extra");
//passe
$connection = mysqli_connect('localhost','root','','projeto') or trigger_error(mysql_error());
/*Atributos nativos - global*/
$altImg;
$imovelDescricao;
$imovelImg;
$imovelID;
if(isset($_GET['del'])){
    deleteImovel($_GET['del']);
}
if(isset($_POST['edit'])){
    $imovel = validarImovel($_POST['edit']);
    validarForm($imovel);
}
if(isset($_POST['save']) && isset($_POST['form_imovel_alt']) && $_POST['form_imovel_decricao'] != ''){
    saveImovel($_POST['save']);
}
/* Métodos da aplicacao*/
function validarImovel($imovelID){
    global $conection;
    $sql = "SELECT * FROM `imovel` WHERE `id` = '$imovelID'";
    $db_check_imovel = mysqli_query($connection,$sql) or die(mysqli_error($connection));
    if(!$db_check_imovel){
        echo '<p class="form_error"> Internal Error: Imovel not exist!!!</p>';
        return false;
    }
    //obter os dados da BAse de dados Mysql
    $fetch_imovel = mysqli_fetch_assoc($db_check_imovel);
    return $fetch_imovel;
}

function validarForm($imovel){
    global $altImg, $imovelDescricao, $imovelID, $imovelImg;
    $fetch_imovel = $imovel;
    //se o id do imovel nao estiver vazio, preenche form com os dados
    if(!empty($fetch_imovel['id'])){
        $imovelID = $fetch_imovel['id'];//id do imovel
        $altImg = $fetch_imovel['altImg'];//texto alternativo da imagem
        $imovelDescricao = $fetch_imovel['descricao'];//descricao do imovel
        $imovelImg = $fetch_imovel['imgPath'];//caminho da imagem
    }else{
        echo '<p><b>Imovel não existe!!</b></p>';
    }
    
}
/*metodos da app*/
function saveImovel($imovelID){
    global $connection;
    $fetch_imovel = validarImovel($imovelID);
    //se nao existe cria
    if(!$fetch_imovel){
        insertImovel();
    }
    //configurar o id do imovel
    $imovel_id=$fetch_imovel['id'];
    
    //se o id do imovel nao estiver vazio, atualizar os dados
    if(!empty($imovel_id['id'])){
        $sql = "UPDATE imovel SET altImg='".$_POST['form_imovel_alt']."',
 descricao = '".$_POST['form_imovel_descricao']."', imgPath = '".$_POST['form_imovel_img']."'
 WHERE ID = ".$imovel_id;
        $query = mysqli_query($connection,$sql);
        //verificar sea a consulta esta ok
        if(!$query){
            echo '<p><b>Daata has not update!!!!!!</b></p>';
            //termina rotina
            return;
        }else{
            echo '<p><b>Imovel successfully updated !!!!!!</b></p>';
                //terminar rotina
            return;
        }
    }
}
//método de eliminação de um imovel
function deleteImovel($imovelID) {
    global $connection;
    //verificar se o id está vazio
    if(!empty($imovelID)){
        //o ID precisa ser inteiro
        $imovel_id = (int) $imovelID;
        $sql = "DELETE FROM `imovel` WHERE `id` = $imovel_id";
        if($connection->query($sql) === TRUE){
            echo '<p><b>Imovel successfully deleted!!!!!</b></p>';
        } else {
            echo '<p><b>Error: Imovel not deleted!!!!!</b></p>';
        }
        //Redirecionamento para página inicial
        /*
         echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URL .'">';
         echo '<script type="text/javascript"> window.location.href = "' . HOME_URL . '";</script>';
         */
    }
}

//método de inserir imovel
function insertImovel(){
    global $connection;
    //variaveis passadas via formulario pelo metodo post
    $altImg    = $_Post['form_imovel_alt'];
    $descricao = $_Post['form_imovel_descricao'];
    $imgPath   = $_Post['form_imovel_img'];
    //executar a consulta
    $sql = "INSERT INTO `imovel` (altImg, descricao, imgPath) VALUES ('$altImg','$descricao','$imgPath')";
    if($connection->query($sql) === TRUE){
        echo "New record created successfuly!!!";
    } else {
        echo "Error:" . $sql . "<br/>". $connection->error;
        return;
    }
}

//método de captura da lista de imoveis
function get_imoveis_list(){
    global $connection;
    $sql = "SELECT * FROM ´imovei´ ORDER BY id DESC";
    $query = mysqli_query($connection, $sql);
    if(mysqli_num_rows($query) > 0){
        //persistir dados retornados para a var resultado
        $resultado = mysqli_fetch_assoc($query);
        return $query;
        //return $resultado;
    } else {
        exit;
    }
}

//metodo captura imovel
function get_imovel($imovelID){
    global $connection;
    $sql = "SELECT * FROM ´imovel´ WHERE ´id´ = $imovelID";
    $query = mysqli_query($connection, $sql);
    if(mysqli_num_rows($query) > 0){
        //persistir dados retornados para a var resultado
        $resultado = mysqli_fetch_assoc($query);
        return $query;
        //return $resultado;
        //OK
    } else {
        //ERRO, nao encontrado ou nao existe
        exit;
    }
}



?>