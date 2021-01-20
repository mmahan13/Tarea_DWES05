<?php
    session_start();
    include('connection.php'); 

    if(isset($_POST['id'])){
        $_SESSION['id'] = $_POST['id'];
    }

    if(isset($_POST['cancelButton']))
    {
       
        header('Location: listado.php');
        exit;
    }
 
    if(isset($_POST['SubmitButton']))
    {
        
        if(!empty($_POST['shortname']) || !empty($_POST['name'])) 
        {
         
            $sql = "UPDATE dwes.products SET shortname=:shortname, name=:name, descriptions=:descriptions,pvp=:pvp WHERE id=:id";
            $query = $dwes->prepare($sql);
            $query->bindparam(':id', $_SESSION['id']);
            $query->bindparam(':shortname', $_POST['shortname']);
            $query->bindparam(':name', $_POST['name']);
            $query->bindparam(':descriptions', $_POST['descriptions']);
            $query->bindparam(':pvp', $_POST['pvp']);
            $query->execute();
            
            //se destruye la sesion
            session_destroy();

            header('Location: actualizar.php');
            exit;
        }else{
          
                //creo un array de productos 
                $producto = array();
                                
                //select a la bbdd
                $products = $dwes->query("SELECT * FROM dwes.products  WHERE id='".$_SESSION['id']."'");
                while ($producto = $products->fetch(PDO::FETCH_ASSOC)) {
                
                $shortname = $producto['shortname'];
                $name = $producto['name'];
                $descriptions = $producto['descriptions'];
                $pvp = $producto['pvp'];

                }
            }
      
    }else{

        //creo un array de productos 
        $producto = array();
                        
        //select a la bbdd
        $products = $dwes->query("SELECT * FROM dwes.products  WHERE id='".$_SESSION['id']."'");
        while ($producto = $products->fetch(PDO::FETCH_ASSOC)) {
        
        $shortname = $producto['shortname'];
        $name = $producto['name'];
        $descriptions = $producto['descriptions'];
        $pvp = $producto['pvp'];

        }
    }
   
?>

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
    <h2>Producto:</h2>
    <form  method='post'>
        Nombre corto:<input type='text' name='shortname' value="<?php echo $shortname; ?>">
        <?php
               if (isset($_POST['SubmitButton']) && empty($_POST['shortname']))
                echo "<p style='color:red'>El campo nombre corto es obligatorio</p>";
          ?>
        <br><br>
        Nombre:<br>
        <textarea name="name" value="" rows="5" cols="50"><?php echo $name; ?></textarea>
        <?php
               if (isset($_POST['SubmitButton']) && empty($_POST['name']))
                echo "<p style='color:red'>El campo nombre es obligatorio</p>";
          ?>
        <br><br>
        Descripción:<br>
        <textarea name="descriptions" rows="7" cols="50"><?php echo $descriptions; ?></textarea>
        <br><br>
        PVP:<input type='text' name='pvp' value="<?php echo $pvp; ?>">
        <br><br><br>
        <button type="submit" name="SubmitButton">Actualizar</button>
        <button type="submit" name="cancelButton">Cancelar</button>
    </form>
</div>

<div id="pie">
</div>
</body>
</html>
