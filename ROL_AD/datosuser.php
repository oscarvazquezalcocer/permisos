<?php
include_once '../DB/Db.php';
require_once '../classes/SessionManager.php';
require_once '../views/components/navbar.php';

// session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Inicializar el manager de sesión y verificar permisos
$sessionManager = SessionManager::getInstance($MySQLiconn);
$sessionManager->requireRole(23); // Solo administradores pueden acceder a esta página
$title = 'Perfiles de Usuarios';
$description = 'Listado de Perfiles de Datos de Usuarios';
?>

<?php include_once __DIR__ . '/../views/partials/head.php'; ?>
<?php include_once __DIR__ . '/../views/partials/header.php'; ?>

<body>

	<?php // Componente de navegacion navbar
    
	$navItems = [
        ['label' => 'Inicio', 'href' => 'inicio_Ad.php'],
        ['label' => 'Usuarios', 'href' => 'usuarios.php'],
        ['label' => 'Datos de Usuarios', 'href' => 'datosuser.php', 'active' => true]
    ];

    renderNavbar($navItems, $sessionManager);
    ?>


    <!-- Contenido principal con más espaciado y mejor estructura -->
    <main class="container-xxl" style="margin-top: 12.8rem;">
        <div class="container-fluid">
            <!-- Título de la tabla con mejor diseño -->
            <div class="row mb-3">
                <h2 class="text-dark">Listado de Datos de Usuarios</h2>
            </div>
            
            <!-- Tabla de usuarios con clases de Bootstrap 5 -->
			<div class="card">
				<div class="card-body table-responsive">
					<table id="users" class="table table-hover table-striped">
						<thead class="table-dark">
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Apellido</th>
								<th>Sexo</th>
								<th>Área</th>
								<th>Puesto</th>
								<th>Creado</th>
								<th>Actualizado</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Verificar si el usuario está presente en la sesión
							if ($sessionManager->isLoggedIn()) {
								// Mostrar los datos de los usuarios
								$sqls = "SELECT * from perfil";
								$result = $MySQLiconn->query($sqls);
								while ($mostrars = mysqli_fetch_array($result)) {
							?>
									<tr>
										<td><?php echo ($mostrars['User_ID']); ?></td>
										<td><?php echo htmlspecialchars($mostrars['nombre']); ?></td>
										<td><?php echo htmlspecialchars($mostrars['apellido']); ?></td>
										<td><?php echo htmlspecialchars($mostrars['sexo']); ?></td>
										<td><?php echo htmlspecialchars($mostrars['area']); ?></td>
										<td><?php echo htmlspecialchars($mostrars['puesto']); ?></td>
										<td><?php echo htmlspecialchars($mostrars['create_at']); ?></td>
										<td><?php echo htmlspecialchars($mostrars['update_at']); ?></td>
									</tr>
							<?php
								}
							} else {
								echo 
								'<tr>
									<td colspan="8" class="text-center text-danger fw-bold">
										Inicie sesión para ver los datos correspondientes.
									</td>
								</tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
        </div>
    </main>

	<?php include_once __DIR__ . '/../views/partials/footer.php'; ?>
    
	<script>
        initDataTable('users', {
            layout: {
                topStart: 'search',
                topEnd: 'pageLength',
                bottomStart: 'info',
                bottomEnd: 'paging'
            },
            responsive: true
        });
    </script>
	</body>
</html>