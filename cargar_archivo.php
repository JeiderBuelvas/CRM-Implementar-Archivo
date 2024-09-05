<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cotizaciones";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado un archivo
if (isset($_FILES['documento']) && $_FILES['documento']['error'] == 0) {
    $cotizacion_id = $_POST['cotizacion_id'];
    $archivo_temp = $_FILES['documento']['tmp_name'];
    $archivo_nombre = $_FILES['documento']['name'];
    $archivo_ruta = 'uploads/' . basename($archivo_nombre);

    // Mover el archivo al directorio de destino
    if (move_uploaded_file($archivo_temp, $archivo_ruta)) {
        // Insertar información del archivo en la base de datos
        $sql = "INSERT INTO archivos_cotizacion (cotizacion_id, nombre_archivo, ruta_archivo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $cotizacion_id, $archivo_nombre, $archivo_ruta);

        if ($stmt->execute()) {
            echo "Archivo cargado exitosamente.";
        } else {
            echo "Error al guardar el archivo en la base de datos.";
        }

        $stmt->close();
    } else {
        echo "Error al mover el archivo.";
    }
} else {
    echo "No se ha enviado ningún archivo o se produjo un error en la carga.";
}

$conn->close();
?>
