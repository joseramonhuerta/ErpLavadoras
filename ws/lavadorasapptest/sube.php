<?php

$foto = $_FILES['foto'];
      $nombre_foto = $foto['name'];
      $type        = $foto['type'];
      $url_temp    = $foto['tpm_name'];

      $imgproducto = 'img_producto.png';

      if($nombre_foto != '')
      {
        $destino = 'img/uploads/productos';
        $img_nombre ='img_'.md5(date('d-m-Y H:m:s'));
        $imgproducto = $img_nombre.'.jpg';
        $src         = $destino.$imgproducto;
      }
         if($query_insert){
          if($nombre_foto != ''){
            move_uploaded_file($url_temp,$src);
          }




?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<form action="" method="post">
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
</body>
</html>