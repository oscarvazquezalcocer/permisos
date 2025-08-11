<?php
session_start();
include_once '../DB/Db.php';
require_once '../classes/SessionManager.php';
require_once '../classes/Usuario.php';
require_once '../views/components/navbar.php';


// Inicializar el manager de sesión y verificar permisos
$sessionManager = SessionManager::getInstance($MySQLiconn);
$sessionManager->requireRole(23); // Solo administradores pueden acceder
$title = 'Datos de Usuarios';
$description = 'Listado de Usuarios';
?>

<?php include_once __DIR__ . '/../views/partials/head.php'; ?>

<body id="texto-normal">

    <?php include_once __DIR__ . '/../views/partials/header.php'; ?>

    <?php // Componente de navegacion navbar

    $navItems = [
        ['label' => 'Inicio', 'href' => 'inicio_Ad.php'],
        ['label' => 'Usuarios', 'href' => 'usuarios.php', 'active' => true],
        ['label' => 'Datos de Usuarios', 'href' => 'datosuser.php']
    ];

    renderNavbar($navItems, $sessionManager);
    ?>

    <section class="container-xxl">
        <div class="container-fluid">
            <div class="d-flex mb-4" style="margin-top: 12.8rem;">
                <h2>Listado de Usuarios</h2>
                <div class="mx-2">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='../registro.php'">Agregar</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body table-responsive ">
                <table id="users" class="table table-hover table-bordered table table-light table-striped table_id">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Tipo</th>
                            <th>Creado</th>
                            <th>Actualizado</th>
                            <th>Modificar</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        // Verificar si el  usuario está presente en la sesión
                        if ($sessionManager->isLoggedIn()) {
                            //$username = $_SESSION['username'];

                            $sql = "SELECT * from usuario";
                            $result = $MySQLiconn->query($sql);
                            while ($mostrar = mysqli_fetch_array($result)) {

                                // $id = $mostrar['Rol_ID'];
                                // $sql2s = "SELECT Rol_nombre FROM rol WHERE id = {$mostrar['Rol_ID']}";
                                // $result2s = $MySQLiconn->query($sql2s);
                                // $rol = mysqli_fetch_array($result2s)['Rol_nombre'];

                                // $id = $mostrar['Tipo_usuario_ID'];
                                // $sql3s = "SELECT Tipo_usuario_nombre FROM tipo_usuario WHERE id = {$mostrar['Tipo_usuario_ID']}";
                                // $result3s = $MySQLiconn->query($sql3s);
                                // $trolu = mysqli_fetch_array($result3s)['Tipo_usuario_nombre'];

                                // crear object usuario
                                $usuario = new Usuario($MySQLiconn);
                                $usuario->cargarPorId($mostrar['id']);
                        ?>
                                <tr class="data-row">
                                    <td><?php echo ($mostrar['id']); ?></td>
                                    <td><?php echo htmlspecialchars($mostrar['username']); ?></td>
                                    <td><?php echo htmlspecialchars($mostrar['email']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario->getRolNombre()); ?></td>
                                    <td><?php echo htmlspecialchars($usuario->getTipoUsuarioNombre()); ?></td>
                                    <td><?php echo htmlspecialchars($mostrar['create_at']); ?></td>
                                    <td><?php echo htmlspecialchars($mostrar['update_at']); ?></td>
                                    <td data-order="<?php echo ($mostrar['id']); ?>">
                                        <a href="update_user.php?id=<?php echo $mostrar['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('¿Deseas Editarlo ?');">
                                            <span class="glyphicon glyphicon-pencil"></span> Editar
                                        </a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<p style="font-size: 20px; color: #ff0000;">Inicie sesión para ver los datos correspondientes.</p>';
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </section>
    
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