<?php
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION))
    session_start();

// Verifica se existe sessão ativa para o user
if (!isset($_SESSION['UserID'])) {
    // Destrói a sessão por segurança
    session_destroy();
    // Redireciona pro login
    header("Location: index.php");
    exit;
}

// Variaveis globais da aplicação
$host = $_SERVER['HTTP_HOST'];//localhost
$uri = rtrim(dirname($_SERVER['PHP_SELF']),"/\\");
$extra = "restrito_1.php";
define('HOME_URI',"http://$host$uri/$extra");
$connection = mysqli_connect('localhost', 'root', '', 'projeto') or trigger_error(mysql_error());
$userUser;
$userNome;
$userEmail;
$userID;
$userPassword;

if (isset($_GET['del'])) {
    deleteUser($_GET['del']);
}
if (isset($_POST['edit'])) {
    $user = validarUser($_POST['edit']);
    //print_r($user);
    validateForm($user);
}

if (isset($_POST['save']) && isset($_POST['form_user_nome']) && $_POST['form_user_nome'] != '') {
    saveUser($_POST['save']);
}

function validarUser($userID) {
    global $connection;
    $sql = "SELECT * FROM `users` WHERE `id` ='$userID'";
    //$sql = 'SELECT * FROM `usrs` WHERE `id` =3';
    $db_check_user = mysqli_query($connection, $sql) or die(mysqli_error($connection));
    // Verifica se o user existe
    if (!$db_check_user) {
        echo '<p class="form_error">Internal error: User not exist</p>';
        return false;
    }
    // Obtém os dados da base de dados MySQL
    $fetch_user = mysqli_fetch_assoc($db_check_user);
    return $fetch_user;
}

function validateForm($user) {
    global $userNome, $userUser, $userEmail, $userID, $userPassword;
    $fetch_user = $user;
    // Se o ID do user não estiver vazio, preenche form com os dados
    if (!empty($fetch_user['id'])) {
        $userID = $fetch_user['id']; // nome do user
        $userNome = $fetch_user['nome']; // nome do user
        $userUser = $fetch_user['user']; // login do user
        $userEmail = $fetch_user['email']; // email do user
		$userPassword = $fetch_user['password']; // email do user
		echo $fetch_user['email'];
    } else {
        //echo "User não existe";
    }
}

function saveUser($userID) {
    global $connection;
    $fetch_user = validarUser($userID);

    if (!$fetch_user) {
        insertUser();
    }

    // Configura o ID do user
    $user_id = $fetch_user['id'];
    // Se o ID do user não estiver vazio, atualiza os dados
    if (!empty($user_id)) {
        $sql = "UPDATE users SET nome='" . $_POST['form_user_nome'] . "', email = '" .
		$_POST['form_user_email'] . "', user = '" . $_POST['form_user'] . "', password = '" .
		sha1($_POST['form_user_password']) . "' WHERE id =" . $user_id;
        $query = mysqli_query($connection, $sql) OR die(mysqli_error($connection));
        // Verifica se a consulta está OK
        if (!$query) {
            echo '<p>Internal error. Data has not update.</p>';
            // Termina
            return;
        } else {
            echo '<p>User successfully updated.</p>';
            // Termina
            return;
        }
    } 
}

function deleteUser($userID) {
    global $connection;
    // Verifica se o ID não está vazio
    if (!empty($userID)) {
        // O ID precisa ser inteiro
        $user_id = (int) $userID;
        $sql = "DELETE FROM `users` WHERE `id` = $user_id";
        if ($connection->query($sql) === TRUE) {
            echo "Record deleted successfully\n";
        } else {
            echo "Error deleting record: " . $connection->error;
        }
        // Redireciona para a página de registros
        //echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '">';
        //echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '";</script>';
        //return;
    }
}

function insertUser() {
    global $connection;
    //Var via form
    $user = $_POST['form_user'];
    $nome = $_POST['form_user_nome'];
    $email = $_POST['form_user_email'];
	$password = sha1($_POST['form_user_password']);
    // Executa a consulta 
    $sql = "INSERT INTO `users` (nome, user,email,password,nivel,ativo,registo)
            VALUES ('$nome', '$user','$email', '$password', 1, 1,now())";

    if ($connection->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
        return;
    }
}

function get_user_list() {
    global $connection;
    $sql = "SELECT * FROM `users` ORDER BY user DESC";
    $query = mysqli_query($connection, $sql);

    if (mysqli_num_rows($query) > 0) { // Persiste os dados encontados na variável $resultado
        $resultado = mysqli_fetch_assoc($query);
        return $query;
        // Verifica se a consulta está OK
    } else {
        // Erro user não foi encontrado ou nao existe
        exit;
    }
}
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
        <h3>Página restrita:  <?php
            echo "Sessão ativa :" . $_SESSION['UserNome'];
            echo "<br /><a href=\"logout.php\">Sair</a>";
            ?></h3>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <td>Nome: </td>
                    <td> <input type="text" name="form_user_nome" value="<?php
                        if (isset($userNome))
                            echo htmlentities($userNome);
                        ?>" /></td>
                </tr>
                <tr>
                    <td>User:</td>
                    <td> <input type="text" name="form_user" value="<?php
                        if (isset($userUser))
                            echo htmlentities($userUser);
                        ?>" /></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td> <input type="email" name="form_user_email" value="<?php
                        if (isset($userEmail))
                            echo htmlentities($userEmail);
                        ?>" /></td>
                </tr>
				<tr>
                    <td>Password: </td>
                    <td> <input type="text" name="form_user_password" value="<?php
                        if (isset($userPassword))
                            echo htmlentities($userPassword);
                        ?>" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="save" value="<?php echo $userID; ?>">
                        <input type="submit" value="save" />
                        <a href="<?php echo HOME_URI; ?>?new=<?php if (isset($userID)) echo $userID; ?>">Novo</a>
                    </td>
                </tr>
            </table>
        </form>
        <?php
        // Lista os user
        $lista = get_user_list();
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Nome</th>
					<th>Password</th>
                    <th>Edição</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $fetch_userdata): ?>
                    <tr>
                        <td> <?php echo $fetch_userdata['id']; ?> </td>
                        <td> <?php echo $fetch_userdata['user'] ?> </td>
                        <td> <?php echo $fetch_userdata['nome'] ?> </td>
						<td> <?php echo $fetch_userdata['password'] ?> </td>
                        <td> 
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="edit" value="<?php echo $fetch_userdata['id']; ?>">
                                <input type="submit" name="submit" value="Edit">
                            </form>
                            <a href="<?php echo HOME_URI; ?>?del=<?php echo $fetch_userdata['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>
