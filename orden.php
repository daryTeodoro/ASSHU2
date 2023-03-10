<?php
session_start();
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
			padding: 100px 50px;
			color: #000;
			font-family: 'Abel', sans-serif;
		}.col-4{
			padding: 20px 10px;
		}.card{
			text-align: center;
			padding: 20px 10px 15px;
			border: 2px solid black;
			background-color: #f7ff9a;
		}
	</style>
</head>
<body>
	<nav class="navbar fixed-top">
		<div class="container-fluid">
			<a class="navbar-brand" href="inicio.php">
				<h3 class="logo">Servicio Online</h3>
			</a> 
			<a href="inicio.php" class="btn btn-danger">Regresar</a>
		</div>
	</nav>

	<form action="" method="post">
	<div class="contenedor container-fluid">
		<h4><b>Mis Ordenes</b></h4><hr>
		<div class="row">
			<?php
			require_once "conexion.php";
			$comprador = $_SESSION['correo'];

			$conexion=new conexion();
			$query=$conexion->prepare('SELECT * FROM carrito WHERE comprador=:who ORDER BY producto ASC');
			$query->bindParam(':who',$comprador);
			$query->execute();
			$count=$query->rowCount();

			if ($count){
				$row=$query->fetch(PDO::FETCH_ASSOC);
				$producto=$row['producto'];

				$stmt=$conexion->prepare('SELECT * FROM productos WHERE id=:id');
			  $stmt->bindParam(':id',$producto);
			  $stmt->execute();

			  $linea=$stmt->fetch(PDO::FETCH_ASSOC);

				echo'<div class="col-3">
				    <div class="card">
				       <h5>' . $linea['nombre'] . '</h5>
				       <i>Precio: </i><b>$' . number_format($linea['precio'],2) . '</b>
				    </div><br>
				</div>';
				$i=1;
				if ($count!=1){
					do{
						$row=$query->fetch(PDO::FETCH_ASSOC);
				    $producto=$row['producto'];

				    $stmt=$conexion->prepare('SELECT * FROM productos WHERE id=:id');
			      $stmt->bindParam(':id',$producto);
			      $stmt->execute();

			      $linea=$stmt->fetch(PDO::FETCH_ASSOC);

			      echo'<div class="col-3">
			          <div class="card">
			             <h5>' . $linea['nombre'] . '</h5>
				           <i>Precio: </i><b>$' . number_format($linea['precio'],2) . '</b>
				        </div><br>
				    </div>';
						$i++;
					}while ($count!=$i);
				}
			}else{
				echo "No tienes pedidos";
				echo "<script language='javascript'>
        Swal.fire({
    	    title: '<b>No tienes pedidos</b>',
          icon: 'warning',
          html: '<br><a href=inicio.php style=color:darkgreen;text-decoration:none;padding:10px;>Aceptar</a>',
          showCloseButton: false,
          showCancelButton: false,
          showConfirmButton: false,
          focusConfirm: false,
          allowOutsideClick: false
        })</script>";
			}
			?>
		</div>
	</div>
	</form>

  <div class="bg-dark fixed-bottom" align="center">
  	<form action="" method="post">
  		<button class="btn btn-warning m-3" name="buy">Comprar</button>
  	</form>
  </div>

  <?php
	if (isset($_POST['buy'])) {
		$user = $_SESSION['correo'];
		$sentencia=$conexion->prepare('DELETE FROM carrito WHERE comprador=:user');
		$sentencia->bindParam(':user',$user);
		$sentencia->execute();

		$insertar=$conexion->prepare('INSERT INTO pedidos(cliente,status,admin) VALUES (:cliente,1,1)');
		$insertar->bindParam(':cliente',$user);
		$insertar->execute();

		echo "<script language='javascript'>
    Swal.fire({
    	title: '<b>Orden Enviada</b>',
      icon: 'success',
      html: '<br><a href=inicio.php style=color:darkgreen;text-decoration:none;padding:10px;>Aceptar</a>',
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