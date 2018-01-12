<!DOCTYPE HTML>
<!-- 
    Mais qe um elemento block:
    Centrar horizontalmente aplicando a noção de linha. Para tal, usamos display Exemplo:
    -inline-block-centrar- flexbox(os filhos dos elementos com flexbox)
    podem ser posicionados em qlq direcao, podesw ter ainda dimensoes flexiveis.
 -->
<html lang="pt-pt">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="./css/style.css">
		<title>Home</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<meta charset="UTF-8">
		
	</head>
	<body>
		<header class="header">
			<img src="./img/logo.png" alt="logo"/>
		</header>
		<section class="section_banner">
			<h1>Albuns de Rap Tuga</h1>
		</section>
		<div class="admin">
			<a href="admin.php">
				<img alt="admin" src="./img/admin.png" >
			</a>
		</div>
		<?
	       include_once './functionDB.php';
    	       if(empty($_GET['id'])){
    	           header("Location: index.php");
    	           exit;
    	       }
	   ?>
	   <?
	       //recuperar imovel
	       //$id = $_GET['id']
	       $lista_imovel = get_imovel($_GET['id']);
	   ?>
		<main class="imoveis">
			<article>
				<img alt="<? echo $lista_imovel['id'] ?>" src="<? echo $lista_imovel['imgPath']; ?>" title=<? echo $lista_imovel['altImg']; ?>>
				<h2><? echo $lista_imovel['altImg'] ?></h2>
			</article>
		</main>
		<div class="wrapper">
			<div>
				<a href="index.php">
					<img alt="" src="./img/arrow.png">
				</a>
			</div>
		</div>
		<footer>
			<div>Copyright Programador 2</div>
		</footer>
	</body>
</html>
