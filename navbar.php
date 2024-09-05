<?php
// Inicia la sesión si aún no se ha iniciado
if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
}

// Verifica si el usuario ha iniciado sesión y su ID es igual a 1
$mostrar_menu = false;
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
    $mostrar_menu = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Título de tu página</title>
    <!-- Enlaces a CSS y otros elementos del encabezado -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            padding-left: 220px; /* Espacio para el menú lateral */
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px; /* Ancho del menú lateral */
            height: 100%;
            background-color: #f8f8f8; /* Color de fondo del menú lateral */
            border-right: 1px solid #ddd; /* Línea divisoria */
            padding-top: 20px; /* Espaciado superior */
        }
        .navbar-brand img {
            width: 110px; /* Ajusta el ancho según tus necesidades */
            height: auto; /* Esto mantiene la proporción de aspecto */
            margin-bottom: 20px; /* Espacio debajo del logo */
        }
        .sidebar a {
            padding: 10px 15px;
            display: block;
            color: #333;
            text-decoration: none;
            margin-top: 10px; /* Ajusta el margen superior según sea necesario */
            border-radius: 4px; /* Bordes redondeados para los enlaces */
        }
        .sidebar a:hover {
            background-color: #ddd; /* Color de fondo al pasar el mouse */
        }
        .sidebar .active {
            background-color: #337ab7; /* Color de fondo para el elemento activo */
            color: white; /* Color del texto para el elemento activo */
        }
        @media (max-width: 768px) {
            body {
                padding-left: 0; /* Sin espacio para el menú lateral en pantallas pequeñas */
            }
            .sidebar {
                width: 100%; /* Menú ocupa todo el ancho en pantallas pequeñas */
                height: auto; /* Ajustar altura automáticamente */
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="navbar-brand">
        <img src="img/logo.png" alt="Logo">
    </div>
    <div class="sidebar">
        <a href="facturas.php" class="<?php echo $active_facturas;?>"><i class='glyphicon glyphicon-list-alt'></i> Orden de Trabajo</a>
        <a href="productos.php" class="<?php echo $active_productos;?>"><i class='glyphicon glyphicon-shopping-cart'></i> Servicios</a>
        <a href="clientes.php" class="<?php echo $active_clientes;?>"><i class='glyphicon glyphicon-user'></i> Directorio de Clientes</a>
        <?php if ($mostrar_menu): ?>
            <a href="usuarios.php" class="<?php echo $active_usuarios;?>"><i class='glyphicon glyphicon-lock'></i> Usuarios</a>
            <a href="perfil.php" class="<?php if(isset($active_perfil)){echo $active_perfil;}?>"><i class='glyphicon glyphicon-cog'></i> Configuración</a>
        <?php endif; ?>
        <a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Cerrar Sesión</a>
    </div>
</body>
</html>
