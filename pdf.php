<?php
	session_start();
	include("pdf/mpdf.php");
	include("conn.php");
	if(empty($lista)){
		$lista = array();
	}
	$cod = $_SESSION['codcar1'];
	$sql = 'SELECT * FROM TB_COMPRA WHERE ID_CARRINHO = '.$cod;
	$result = $mysqli->query($sql);
	$forma = $_POST['pagamento'];
	$html = "
				<!DOCTYPE html>
				<html>
					<head>
						<meta charset='utf-8'>
						<title>Nota fiscal</title>
					</head>
					<body>
						<img id='logo' src='img/pagou.png'><br><br>
						<div>
							<table id='tabela'>
								<tr>
									<td id='cedente' colspan='2'>Cedente</td>
									<td id='contacedente' colspan='1'>Conta cedente</td>
									<td id='dtemissao' colspan='1'>Data de emissão</td>
								</tr>
								<tr>
									<th colspan='2'>MERCADOPAGO.COM REPRESENTAÇÕES LTDA.</th>
									<th colspan='1'>2458</th>
									<th colspan='1'>".date('d/m/Y')."</th>
								</tr>
								<tr>
									<th colspan='4'>Compra</th>
								</tr>
								<tr>
									<td>Item</td>
									<td>Valor unitário</td>
									<td>Qtde.</td>
									<td>Subtotal</td>
								</tr>";
								while($row = $result->fetch_object()){
								$idpro = $row->ID_PRODUTO;
								$sql1 = "SELECT * FROM TB_PRODUTO WHERE CD_PRODUTO ='$idpro'";
								$result1 = $mysqli->query($sql1);
								$row1 = $result1->fetch_object();
								$cdpro = $row1->CD_PRODUTO;
								$sql2 = "SELECT * FROM TB_COMPRA WHERE ID_PRODUTO ='$cdpro'";
								$result2 = $mysqli->query($sql2);
								$row2 = $result2->fetch_object();
								$total = ($row1->VL_PRECO) * ($row2->QT_PRODUTO);
								$produto = "<tr>
										<th>".$row1->NM_PRODUTO."</th>
										<th>R$".number_format($row1->VL_PRECO, 2, ',', '.')."</th>
										<th>0".$row2->QT_PRODUTO."</th>
										<th>R$".number_format($total, 2, ',', '.')."</th>
									</tr>";
								array_push($lista, $produto);
							}
							$sql = "SELECT * FROM TB_CARRINHO WHERE CD_CARRINHO ='$cod'";
							$result = $mysqli->query($sql);
							$row = $result->fetch_object();
	$restohtml = "<tr>
						<th colspan='4'>Pagamento</th>
					</tr>
					<tr>
						<td colspan='2'>Forma de pagamento</td>
						<td colspan='2'><b>VALOR TOTAL<b></td>
					</tr>
					<tr>
						<th colspan='2'>".$forma."</th>
						<th colspan='2'>R$".number_format($row->VL_TOTAL, 2, ',', '.')."</th>
					</tr>
				</table>
				<table>
					<tr>
						<td id='final'><img src='img/barra.png'></td>
						<td id='final'><img style='width: 20%;' src='img/pago.png'></td>
						<td id='final'><img style='width: 15%;' src='img/bradesco.png'></td>
					</tr>
				</table>
		</body>
	</html>";
	$arquivo = "Nota_fiscal.pdf";
	$mpdf = new mPDF(); 
	$css = file_get_contents("css/pdf.css");
	$mpdf->WriteHTML($css,1);
	$mpdf->WriteHTML($html);
	foreach ($lista as $produtos){
		$mpdf->WriteHTML($produtos);
	}
	$mpdf->WriteHTML($restohtml);
	$mpdf->Output($arquivo, 'I');
	session_destroy();
	$sql = "DELETE FROM TB_COMPRA";
	if(!$mysqli->query($sql)){
		printf("error %s\n" , $mysqli->error);
	}
	$sql1 = "DELETE FROM TB_CARRINHO";
	if(!$mysqli->query($sql1)){
		printf("error %s\n" , $mysqli->error);
	}
?>