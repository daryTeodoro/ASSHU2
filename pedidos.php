<?php
session_start();
require_once "conexion.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="img/favicon.png" alt="favicon">
	<title>Servicio Online</title>
	<!--Libreria de Boostrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <!-- JQuery Validate library -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Libreria de sweetalert 2-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!--API de Google Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Abel&family=Tilt+Warp&display=swap" rel="stylesheet">
	<style type="text/css">
		.Main{
			height: 100vh;
			display: flex;
      align-self: center;
      align-items: center;
      justify-content: center;
      flex-direction: column;
		}.navbar{
			vertical-align: center;
			box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.5);
			background-color: #000;
			height: 80px;
		}.logo{
			color: #fff;
			font-family: 'Tilt Warp', cursive;
		}.welcome{
			color: white;
		}.contenedor{
			width: 100%;
			padding: 100px 50px 20px;
			color: #000;
			font-family: 'Abel', sans-serif;
		}.col-4{
			padding: 20px 10px;
		}.card{
			text-align: center;
			padding: 20px 10px 15px;
			border: 2px solid black;
			background-color: #d3fbfb;
		}
	</style>
</head>
<body>
	<nav class="navbar fixed-top">
		<div class="container-fluid">
			<a class="navbar-brand" href="inicio.php">
				<h3 class="logo">Servicio Online</h3>
			</a> 
				<a href="inicio.php" type="submit" name="Exit" class="btn btn-danger">Regresar</a> <!--Boton para cerrar sesion-->
		</div>
	</nav>

	<form action="" method="post">
	<div class="contenedor container-fluid">
		<h4><b>Pedidos Realizados</b></h4><hr>
			<?php
			$Usuario=$_SESSION['correo'];
			$conexion=new conexion();
			$query=$conexion->prepare('SELECT * FROM pedidos WHERE cliente=:cliente');
			$query->bindParam(':cliente',$Usuario);
			$query->execute();
			$count=$query->rowCount();

			if ($count){
				$row=$query->fetch(PDO::FETCH_ASSOC);

				$Estatus=$row['status'];
				if($Estatus==1){
					$Respuesta= "<i style='color:gray'>Orden en Proceso</i>";
				}else if($Estatus==2){
					$Respuesta= "<i style='color:red'>Orden Rechazda</i>";
				}else if($Estatus==3){
					$Respuesta= "<i style='color:green'>Orden Aceptada</i>";
				}

				echo'<div class="row p-3 border border-dark border-2 rounded">
				    <div class="col-5 d-flex align-items-center justify-content-center" align="center">
				      Pedido: #' . $row['id'] . '
				    </div>
				    <div class="col-7 d-flex align-items-center justify-content-center" align="center">
				      <b>Estatus</b>: ' . $Respuesta . '
				    </div>
				    </div><br>';
				$i=1;
				if ($count!=1){
					do{
						$row=$query->fetch(PDO::FETCH_ASSOC);
						
						$Estatus=$row['status'];
						if($Estatus==1){
							$Respuesta= "<i style='color:gray'>Orden en Proceso</i>";
						}else if($Estatus==2){
							$Respuesta= "<i style='color:red'>Orden Rechazda</i>";
						}else if($Estatus==3){
							$Respuesta= "<i style='color:green'>Orden Aceptada</i>";
						}

						echo'<div class="row p-3 border border-dark border-2 rounded">
				    <div class="col-5 d-flex align-items-center justify-content-center" align="center">
				      Pedido: #' . $row['id'] . '
				    </div>
				    <div class="col-7 d-flex align-items-center justify-content-center" align="center">
				      <b>Estatus</b>: ' . $Respuesta . '
				    </div>
				    </div><br>';
						$i++;
					}while ($count!=$i);
				}
			}
			?>
	</div>
	</form>

	<?php
	if (isset($_POST['aceptar'])) {
    $n_pedido = $_POST['aceptar'];

    $conexion= new conexion();
    $aceptar=$conexion->prepare('UPDATE pedidos SET status=3, admin=2 WHERE id=:n_pedido');
    $aceptar->bindParam(':n_pedido',$n_pedido);
    $aceptar->execute();

    echo "<script language='javascript'>
    Swal.fire({
    	title: '<b>Pedido Aceptado</b>',
      icon: 'success',
      html: '<br><a href=inicio.php style=color:red;text-decoration:none;padding:10px;>Aceptar</a>',
      showCloseButton: false,
      showCancelButton: false,
      showConfirmButton: false,
      focusConfirm: false,
      allowOutsideClick: false
    })</script>";
  }
  ?>

  <?php
	if (isset($_POST['rechazar'])) {
    $n_pedido = $_POST['rechazar'];

    $conexion= new conexion();
    $rechazo=$conexion->prepare('UPDATE pedidos SET status=2, admin=2 WHERE id=:n_pedido');
    $rechazo->bindParam(':n_pedido',$n_pedido);
    $rechazo->execute();

    echo "<script language='javascript'>
    Swal.fire({
    	title: '<b>Pedido Rechazado</b>',
      icon: 'error',
      html: '<br><a href=inicio.php style=color:red;text-decoration:none;padding:10px;>Aceptar</a>',
      showCloseButton: false,
      showCancelButton: false,
      showConfirmButton: false,
      focusConfirm: false,
      allowOutsideClick: false
    })</script>";
  }
  ?>

	<!--JS Boostrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
  <!--Ionics-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>