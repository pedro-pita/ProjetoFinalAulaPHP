<?php
//var globais da app
$host = $_SERVER['HTTP_HOST'];//localhost
// rtrim limpar todo o conteudo a dt do parametro
//uri = /ECLIPSE/2Programador/Projeto
$uri = rtrim(dirname($_SERVER['PHP_SELF']),"/\\");
$extra = "restritoAdmin.php";
define('HOME_URI',"http://$host$uri/$extra");
/*define('HOME_URI',"http://localhost/ECLIPSE/
 2Programador/Projeto/restritoAdmin.php");*/
/*define('HOME_URI',"http://localhost/Projeto/restritoAdmin.php");*/
$connection =
mysqli_connect('localhost','root','','projeto') or
trigger_error(mysql_error());
/* Atributos nativos - global*/
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

if(isset($_POST['save'])
    && isset($_POST['form_imovel_alt'])
    && $_POST['form_imovel_descricao'] != ''){
        saveImovel($_POST['save']);
}

/* Métodos da app*/
function validarImovel($imovelID){
    global $connection;
    $sql = "SELECT * FROM `imovel`
			WHERE `id` = '$imovelID'";
    $db_check_imovel = mysqli_query($connection,$sql)
    or die(mysqli_error($connection));
    // Verificar se o imovel existe
    if(!$db_check_imovel){
        echo '<p class="form_error">
		Internal Error : Imovel not exist!!!</p>';
        return false;
    }
    // Obter os dados da Base de dados Mysql
    $fetch_imovel = mysqli_fetch_assoc($db_check_imovel);
    return $fetch_imovel;
}

function validarForm($imovel){
    global $altImg, $imovelDescricao, $imovelID, $imovelImg;
    $fetch_imovel = $imovel;
    // Se o id do imovel não estiver vazio, preenche form com os dados
    if(!empty($fetch_imovel['id'])){
        $imovelID = $fetch_imovel['id'];// id do imovel
        $altImg = $fetch_imovel['altImg'];// texto alternativo da imagem
        $imovelDescricao = $fetch_imovel['descricao'];//descrição do imovel
        $imovelImg = $fetch_imovel['imgPath'];// caminho da img
    } else{
        echo '<p><b>Imovel não existe!!!!</b></p>';
    }
}

function saveImovel($imovelID){
    global $connection;
    $fetch_imovel = validarImovel($imovelID);
    
    // se não existe cria
    if(!$fetch_imovel){
        insertImovel();
    }
    
    //configurar o id do imovel
    $imovel_id = $fetch_imovel['id'];
    
    // Se o id do imovel não estiver vazio, atualizar os dados
    if(!empty($imovel_id)){
        $sql = "UPDATE imovel SET altImg='".$_POST['form_imovel_alt']."',
				descricao = '".$_POST['form_imovel_descricao']."', imgPath = '".
				$_POST['form_imovel_img']."' WHERE id = ".$imovel_id;
				$query = mysqli_query($connection,$sql);
				// verificar se a consulta está OK
				if(!$query){
				    echo '<p><b>Imovel has not update!!!!</b></p>';
				    // Terminar a rotina
				    return;
				} else{
				    echo '<p><b>Imovel successfully updated!!!!</b></p>';
				    // Terminar a rotina
				    return;
				}
    }
}

// método de eliminação de um imovel
function deleteImovel($imovelID){
    global $connection;
    // verificar se o id está vazio
    if(!empty($imovelID)){
        // o ID precisa ser inteiro
        $imovel_id = (int) $imovelID;
        $sql = "DELETE FROM `imovel` WHERE `id` = $imovel_id";
        if($connection->query($sql) === TRUE){
            echo '<p><b>Imovel successfully deleted!!!!</b></p>';
        } else {
            echo '<p><b>Error: Imovel not deleted!!!!</b></p>';
        }
        //Redirecionamento para página inicial
        /*
         echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI .'">';
         echo '<script type="text/javascript"> window.location.href = "' . HOME_URI . '";</script>';
         */
    }
}

// método de inserir imovel
function insertImovel(){
    global $connection;
    //var vai from
    $altImg 	= $_POST['form_imovel_alt'];
    $descricao 	= $_POST['form_imovel_descricao'];
    $imgPath 	= $_POST['form_imovel_img'];
    // Executar a consulta
    $sql = "INSERT INTO `imovel` (altImg, descricao, imgPath)
	        VALUES ('$altImg','$descricao','$imgPath')";
    if($connection->query($sql) === TRUE){
        echo "New record created successfully!!!";
    } else {
        echo "Error:" . $sql . "</ br>". $connection->error;
        return;
    }
}

// método de captura da lista de imoveis
function get_imoveis_list(){
    global $connection;
    $sql = "SELECT * FROM `imovel` ORDER BY id DESC";
    $query = mysqli_query($connection, $sql);
    if(mysqli_num_rows($query) > 0){
        // Persistir os dados retornados para a var resultado
        $resultado = mysqli_fetch_assoc($query);
        return $query;
        //return $resultado;
    } else {
        exit;
    }
}

//método captura imovel
function get_imovel($imovelID){
    global $connection;
    $sql = "SELECT * FROM `imovel` WHERE `id` = $imovelID";
    $query = mysqli_query($connection, $sql);
    if(mysqli_num_rows($query) > 0){
        // Persistir os dados retornados para a var resultado
        $resultado = mysqli_fetch_assoc($query);
        return $resultado;
        // OK
    } else {
        // ERRO, não encontrado ou não existe
        exit;
    }
    
}
?>



















