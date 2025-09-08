<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">

        <title> Registrate </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

        <!-- Link hacia el archivo de estilos css -->
        <link rel="stylesheet" href="CSS/Inicio.css">
        <link rel="stylesheet" href="CSS/Normalize.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link rel="icon" href="IMG/logIts.png" type="image/png">
    </head>

    <body>

        <header id="barra" class="text-white">
           GESTOR DE PERMISOS WEB (GPW)
        <img src="IMG/LogoTecNMBlanco.png" class="log1">
        <img src="IMG/LogIts.png" class="log2">
        <img src="IMG/Logo.png" class="log3">
        <div class="rectangulo1"></div>
        <div class="rectangulo2"></div>
        </header>
        <section class="center-container">
        <div id="texto-derecha">
        <button type="button" class="btn-close" aria-label="Close" onclick="window.location.href = 'ROL_AD/usuarios.php';"></button>
        </div>
        <div>
                <h2>REGISTRO DE USUARIO</h2>
                <hr class="border border-primary border-3 opacity-65">
            </div>

            <br>
            <br>
            <div id="texto-izquierda" class="container">
            <form id="registro-form" class="form-label" action="DB/signup.php" method="Post">

                <div class="row">
                  <div class="col">
                    <label>NOMBRE(S)</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Ej. Angel Eduardo" name="nombre" aria-label=".form-control-lg example"
                      required>
                  </div>
                  <div class="col">
                    <label>APELLIDO(S)</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Ej. Gutierres Aguilar" name="apellido" aria-label=".form-control-lg example"
                    required>
                  </div>
                </div>
                <br>

                <div class="row">
                    <div class="col">
                      <label>CORREO ELECTRONICO</label>
                      <input class="form-control form-control-lg" type="email" placeholder="name@example.com" name="email" id="email" aria-label=".form-control-lg example"
                      oninput="autocompletarUsuario()" required>
                    </div>
                    <div class="col">
                      <label>SEXO</label>
                      <select class="form-select form-select-lg mb-3" aria-label=".form-control-lg example" name="sexo" required>
                        <option value="">Seleccione una Opción</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>

                    </div>
                  </div>
                  <br>

                <div>
                    <label for="puesto">PUESTO</label>
                    <select class="form-select form-select-lg mb-3" name="puesto" required>
                        <option value="">Seleccione una Opción</option>
                        <option value="Docente">Docente</option>
                        <option value="Administrativo">Admistrativo</option>
                        <option value="Personal">Personal</option>
                    </select>
                </div>

                <div>
                    <label>AREA DE ADSCRIPCIÓN</label>
                    <select class="form-select form-select-lg mb-3" name="area" required>
                        <option value="">Seleccione una Opción</option>
                        <option value="Ingenieria En Sistemas Computacionales">Ingenieria En Sistemas Computacionales</option>
                        <option value="Ingenieria En Administracion">Ingenieria En Administracion</option>
                        <option value="Ingenieria Industrial">Ingenieria Industrial</option>
                        <option value="Ingenieria Ambiental">Ingenieria Ambiental</option>
                        <option value="Ingenieria Civil">Ingenieria Civil</option>
                        <option value="Ingenieria En Gestion Empresarial">Ingenieria En Gestion Empresarial</option>
                        <option value="Jefe de Departamento de Carreras Profesionales">Jefe de Departamento de Carreras Profesionales</option>
                        <option value="Jefe de Departamento de Recursos Humanos">Jefe de Departamento de Recursos Humanos</option>
                        <option value="Jefe Directo">Jefe Directo-Subdireccion Academica</option>
                        <option value="Jefe Directo">Jefe Directo-Planeacion y Vinculacion</option>
                        <option value="Jefe Directo">Jefe Directo-Administracion y Finanzas</option>
                        <option value="Intendente">Intendente</option>
                    </select>
                </div>
                <br>

                <div>
                   <label>NOMBRE DE USUARIO</label>
                   <input class="form-control form-control-lg" type="text" name="username"  id="username" aria-label=".form-control-lg example"
                   readonly required>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col">
                      <label>ROL</label>
                      <select class="form-select form-select-lg mb-3" name="puestoa" required>
                      <option value="21">Personal</option>
                        <option value="22">Jefe Directo</option>
                        <option value="23">Administrador</option>
                        <option value="24">Recursos Humanos</option>
                        <option value="25">Inactivo</option>
                        </select>
                    </div>
                  </div>
                  <br>
                  <br>
                <div class="row">
                    <div class="col">
                      <label>TIPO DE USUARIO</label>
                      <select class="form-select form-select-lg mb-3" name="tipoa" required>
                      <option value="">Seleccione una Opción</option>
                        <option value="15">Docente</option>
                        <option value="16">No Docente</option>
                        </select>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col">
                      <label>AREA DE TRABAJO</label>
                      <select class="form-select form-select-lg mb-3" name="areaU" required>
                      <option value="">Seleccione una Opción</option>
                        <option value="1">Subdireccion Academica</option>
                        <option value="2">Planeacion y Vinculacion</option>
                        <option value="3">Administracion y Finanzas </option>
                        </select>
                    </div>
                  </div>
                  <br>
                <div class="input-group">
                    <span class="input-group-text">CONTRASEÑA</span>
                    <div class="form-floating">
                      <input type="password" class="form-control" name="password" placeholder="contraseña"
                      required>
                      <label>Contraseña</label>
                    </div>
                  </div>
                <br>
                <div id="texto-centrar">
                  <input type="submit" title="Registrate" value="Registrar" class="btn btn-primary">
                </div>
            </form>
            </div>
    </section>
    <script> // js alerta
        document.addEventListener("DOMContentLoaded", function() {
            const registroForm = document.getElementById("registro-form");

            registroForm.addEventListener("submit", function(event) {
                event.preventDefault();

                fetch(registroForm.action, {
                    method: "POST",
                    body: new FormData(registroForm)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                      Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Usuario creado con exito!',
                      showConfirmButton: false,
                       timer: 800
                      }).then(() => {
                      // redireccion
                       window.location.href = '../GESTOR%20-%20LOCAL/Rol_Ad/usuarios.php';});
                    } else {
                        Swal.fire("¡Error!", data.message, "error");
                    }
                })
                .catch(error => {
                    Swal.fire("¡Error!", "Error al comunicarse con el servidor.", "error");
                });
            });
        });
    </script>
    <script src="JS/autoname.js"></script>
    </body>
</html>
