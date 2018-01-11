<?php


//A pagina precisa ser iniciada em cada pagina de redirecionamento
if(!isset($_SESSION))
    session_start();
    
    //Verificar se existe sessao ativa para este ser
    if(!isset($_SESSION['UserID'])){
        //Destroi a sessao por seguranca
        session_destroy();
        //Redireciona apra index
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
        <h2>Página restrita </h2>
		<h3>
		<?php
            echo "User ativado: ". $_SESSION['UserNome'];
            echo "<br/> <a href=\"Logout.php\">Sair</a>";
        ?>
		</h3>
                <tr>
                    <td>Descricao:</td>
                    <td> <input type="text" name="form_imovel_descricao" value="<?php
                        
                        ?>" /></td>
                </tr>
                <tr>
                    <td>Img Path:</td>
                    <td> <input type="text" name="form_imovel_img" value="<?php
                        
                        ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="save" value="<?php  ?>">
                        <input type="submit" value="save" />
                        <a href="<?php  ?>?new=<?php  ?>">Novo</a>
                    </td>
                </tr>
            </table>
        </form>
        <?php
        
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
                <?php  ?>
                    <tr>
                        <td> <?php  ?> </td>
                        <td> <?php  ?> </td>
                        <td> <?php  ?> </td>	
                        <td> <?php  ?> </td>	
                        <td> 
                            <form method="post" action="<?php  ?>">
                                <input type="hidden" name="edit" value="<?php  ?>">
                                <input type="submit" name="submit" value="Edit">
                            </form>
                            <a href="<?php ?>?del=<?php  ?>">Delete</a>
                        </td>
                    </tr>
                <?php  ?>
            </tbody>
        </table>
    </body>
</html>
