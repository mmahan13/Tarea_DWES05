<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>DWES 05</title>
  <link href="dwes.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php 
	include('connection.php'); 
	
	if(isset($_POST['SubmitButton']))
		{
			
				//creo un array de productos 
				$productos = array();
					
				//select a la bbdd
				$products = $dwes->query("SELECT * FROM dwes.products  WHERE familia_id='".$_POST['id_familia']."'");
				while ($registro = $products->fetch(PDO::FETCH_ASSOC)) {
					array_push($productos, $registro);
				}
		}

?>


<div id="encabezado">
	<h1>Tarea: Listado de productos de una familia</h1>
	<form id="form_seleccion" action="" method="post">
		Familia: <select name="id_familia" id="familias">
			<option value="0" selected>Seleccione una familia</option>
			<?php
			//creo un array de familias
			$familias = array();
			$familiabd = $dwes->query("SELECT * FROM dwes.familias");
			while ($registro = $familiabd->fetch(PDO::FETCH_ASSOC)) {
				array_push($familias, $registro);
			}
			
			foreach($familias as $familia){
				echo "<option value=".$familia['id']."> ". $familia['name'] ." </option>";
			}
			?>
		</select>
		<button type='submit' name="SubmitButton">Mostrar productos</button>
	</form>
</div>

<div id="contenido">
	<h2>Contenido</h2>
	
<table class="default">
	
	<?php 
		if(isset($productos)){
			echo"<tr>
					<td><strong>Nombre</strong></td>
					<td><strong>Descripción</strong></td>
					<td><strong>PVP</strong></td>
					<td></td>
				</tr>";
			foreach($productos as $producto){
				echo"<tr>";
					echo "<td>".$producto['name']."</td>";
					echo "<td>".$producto['descriptions']."</td>";
					echo "<td>".$producto['pvp']." EUR</td>";
					echo "<td>";
						echo "<form action='editar.php' method='post'>";
						echo "<button type='submit'>Editar</button>";
						echo "<input type='hidden' name='id' value=".$producto['id'].">";
				   echo "</form>";
				   echo "</td>";
				echo "</tr>";
			}	
		}else{
			echo "<h3>Seleccione una familia y pulse el botón Mostrar productos</h3>";
		}
		
	?>
	</table>
</div>

<div id="pie">
</div>
</body>
</html>
