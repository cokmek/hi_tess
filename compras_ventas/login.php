<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | Compras y Ventas</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Login</h2>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label>Usuario:</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Clave:</label>
                <input type="password" name="clave" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require_once 'includes/conexion.php';
            $usuario = $_POST['usuario'];
            $clave = md5($_POST['clave']);

            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND clave = ?");
            $stmt->execute([$usuario, $clave]);
            $usuarioData = $stmt->fetch();

            if ($usuarioData) {
                $_SESSION['usuario'] = $usuarioData['usuario'];
                $_SESSION['nombre'] = $usuarioData['nombre'];
                $_SESSION['rol'] = $usuarioData['rol'];
                header('Location: index.php');
                exit;
            } else {
                echo "<div class='alert alert-danger mt-3'>Credenciales incorrectas</div>";
            }
        }
        ?>
    </div>
</body>
</html>
