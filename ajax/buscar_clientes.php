<?php
	include('is_logged.php'); // Archivo verifica que el usuario que intenta acceder a la URL está logueado
	require_once ("../config/db.php"); // Contiene las variables de configuración para conectar a la base de datos
	require_once ("../config/conexion.php"); // Contiene función que conecta a la base de datos
	
	$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
	if (isset($_GET['id'])) {
		$id_cliente = intval($_GET['id']);
		$query = mysqli_query($con, "SELECT * FROM facturas WHERE id_cliente='" . $id_cliente . "'");
		$count = mysqli_num_rows($query);
		if ($count == 0) {
			if ($delete1 = mysqli_query($con, "DELETE FROM clientes WHERE id_cliente='" . $id_cliente . "'")) {
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Aviso!</strong> Datos eliminados exitosamente.
				</div>
				<?php 
			} else {
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error!</strong> Lo siento, algo ha salido mal. Intenta nuevamente.
				</div>
				<?php
			}
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar este cliente. Existen facturas vinculadas a este producto. 
			</div>
			<?php
		}
	}

	if ($action == 'ajax') {
		$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
		$aColumns = array('nombre_cliente'); // Columnas de búsqueda
		$sTable = "clientes";
		$sWhere = "";
		if ($_GET['q'] != "") {
			$sWhere = "WHERE (";
			for ($i = 0; $i < count($aColumns); $i++) {
				$sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ')';
		}
		$sWhere .= " ORDER BY nombre_cliente";
		include 'pagination.php'; // Include pagination file

		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
		$per_page = 10; // How many records you want to show
		$adjacents = 4; // Gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;

		$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
		$row = mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows / $per_page);
		$reload = './clientes.php';

		$sql = "SELECT * FROM $sTable $sWhere LIMIT $offset, $per_page";
		$query = mysqli_query($con, $sql);

		if ($numrows > 0) {
			?>
			<div class="table-responsive">
			  <table class="table table-hover">
				<tr class="table-info">
					<th>NIT</th>
					<th>Nombre</th>
					<th>Contacto</th>
					<th>Dirección</th>
					<th>Estado</th>
					<th>Agregado</th>
					<th class='text-right'>Acciones</th>
				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) {
					$id_cliente = $row['id_cliente'];
					$cedula = $row['cedula'];
					$nombre_cliente = $row['nombre_cliente'];
					$contacto = $row['contacto'];
					$cargo = $row['cargo'];
					$ciudad = $row['ciudad'];
					$telefono_cliente = $row['telefono_cliente'];
					$email_cliente = $row['email_cliente'];
					$direccion_cliente = $row['direccion_cliente'];
					$status_cliente = $row['status_cliente'];
					$estado = ($status_cliente == 1) ? "Activo" : "Inactivo";
					$date_added = date('d/m/Y', strtotime($row['date_added']));
					?>
					<tr>
						<td><?php echo $cedula; ?></td>
						<td>
							<a href="#" data-toggle="tooltip" data-placement="top" data-html="true" title="<?php echo $telefono_cliente; ?> - <?php echo $email_cliente; ?>">
								<div class="contact-info">
									<div class="icon"><i class='fas fa-user'></i></div>
									<div class="details">
										<div class="name"><?php echo $nombre_cliente; ?></div>
										<div class="info">
											<i class='fas fa-phone'></i> <?php echo $telefono_cliente; ?><br>
											<i class='fas fa-envelope'></i> <?php echo $email_cliente; ?>
										</div>
									</div>
								</div>
							</a>
						</td>
						<td>
							<a href="#" data-toggle="tooltip" data-placement="top" data-html="true" title="<?php echo $contacto; ?> - <?php echo $cargo; ?>">
								<div class="contact-info">
									<div class="icon"><i class='fas fa-user'></i></div>
									<div class="details">
										<div class="name"><?php echo $contacto; ?></div>
										<div class="info">
											<i class='fas fa-phone'>Cargo:</i> <?php echo $cargo; ?>
										</div>
									</div>
								</div>
							</a>
						</td>
						<td>
							<a href="#" data-toggle="tooltip" data-placement="top" data-html="true" title="<?php echo $direccion_cliente; ?> - <?php echo $ciudad; ?>">
								<div class="contact-info">
									<div class="icon"><i class='fas fa-map-marker-alt'></i></div>
									<div class="details">
										<div class="name"><?php echo $direccion_cliente; ?></div>
										<div class="info">
											<i class='fas fa-map-marker-alt'>Ciudad:</i> <?php echo $ciudad; ?>
										</div>
									</div>
								</div>
							</a>
						</td>
						<td><?php echo $estado; ?></td>
						<td><?php echo $date_added; ?></td>
						<td class="text-right">
							<a href="#" class='' title='Editar cliente' onclick="obtener_datos('<?php echo $id_cliente; ?>');" data-toggle="modal" data-target="#myModal2">
								<i class="glyphicon glyphicon-edit"></i>
							</a>
							<a href="#" class='' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')">
								<i class="glyphicon glyphicon-trash"></i>
							</a>
						</td>
					</tr>
				<?php
				}
				?>
			  </table>
			</div>
			<?php
		}
	}
?>

<style>
.contact-info {
    display: flex;
    align-items: center;
}

.contact-info .icon {
    margin-right: 10px;
}

.contact-info .details {
    display: flex;
    flex-direction: column;
}

.contact-info .name {
    font-weight: bold;
    margin-bottom: 5px;
}

.contact-info .info {
    color: #777;
    font-size: 14px;
}

.contact-info .info i {
    margin-right: 5px;
}

.table-hover tbody tr:hover {
    background-color: #f5f5f5;
}
</style>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
