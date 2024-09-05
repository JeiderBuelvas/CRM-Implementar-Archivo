<?php
include 'is_logged.php';
require_once "../config/db.php";
require_once "../config/conexion.php";
?>

<style>
/* Estilos personalizados para la tabla al estilo Google */
.table {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    color: #333;
    background-color: #fff;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

.table th {
    background-color: #f8f9fa;
    color: #555;
    font-weight: 500;
    text-align: left;
    padding: 12px;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #dee2e6;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Estilo de los botones */
.btn {
    font-size: 14px;
    font-weight: 500;
    padding: 5px 10px;
    border-radius: 8px; /* Bordes redondeados */
    transition: background-color 0.3s ease;
}

/* Botón Editar */
.btn-primary {
    background-color: #4285f4;
    color: white;
    border: none;
}

.btn-primary:hover {
    background-color: #357ae8;
}

/* Botón Descargar */
.btn-info {
    background-color: #34a853;
    color: white;
    border: none;
}

.btn-info:hover {
    background-color: #2c8c4d;
}

/* Botón Borrar */
.btn-danger {
    background-color: #ea4335;
    color: white;
    border: none;
}

.btn-danger:hover {
    background-color: #d93025;
}

/* Estilos de los estados */
.estado-alto {
    background-color: #34a853; /* Verde */
    color: white;
    padding: 5px 10px;
    border-radius: 12px;
}

.estado-medio {
    background-color: #F0E61A; /* Amarillo */
    color: white;
    padding: 5px 10px;
    border-radius: 12px;
}


.estado-bajo {
    background-color: #ea4335; /* Rojo */
    color: white;
    padding: 5px 10px;
    border-radius: 12px;
}
</style>

<?php
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
    $numero_factura = intval($_GET['id']);
    $del1 = "DELETE FROM facturas WHERE numero_factura='" . $numero_factura . "'";
    $del2 = "DELETE FROM detalle_factura WHERE numero_factura='" . $numero_factura . "'";

    if ($delete1 = mysqli_query($con, $del1) and $delete2 = mysqli_query($con, $del2)) {
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> Datos eliminados exitosamente
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> No se pudo eliminar los datos
        </div>
        <?php
    }
}

if ($action == 'ajax') {
    $q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $sTable = "facturas, clientes, users";
    $sWhere = "";
    $sWhere .= " WHERE facturas.id_cliente=clientes.id_cliente AND facturas.id_vendedor=users.user_id";
    if ($_GET['q'] != "") {
        $sWhere .= " AND (clientes.nombre_cliente LIKE '%$q%' OR facturas.numero_factura LIKE '%$q%')";
    }

    $sWhere .= " ORDER BY facturas.id_factura DESC";

    $sql = "SELECT *, (SELECT SUM(cantidad) FROM detalle_factura WHERE numero_factura = facturas.numero_factura) AS cantidad FROM  $sTable $sWhere";

    $query = mysqli_query($con, $sql);

    echo '<div class="table-responsive">';
    echo '<table class="table table-striped table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th><strong>O.P.</strong></th>';
    echo '<th>Fecha</th>';
    echo '<th>Cliente</th>';
    echo '<th>Comercial</th>';
    echo '<th>Estado</th>';
    echo '<th class="text-right">Acciones</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_array($query)) {
        $id_factura = $row['id_factura'];
        $numero_factura = $row['numero_factura'];
        $fecha = date("d/m/Y h:i:s A", strtotime($row['fecha_factura']));
        $nombre_cliente = $row['nombre_cliente'];
        $nombre_vendedor = $row['firstname'] . " " . $row['lastname'];
        $estado_factura = $row['estado_factura'];

        $total_cantidad = $row['cantidad'];

        if ($estado_factura == 1) {
            $text_estado = "ALTO";
            $label_class = 'estado-alto';
        } elseif ($estado_factura == 2) {
            $text_estado = "MEDIO";
            $label_class = 'estado-medio';
        } else {
            $text_estado = "BAJO";
            $label_class = 'estado-bajo';
        }

        echo '<tr>';
        echo '<td><strong>' . $numero_factura . '</strong></td>';
        echo '<td>' . $fecha . '</td>';
        echo '<td>' . $nombre_cliente . '</td>';
        echo '<td>' . $nombre_vendedor . '</td>';
        echo '<td><span class="' . $label_class . '">' . $text_estado . '</span></td>';
        echo '<td class="text-right">';
        echo '<a href="editar_factura.php?id_factura=' . $id_factura . '" class="" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i></a> ';
        echo '<a href="#" class="" title="Descargar cotización" onclick="imprimir_factura(\'' . $id_factura . '\');"><i class="glyphicon glyphicon-download-alt"></i></a> ';
        echo '<a href="#" class="" title="Borrar cotización" onclick="eliminar(\'' . $numero_factura . '\')"><i class="glyphicon glyphicon-trash"></i></a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
    function exportToExcel() {
        var wb = XLSX.utils.table_to_book(document.getElementsByTagName('table')[0], {sheet:"Sheet JS"});
        XLSX.writeFile(wb, 'cotizaciones_realizadas.xlsx');
    }
</script>
