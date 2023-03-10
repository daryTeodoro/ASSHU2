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
	<style type="text/css">
		.Main{
			height: 100vh;
			display: flex;
            align-self: center;
            align-items: center;
            justify-content: center;
            flex-direction: column;
		}
	</style>
</head>
<body>
	<div class="Main">
		<form action="" method="post">
			<div class="mb-3">
				<label for="correo" class="form-label">Correo Electronico</label>
				<input type="email" class="form-control border border-dark" name="correo" id="correo" placeholder="Ingresa tu correo" required>
			</div>
            <div class="mb-3">
            	<label for="psw" class="form-label">Contraseña</label>
                <input type="password" class="form-control border border-dark" name="psw" id="psw" placeholder="Ingresa tu contraseña" required>
            </div>
            <center><button type="submit" class="btn btn-primary" name="Entrar">Iniciar Sesion</button></center>
        </form>
	</div>

	<?php
      //Codigo PHP para el login
      if (isset($_POST['Entrar'])) {
        require_once "conexion.php";

        $correo=$_POST['correo'];
        $psw=$_POST['psw'];

        //Sentencia SQL para verificar que exista una cuenta con esas credenciales
        $conexion= new conexion();
        $query=$conexion->prepare('SELECT * FROM usuario WHERE correo=:correo AND psw=:psw');
        $query->bindParam(':correo',$correo);
        $query->bindParam(':psw',$psw);
        $query->execute();

        $count=$query->rowCount(); //Cuenta si existe el registro

        if ($count==1){ //Si existe se dirige al inicio
          $_SESSION['correo']=$correo;
          header("Location:inicio.php");
        }else{ //si no envia alerta de error
          echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'error',
            title: 'Datos Incorrectos',
            text: 'El usuario/contaseña es incorrecto',
            })
          </script>";
        }
      }
      ?>

	<!--JS Boostrap-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>
</html>