<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Mercado Livre</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<?php
			include('conn.php');
			session_start();
			if(!isset($_SESSION['codcar1'])){
				$sql = "INSERT INTO TB_CARRINHO VALUES (null, null)";
				if(!$mysqli->query($sql)){
					printf("error %s\n" , $mysqli->error);
				}
				$sql = "SELECT * FROM TB_CARRINHO";
				$result = $mysqli->query($sql);
				$row = $result->fetch_object();
				$_SESSION['codcar1'] = $row->CD_CARRINHO;
			}
		?>
		<meta charset="utf-8">
	</head>
	<body style="font-family: helvetica;">
		<form action="index.php?id=0" method="post">
			<div id="up">
				<header>
					<a href="index.php"><img id="logo" src="img/logo.png" title="Mercado Livre" /></a>
					<input type="text" name="busca" placeholder="Clique aqui e pesquise coisas do seu interesse..." title="Pesquisar" />
					<img id="busca" src="img/busca.png" />
					<a href="#"><input type="submit" id="botao" value="Buscar"/></a>
					<a href="carrinho.php"><img id="carrinho" src="img/carrinho.png" title="Meu Carrinho" /></a>
					<div class="indicador">
						<?php
							$cont = "SELECT COUNT(CD_COMPRA) AS QUANTIDADE FROM TB_COMPRA WHERE ID_CARRINHO = '".$_SESSION['codcar1']."'";
							$resultado = $mysqli->query($cont);
							$row = $resultado->fetch_object();
							echo "<b>".$row->QUANTIDADE."</b>";
						?>
					</div>
				</header>
					<ul class="menu">
						<li><a href="#"><img id="imgmenu" src="img/menu.png" title="Menu" /></a>
						<ul id="ul">
							<?php
								$sql = "SELECT * FROM TB_CATEGORIA";
								$result = $mysqli->query($sql);
								while($row = $result->fetch_object()){
									echo "<li><a class='a1' href='index.php?id=".$row->CD_CATEGORIA."'>".$row->NM_CATEGORIA."</a></li>";
								}
							?>
							</li>
						</ul>
					</ul>
			</div>
		</form>
		<nav>
			<div class="nav" align="center"></br>
				<?php
					if(isset($_GET['id'])){
						if($_GET['id'] == 0){
							if(isset($_POST['busca'])){
								$sql = "SELECT * FROM TB_PRODUTO WHERE NM_PRODUTO LIKE '%".$_POST['busca']."%'";
								$result = $mysqli->query($sql);
								echo "<legend><h1>Resultado de Busca: '<i>".$_POST['busca']."</i>'</h1><legend><br>";
								if($result->num_rows <= 0){
									echo "<br>Nenhum resultado encontrado para <b>'".$_POST['busca']."'</b>.";
								}
								else{
									echo "<form method='post'>";
									while($row = $result->fetch_object()){
									echo "<div class='caixa'><label><img class='img' src='".$row->DS_ENDERECO."' title='".$row->NM_PRODUTO."'><b><br>".$row->NM_PRODUTO."</b><br>Por apenas <b class='red'>R$ ".number_format($row->VL_PRECO, 2, ',', '.')."</b>.<br><input type='checkbox' name='produto[]' value='".$row->CD_PRODUTO."'></label> <input type='number' name='qtde".$row->CD_PRODUTO."' value=0></div><br>";
									}
									echo "<br><input class='room' type='submit' value='Adicionar ao Carrinho'><br><br><br>";
									echo "</form>";
								}	
							}
							if(isset($_POST['produto'])){
								foreach($_POST['produto'] as $produto){
									$qtde = $_POST["qtde$produto"];
									$sql = "INSERT INTO TB_COMPRA VALUES(null, '$produto', ".$_SESSION['codcar1'].", '$qtde')";
									if(!$mysqli->query($sql)){
										printf("error %s\n" , $mysqli->error);
									}
									$sql1 = "SELECT * FROM TB_PRODUTO WHERE CD_PRODUTO ='".$produto."'";
									$result1 = $mysqli->query($sql1);
									$row1 = $result1->fetch_object();
									$sql2 = "SELECT * FROM TB_CARRINHO WHERE CD_CARRINHO ='".$_SESSION['codcar1']."'";
									$result2 = $mysqli->query($sql2);
									$row2 = $result2->fetch_object();
									$sql3 = "SELECT * FROM TB_COMPRA WHERE ID_PRODUTO = '$produto'";
									$result3 = $mysqli->query($sql3);
									$row3 = $result3->fetch_object();
									$preco = ($row1->VL_PRECO) * ($row3->QT_PRODUTO); 
									$sql4 = "UPDATE TB_CARRINHO SET VL_TOTAL = '".$row2->VL_TOTAL."' + '$preco'";
									if(!$mysqli->query($sql4)){
										printf("error %s\n" , $mysqli->error);
									}
								}
								echo "<h2>Produto(s) adicionado(s) ao carrinho!</h2>";
							}
						}
						else{
							$id = $_GET['id'];
							$sql = "SELECT * FROM TB_CATEGORIA WHERE CD_CATEGORIA = '$id'";
							$result = $mysqli->query($sql);
							$row = $result->fetch_object();
							echo "<h1>".$row->NM_CATEGORIA."</h1></br>";
							echo "<form method='post'>";
							$sql =  "SELECT * FROM TB_PRODUTO WHERE ID_CATEGORIA = '$id'";
							$result = $mysqli->query($sql);
							while($row = $result->fetch_object()){
								echo "<div class='caixa'><label><img class='img' src='".$row->DS_ENDERECO."' title='".$row->NM_PRODUTO."'><b><br>".$row->NM_PRODUTO."</b><br>Por apenas <b class='red'>R$ ".number_format($row->VL_PRECO, 2, ',', '.')."</b>.<br><input type='checkbox' name='produto[]' value='".$row->CD_PRODUTO."'></label> <input class='numero' type='number' name='qtde".$row->CD_PRODUTO."' value=0></div><br>";
							}
							echo "<br><input class='room' type='submit' value='Adicionar ao Carrinho'><br><br><br>";
							echo "</form></div>";
							if(isset($_POST['produto'])){
								foreach($_POST['produto'] as $produto){
									$qtde = $_POST["qtde$produto"];
									$sql = "INSERT INTO TB_COMPRA VALUES(null, '$produto', ".$_SESSION['codcar1'].", '$qtde')";
									if(!$mysqli->query($sql)){
										printf("error %s\n" , $mysqli->error);
									}
									$sql1 = "SELECT * FROM TB_PRODUTO WHERE CD_PRODUTO ='".$produto."'";
									$result1 = $mysqli->query($sql1);
									$row1 = $result1->fetch_object();
									$sql2 = "SELECT * FROM TB_CARRINHO WHERE CD_CARRINHO ='".$_SESSION['codcar1']."'";
									$result2 = $mysqli->query($sql2);
									$row2 = $result2->fetch_object();
									$sql3 = "SELECT * FROM TB_COMPRA WHERE ID_PRODUTO = '$produto'";
									$result3 = $mysqli->query($sql3);
									$row3 = $result3->fetch_object();
									$preco = ($row1->VL_PRECO) * ($row3->QT_PRODUTO); 
									$sql4 = "UPDATE TB_CARRINHO SET VL_TOTAL = '".$row2->VL_TOTAL."' + '$preco'";
									if(!$mysqli->query($sql4)){
										printf("error %s\n" , $mysqli->error);
									}
								}
							}
						}
					}
					else{
				?>
					<h1>Bem-vindo ao Mercado Livre!</h1></br>
				<?php
						$sql = "SELECT * FROM TB_CATEGORIA";
						$result = $mysqli->query($sql);
						while($row = $result->fetch_object()){
							echo "<a class='home' href='index.php?id=".$row->CD_CATEGORIA."'><img class='imghome' src='".$row->DS_ENDERECO."' title='".$row->NM_CATEGORIA."' /></a></br></br></br>";
						}
					}
				?>
			</div></br>
		</nav>
		<footer>
			<b>Mercado Livre agradece sua visita!<a id="link" href="https://www.mercadolivre.com.br" target="_blank"> Clique aqui</a> e acesse o site da nossa filial.</b>
		</footer>
	</body>
	<script>
		$(document).ready(function(){
			$(".caixa").click(function(){
				$(".numero", this).val(1);	
			});
		});
	</script>
	<style type="text/css">
		input[type=number]
		{
			width: 3%;
			text-align: center;
			border-radius: 5px;
		}
		#link
		{
			text-decoration: none;
			color: #0C1793;
		}
		#link:visited
		{
			color: #0C1793;
		}
		#carinha
		{
			width: 40%;
			border-color: none;
			border-width: 0px;
			border-style: none;
		}
		.blue
		{
			color: darkblue;
		}
		#total
		{
			margin-left: -60%;
			padding-top: 40px;
			font-size: 22px;
		}
		#up
		{
			position: fixed;
			z-index: 99;
			margin-top: -67px;
		}
		#pagamento
		{
			margin-right: 7%;
			margin-top: -95px;
			float: right;
		}

		.imghome
		{
			width: 57%;
			height: 400px;
			transition: 0.3s;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		.imghome:hover
		{
			width: 62%;
			height: 450px;
			transition: 0.3s;
			border-width: 6px;
		}
		.room
		{
			border-radius: 3px 3px 3px 3px;
			border-color: #2840af;
			color: #2840af;

		}
		.room:hover
		{
			background:  #2840af;
			border-color: #2840af;
			color: white;

		}
		.nav
		{
			padding-top: 3px;
			margin-top: 10px;
			background-color: white;
			min-height: 620px;
			width: 98%;
			border-radius: 20px 20px 20px 20px;
		}
		#imgmenu
		{
			position: absolute;
			width: 80%;
			margin-left: 5%;
			margin-top: -6px;
			border-color: none;
			border-width: 0px;
			border-style: none;
			border-radius: 0%;
		}
		input[type=text]
		{
			margin-top: 14px;
			margin-left: 5%;
			height: 40px;
			width: 40%;
			border-radius: 5px 5px 5px 5px;
			position: absolute;
			border-color: white;
			padding-left: 5%;
			font-size: 15px;
		}
		.indicador
		{
			text-align: center;
			position: absolute;
			background: red;
			border-radius: 100%;
			padding-top: 3px;
			width: 1.7%;
			height: 19px;
			font-size: 14px;
			margin-left: 94.2%;
			margin-top: -50px;
		}
		#botao
		{
			margin-left: 52%;
			margin-top: 14px;
			background-size: 55px;
			border-radius: 13px 13px 13px 13px;
			border-width: 2px;
			width: 7%;
			height: 45px;
			font-weight: bold;
			color: white;
			border-color: #2840af;
			background-color: #2840af;
			position: absolute;
		}
		#botao:active
		{
			color: #2840af;
			border-color: #2840af;
			background-color: white;
			position: absolute;
		}
		#busca
		{
			position: absolute;
			width: 3.8%;
			margin-left: 5.2%;
			margin-top: 14px;
			border-color: none;
			border-width: 0px;
			border-style: none;
			border-radius: 0%;
		}
		#carrinho
		{
			width: 3.5%;
			position: absolute;
			margin-left: 73.5%;
			margin-top: 17px;
			border-color: none;
			border-width: 0px;
			border-style: none;
			border-radius: 0%;
		}
		#logo
		{
			z-index: 1;
			margin-top: -24px;
			margin-left: -80%;
			width: 15%;
			border-color: none;
			border-width: 0px;
			border-style: none;
			border-radius: 0%;
		}
		img
		{
			width: 22%;
			border-color:  #0C1793;
			border-width: 6px;
			border-style: groove;
			border-radius: 10px 10px 10px 10px;
		}
		.imgcar
		{
			width: 22%;
			height: 200px;
			border-color: #0C1793;
			border-width: 6px;
			border-style: groove;
			border-radius: 5px 5px 5px 5px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		header
		{
			background: yellow;
			text-align: center;
			height: 75px;
			width: 100.5%;
			margin-top: -8px;
			margin-left: -0.77%;
			border-color: #2840af;
			border-width: 2.5px;
			border-style: groove;
		}
		#header
		{
			width: 101.1%;
		}
		nav
		{
			border-color: #2840af;
			border-width: 2.5px;
			border-top-style: none;
			border-left-style: groove;
			border-right-style: groove;
			border-bottom-style: none;
			margin-top: 75px;
			margin-left: -0.77%;
			background: yellow;
			width: 99.1%;
			padding-left: 2%;
			padding-top: 15px;
			min-height: 200px;
		}
		ul
		{
			position: absolute;
			margin-top: -58px;
			margin-left: 81%;
			padding: 0;
			list-style: none;
			width: 5%;
			z-index: 99;
		}
		#ul
		{
			position: absolute;
			margin-top: 50px;
			margin-left: -390%;
			padding: 0;
			list-style: none;
			width: 150px;

		}
		ul li
		{
			position: relative;
		}
		li ul
		{	

			position: absolute;
			left: 215px;
			top: -6px;
			display: none;
			text-align: center;
		}
		#ul li a
		{	

			display: block;
			text-decoration: none;
			color: #1e2e7a;
			background: yellow;
			padding: 10px;
			border: 1.5px groove #1e2e7a;
			height: 15px;
			font-weight: bold;
			border-radius: 5px 5px 5px 5px;
			transition: 0.15s;

		}
		#ul #conso a
		{	
			border-radius: 0px 0px 5px 5px;
		}
		#ul:hover li:hover a:hover
		{	
			color: #1e2e7a;
			background: lightgray;
			transition: 0.15s;
		}
		li:hover ul
		{
			display:block;
		}
		footer
		{
			background: yellow;
			height: 27px;
			text-align: center;
			width: 100.1%;
			margin-left: -0.77%;
			border-color: #2840af;
			border-width: 2.5px;
			border-style: groove;
			padding-left: 1%;
			padding-top: 10px;
		}
		.caixa
		{
			position: relative;	
			width: 100%;
		}
		.caixa1
		{

			margin-top: -243px;
			margin-left: 40%;
			text-align: center;
			position: absolute;
			z-index: 5;
		}
		#lojinha
		{
			display: inline;
			background: black;
		}
		.img
		{
			width: 25%;
			height: 250px;
			box-shadow: 5px 5px 5px rgba(0,0,0,0.5);
		}
		.red
		{
			color: red;
			text-decoration: blink;
		}
		.caixa2
		{

			margin-top: -243px;
			margin-left: 44%;
			text-align: center;
			position: absolute;
			z-index: 5;
		}
		#produtos
		{
			overflow: auto;
			background-color: lightgray;
			height: 300px;
			border-top-style: dashed;
			border-bottom-style: dashed;  
		}
	</style>
</html>