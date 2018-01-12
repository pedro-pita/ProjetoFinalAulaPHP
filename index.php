<!DOCTYPE html>
<!-- Centrar elementos inline, inline-block, inline table, inline flex -->
<html lang="pt-pt">
<head>
	<meta chaset="utf-8">
	<link rel="stylesheet" href="./css/style.css">
	<title>Home</title>
	<script src="http://ajax.googleleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
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
			<img alt="logo" src="./img/admin.png">
		</a>
	</div>
	<?php 
	   include_once './functionDB.php';
	   //lista de imoveis
	   $lista = get_imoveis_list();
	?>
	<main class="imoveis">
	<?php 
	   foreach ($lista as $fetch_imovelData):
	?>
		<article>
			<img src="<?php echo $fetch_imovelData['imgPath'];?>" alt="<?php echo $fetch_imovelData['id'];?>" title="<?php echo $fetch_imovelData['altImg'];?>"/>
			<h2><?php echo $fetch_imovelData['altImg'];?></h2>
			<a href="ver.php?id=<?php echo $fetch_imovelData['id'];  ?>">Mais informação</a>
		</article> 
	<?php endforeach; ?>		
	</main>
	<footer>
		<div>Copyright Programador 2&deg;ano</div>
	</footer>
		
</body>
</html>