<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>DWES 05</title>
  
  <link href="dwes.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="encabezado">
	<h1>Tarea:Edición de un producto</h1>
</div>

<div id="contenido">
    <h2>Se han actualizado los datos.</h2>
    <?php 
     if(isset($_POST['submitContinuar']))
    { 
        header('Location: listado.php');
        exit;
    } 
        ?>
    <form  method='post'>
        <button type="submit" name="submitContinuar">Continuar</button>
    </form>
</div>

<div id="pie">
</div>
</body>
</html>