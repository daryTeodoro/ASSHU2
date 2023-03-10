<?php
session_start();
$comprador = $_SESSION['correo'];

require_once "conexion.php";
$conexion=new conexion();
$sql=$conexion->prepare('SELECT * FROM carrito WHERE comprador=:who');
$sql->bindParam(':who',$comprador);
$sql->execute();
$result=$sql->rowCount();

if (isset($_POST['Exit'])) {
	session_destroy();
	header("Location:index.php");
}
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
		}.btn-outline-light:hover{
			color: black;
		}.icon-car{
			float: right;
			font-size: 24px;
		}.n-pedidos{
			background-color: red;
			padding: 1px 6px 2px;
			border-radius: 50px;
		}
	</style>
</head>
<body>
	<nav class="navbar fixed-top">
		<div class="container-fluid">
			<a class="navbar-brand" href="inicio.php">
				<h3 class="logo">Servicio Online</h3>
			</a> 
			<form action="" method="post">
				<a href="pedidos.php" class="btn btn-outline-light me-3">
					Pedidos
				</a>
				<a href="orden.php" class="btn btn-outline-light me-3">
					<b class="n-pedidos"><?php echo $result ?></b>
					-<ion-icon name="cart" class="icon-car"></ion-icon>
				</a>
				<button type="submit" name="Exit" class="btn btn-danger">Salir</button> <!--Boton para cerrar sesion-->
			</form>
		</div>
	</nav>

	<form action="" method="post">
	<div class="contenedor container-fluid">
		<h4><b>Productos</b></h4><hr>
		<div class="row">
			<?php
			$query=$conexion->prepare('SELECT * FROM productos WHERE stock>0 ORDER BY nombre ASC');
			$query->execute();
			$count=$query->rowCount();

			if ($count){
				$row=$query->fetch(PDO::FETCH_ASSOC);

				echo'<div class="col-3">
				    <div class="card">
				       <h5>' . $row['nombre'] . '</h5>
				       <i>Precio: </i><b>$' . number_format($row['precio'],2) . '</b>
				       <div class="mt-2">
				           <button type="sumbit" class="btn btn-success" name="add" value="'.$row['id'].'">Agregar al Carrito</button>
				        </div>
				    </div><br>
				</div>';
				$i=1;
				if ($count!=1){
					do{
						$row=$query->fetch(PDO::FETCH_ASSOC);
						echo'<div class="col-3">
						    <div class="card">
						       <h5>' . $row['nombre'] . '</h5>
						       <i>Precio: </i><b>$' . number_format($row['precio'],2) . '</b>
						       <div class="mt-2">
				                   <button type="submit" class="btn btn-success" name="add" value="'.$row['id'].'">Agregar al Carrito</button>
				                </div>
						    </div><br>
						</div>';
						$i++;
					}while ($count!=$i);
				}
			}
			?>
		</div>
	</div>
	</form>

	<?php
	if (isset($_POST['add'])) {
    $sesion = $_SESSION['correo'];
    $producto = $_POST['add'];

    $conexion= new conexion();
    $stmt=$conexion->prepare('INSERT INTO carrito(comprador,producto) VALUES (:comprador,:producto)');
    $stmt->bindParam(':comprador',$sesion);
    $stmt->bindParam(':producto',$producto);
    $stmt->execute();

    echo "<script language='javascript'>
    Swal.fire({
    	title: '<b>Producto Agregado al Carrito</b>',
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

	<!--JS Boostrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
  <!--Ionics-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>