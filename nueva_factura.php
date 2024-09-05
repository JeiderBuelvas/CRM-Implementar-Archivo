<?php
session_start();
if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
$active_facturas = "active";
$active_productos = "";
$active_clientes = "";
$active_usuarios = "";    
$title = "Nueva Factura";

/* Connect To Database */
require_once("config/db.php"); // Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); // Contiene funcion que conecta a la base de datos
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php"); ?>
    <style>
        .file-preview {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }
        .file-preview-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .file-preview-item img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include("navbar.php"); ?>  
    <div class="container">
        <div class="panel panel-info">
            <div class="panel">
                <h4><i class='glyphicon glyphicon-edit'></i> Nueva Orden de Trabajo</h4>
            </div>
            <div class="panel-body">
                <?php 
                    include("modal/buscar_productos.php");
                    include("modal/registro_clientes.php");
                    include("modal/registro_productos.php");
                ?>
                <form class="form-horizontal" role="form" id="datos_factura" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="nombre_cliente" class="col-md-1 control-label">Cliente</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required>
                            <input id="id_cliente" type='hidden'>    
                        </div>
                        <label for="tel1" class="col-md-1 control-label">Teléfono</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" readonly>
                        </div>
                        <label for="mail" class="col-md-1 control-label">Email</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control input-sm" id="mail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="empresa" class="col-md-1 control-label">Vendedor</label>
                        <div class="col-md-3">
                            <select class="form-control input-sm" id="id_vendedor">
                                <?php
                                    $sql_vendedor = mysqli_query($con, "select * from users order by lastname");
                                    while ($rw = mysqli_fetch_array($sql_vendedor)) {
                                        $id_vendedor = $rw["user_id"];
                                        $nombre_vendedor = $rw["firstname"] . " " . $rw["lastname"];
                                        $selected = ($id_vendedor == $_SESSION['user_id']) ? "selected" : "";
                                        ?>
                                        <option value="<?php echo $id_vendedor ?>" <?php echo $selected; ?>><?php echo $nombre_vendedor ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <label for="tel2" class="col-md-1 control-label">Fecha</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control input-sm" id="fecha" value="<?php echo date("d/m/Y"); ?>" readonly>
                        </div>

                        <label for="email" class="col-md-1 control-label">Pago</label>
                        <div class="col-md-3">
                            <select class='form-control input-sm' id="condiciones">
                                <option value="1">100% anticipo contra proforma</option>
                                <option value="2">A Convenir.</option>
                                <option value="3">30 Dias Fecha Facturada</option>
                                <option value="4">50% anticipo - 50% crédito</option>
                                <option value="5">50% anticipo - 50% pago contado</option>
                            </select>
                        </div>
                    </div>
                    <label for="nota" class="col-md-1 control-label">Observación </label>
                    <div class="col-md-3">
                        <textarea type="text" class="form-control input-sm" id="nota" placeholder="Escribe tu observación...."></textarea>
                    </div>
                    <label for="tiempo_entrega" class="col-md-1 control-label">Historial</label>
                    <div class="col-md-7">
                        <textarea type="text" class="form-control input-sm" name="tiempo_entrega" id="tiempo_entrega" placeholder="Tiempo de Entrega..."></textarea>
                    </div>
                    
                    <!-- Campo para cargar archivos -->
                    <div class="form-group row">
                        <label for="archivos" class="col-md-1 control-label">Archivos</label>
                        <div class="col-md-3">
                            <input type="file" class="form-control input-sm" id="archivos" name="archivos[]" multiple>
                        </div>
                    </div>
                    
                    <!-- Contenedor para mostrar archivos cargados -->
                    <div class="file-preview" id="file-preview">
                        <!-- Los archivos cargados se mostrarán aquí -->
                    </div>
                
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="button" class="" data-toggle="modal" data-target="#nuevoProducto">
                                <span class="glyphicon glyphicon-plus"></span> Nuevo Servicio
                            </button>
                            <button type="button" class="" data-toggle="modal" data-target="#nuevoCliente">
                                <span class="glyphicon glyphicon-user"></span> Nuevo cliente
                            </button>
                            <button type="button" class="" data-toggle="modal" data-target="#myModal">
                                <span class="glyphicon glyphicon-search"></span> Agregar Servicio
                            </button>
                            <button type="submit" class="">
                                <span class="glyphicon glyphicon-print"></span>Guardar
                            </button>
                        </div>    
                    </div>
                </form>    
                
                <div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->            
            </div>
        </div>        
        <div class="row-fluid">
            <div class="col-md-12"></div>    
        </div>
    </div>
    <hr>
    <?php include("footer.php"); ?>
    <script type="text/javascript" src="js/VentanaCentrada.js"></script>
    <script type="text/javascript" src="js/nueva_factura.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#nombre_cliente").autocomplete({
                source: "./ajax/autocomplete/clientes.php",
                minLength: 2,
                select: function(event, ui) {
                    event.preventDefault();
                    $('#id_cliente').val(ui.item.id_cliente);
                    $('#nombre_cliente').val(ui.item.nombre_cliente);
                    $('#tel1').val(ui.item.telefono_cliente);
                    $('#mail').val(ui.item.email_cliente);
                }
            });
        });

        $("#nombre_cliente").on("keydown", function(event) {
            if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
                $("#id_cliente").val("");
                $("#tel1").val("");
                $("#mail").val("");
            }
            if (event.keyCode == $.ui.keyCode.DELETE) {
                $("#nombre_cliente").val("");
                $("#id_cliente").val("");
                $("#tel1").val("");
                $("#mail").val("");
            }
        });

        // Script para mostrar vista previa de archivos
        document.getElementById('archivos').addEventListener('change', function(event) {
            const fileInput = event.target;
            const fileList = fileInput.files;
            const previewContainer = document.getElementById('file-preview');
            previewContainer.innerHTML = ''; // Limpiar vista previa

            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];
                const fileName = file.name;
                const fileType = file.type;
                let icon;

                // Asignar íconos según el tipo de archivo
                if (fileType.includes('pdf')) {
                    icon = 'path/to/pdf-icon.png'; // Reemplaza con la ruta a tu ícono de PDF
                } else if (fileType.includes('word')) {
                    icon = 'path/to/word-icon.png'; // Reemplaza con la ruta a tu ícono de Word
                } else if (fileType.includes('excel')) {
                    icon = 'path/to/excel-icon.png'; // Reemplaza con la ruta a tu ícono de Excel
                } else {
                    icon = 'path/to/excel-icon.png'; // Ícono por defecto
                }

                // Crear elemento de vista previa
                const filePreviewItem = document.createElement('div');
                filePreviewItem.classList.add('file-preview-item');
                filePreviewItem.innerHTML = `<img src="${icon}" alt="${fileType}">${fileName}`;
                previewContainer.appendChild(filePreviewItem);
            }
        });
    </script>
</body>
</html>
