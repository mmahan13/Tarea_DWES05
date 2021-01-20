<?php
    session_start();
    include('connection.php'); 

    if(isset($_POST['id']))
    {
        //creo un array de productos 
        $producto = array();
                        
        //select a la bbdd
        try{
            $products = $dwes->query("SELECT * FROM dwes.products  WHERE id='".$_POST['id']."'");
            while ($producto = $products->fetch(PDO::FETCH_ASSOC)) 
            {
                $_SESSION['data'] = [
                    'id' => $_POST['id'],
                    'shortname' => $producto['shortname'],
                    'name' => $producto['name'],
                    'descriptions' => $producto['descriptions'],
                    'pvp' => $producto['pvp']
                ];
            }
        }
        catch(PDOException $error){
            echo "Error ".$error->getMessage()."<br />";
        }
       
    }
    
    //al presionar el boton cancelar redirijo al listado
    if(isset($_POST['cancelButton']))
    { 
        session_destroy();
        header('Location: listado.php');
        exit;
    }
    
    //al presionar el boton actualiar
    if(isset($_POST['SubmitButton']))
    {  
        if(!empty($_POST['shortname']))
        {
            if(strlen($_POST['shortname']) <= 45)
            {
                if(!empty($_POST['name']))
                {
                    if(strlen($_POST['name']) <= 60)
                    {
                        if(!empty($_POST['pvp']))
                        {
                            //Si todoas las condiciones se cumplen hacemos el Update a la bbdd
                            $sql = "UPDATE dwes.products SET shortname=:shortname, name=:name, descriptions=:descriptions,pvp=:pvp WHERE id=:id";
                            $query = $dwes->prepare($sql);
                            $query->bindparam(':id', $_SESSION['data']['id']);
                            $query->bindparam(':shortname', $_POST['shortname']);
                            $query->bindparam(':name', $_POST['name']);
                            $query->bindparam(':descriptions', $_POST['descriptions']);
                            $query->bindparam(':pvp', $_POST['pvp']);
                            $query->execute();
                            
                            //se destruye la sesion
                            session_destroy();
                            
                            //redirijo a actualiar.php
                            header('Location: actualizar.php');
                            exit;
                        }
                    }
                }
            }
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
        Nombre corto:<input type='text' name='shortname' value="<?php echo $_SESSION['data']['shortname']; ?>">
        <?php
               if (isset($_POST['SubmitButton']) && empty($_POST['shortname']))
                echo "<p style='color:red'>El campo nombre corto es obligatorio</p>";

                
                if (isset($_POST['SubmitButton']) && strlen($_POST['shortname']) >= 45)
                echo "<p style='color:red'>El campo nombre corto es muy largo</p>";
          ?>
        <br><br>
        Nombre:<br>
        <textarea name="name" value="" rows="5" cols="50"><?php echo $_SESSION['data']['name']; ?></textarea>
        <?php
               if (isset($_POST['SubmitButton']) && empty($_POST['name']))
                echo "<p style='color:red'>El campo nombre es obligatorio</p>";

                if (isset($_POST['SubmitButton']) && strlen($_POST['name']) >= 60)
                echo "<p style='color:red'>El campo nombre es muy largo</p>";
          ?>
        <br><br>
        Descripción:<br>
        <textarea name="descriptions" rows="7" cols="50"><?php echo $_SESSION['data']['descriptions']; ?></textarea>
        <br><br>
        PVP:<input type='text' name='pvp' value="<?php echo $_SESSION['data']['pvp']; ?>">
        <?php
               if (isset($_POST['SubmitButton']) && empty($_POST['pvp']))
                echo "<p style='color:red'>El campo pvp es obligatorio</p>";
          ?>
        <br><br><br>
        <button type="submit" name="SubmitButton">Actualizar</button>
        <button type="submit" name="cancelButton">Cancelar</button>
    </form>
</div>

<div id="pie">
</div>
</body>
</html>
