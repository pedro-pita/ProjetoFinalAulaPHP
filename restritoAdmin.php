<?php
//pagina sessao precisa ser iniciada em cada pagina de redirecionamento
if(!isset($_SESSION)){
    session_start();
}


//Verifica se existe sessao ativa par um user_error
if(!isset($_SESSION['UserID'])){
    //destroi a sessao por seguranca
    session_destroy();
    //redireciona para index
    header("Location: index.php");
    exit;
}
include_once './functionDB.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width">
        <title>Home</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    </head>
    <body>
        <h3>P�gina restrita:  
		<?php
            echo "<br/>Sess�o ativa: " . $_SESSION['UserNome'];
            echo "<br/> <a href=\"logout.php\">Sair</a>";
        ?>
		</h3>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <td>Alt Img: </td>
                    <td> <input type="text" name="form_imovel_alt" value="<?php
                        if(isset($altImg)){
                            echo htmlentities($altImg);
                        }
                        ?>" /></td>
                </tr>
                <tr>
                    <td>Descricao:</td>
                    <td> <input type="text" name="form_imovel_descricao" value="<?php
                        if(isset($imovelDescricao)){
                            echo htmlentities($imovelDescricao);
                        }
                        ?>" /></td>
                </tr>
                <tr>
                    <td>Img Path:</td>
                    <td> <input type="text" name="form_imovel_img" value="<?php
                        if(isset($imovelImg)){
                            echo htmlentities($imovelImg);
                        }
                        ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="save" value="<?php echo $imovelID; ?>">
                        <input type="submit" value="save" />
                        <a href="<?php echo HOME_URI; ?>?new=<?php if(isset($imovelID)){ echo $imovelID; } ?>">Novo</a>
                    </td>
                </tr>
            </table>
        </form>
        <?php
            //recuperar lista de imoveis
            $lista = get_imoveis_list();
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Alt</th>
                    <th>Descrição</th>
                    <th>Img</th>
                    <th>Edição</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($lista as $fetch_imoveldata): ?>
                    <tr>
                        <td> <?php echo $fetch_imoveldata['id']; ?> </td>
                        <td> <?php echo $fetch_imoveldata['altImg']; ?> </td>
                        <td> <?php echo $fetch_imoveldata['descricao']; ?> </td>	
                        <td> <?php echo $fetch_imoveldata['imgPath']; ?> </td>	
                        <td> 
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="edit" value="<?php echo $fetch_imoveldata['id']; ?>">
                                <input type="submit" name="submit" value="Edit">
                            </form>
                            <a href="<?php echo HOME_URI; ?>?del=<?php echo $fetch_imoveldata['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
		</table>
	</body>
