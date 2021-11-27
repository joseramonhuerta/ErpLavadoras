<?php 
    session_start();
    if($_SESSION['rol'] != 1)
    {
      header("location: index.php");
    }

include "conexion.php";
  if(!empty($_POST)){
        

    $alert='';
    if(empty($_POST['descripcion']) || empty($_POST['proveedor']) || empty($_POST['precio']) || empty($_POST['existencia']))
    {
      $alert='<p class="msg_error">Todos los campos menos foto son obigatorios.</p>';
    }else{

      include "conexion.php";

      $descripcion = $_POST['descripcion'];
      $proveedor  = $_POST['proveedor'];
      $precio  = $_POST['precio'];
      $existencia  = $_POST['existencia'];
      

      $foto = $_FILES['foto'];
      $nombre_foto = $foto['name'];
      $type        = $foto['type'];
      $url_temp    = $foto['tmp_name'];

      $imgproducto = 'img_producto.png';

      if($nombre_foto != '')
      {
        $destino = 'img/uploads/';
        $img_nombre ='img_'.md5(date('d-m-Y H:m:s'));
        $imgproducto = $img_nombre.'.jpg';
        $src         = $destino.$imgproducto;
      } 

         
      $query = mysqli_query($conection,"SELECT * FROM producto WHERE descripcion = '$descripcion' ");
      $result = mysqli_fetch_array($query);

      if($result > 0){
        $alert='<p class="msg_error">la descripcion ya existe.</p>';
      }else{

        $query_insert = mysqli_query($conection, "INSERT INTO producto(descripcion,proveedor,precio,existencia,foto)
          VALUES('$descripcion','$proveedor','$precio','$existencia','$imgproducto')");

        if($query_insert){
          if($nombre_foto != ''){
            move_uploaded_file($url_temp,$src);
          }

          $alert='<p class="msg_save">producto creado correctamente.</p>';
        }else{
          $alert='<p class="msg_error">Error al crear el producto.</p>';
        }
      }
    }
  }



 ?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <?php include "includes/scripts.php"; ?>
  <title>Registro Trabajador</title>
</head>
<body>
  <?php include "includes/header.php"; ?>
  <section id="container">
    

    <div class="form_register">
      
         <h1>Registro de Producto</h1>
         <hr>
         <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

         <form action="" method="post" enctype="multipart/form-data">
             <div class="photo">
            <label for="foto">Foto</label>
                <div class="prevPhoto">
                <span class="delPhoto notBlock">X</span>
                <label for="foto"></label>
                </div>
                <div class="upimg">
                <input type="file" name="foto" id="foto">
                </div>
                <div id="form_alert"></div>
               </div>
             <label for="descripcion">descripcion</label>
             <input type="text" name="descripcion" id="descripcion" placeholder="descripcion">
             
             <label for="proveedor">tipo de marca</label>

             <?php 
                     
                       $query_proveedor = mysqli_query($conection,"SELECT * FROM proveedor");
                       $result_proveedor = mysqli_num_rows($query_proveedor);
                       
                       
                       

              ?>
             <select name="proveedor" id="proveedor">
                  <?php
                     if($result_proveedor > 0)
                       {
                          while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                       ?>
                       <option value="<?php echo $proveedor["codproveedor"]; ?>"><?php echo $proveedor["proveedor"]?></option>
                       <?php
                        # code...
                         } 
                       }


                   ?>
                  
                  
             </select>
             <label for="precio">precio</label>
             <input type="number" maxlength="5" class="filterNumeric" name="precio" id="precio" placeholder="precio del producto">

             <label for="existencia">cantidad</label>
             <input type="number" maxlength="5" class="filterNumeric" name="existencia" id="existencia" placeholder="cantidad de producto">
             
             
             
             
             <input type="submit" value="Crear producto" class="btn_save">


         </form>


    </div>



  </section>



  <?php include "includes/footer.php"; ?>
</body>
</html>