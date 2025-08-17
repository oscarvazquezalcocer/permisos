## Análisis del Proyecto: Gestor de Permisos Web (GPW)

### Contexto General del Proyecto

El **Gestor de Permisos Web (GPW)** es una aplicación web desarrollada en PHP para gestionar solicitudes de permisos laborales en una institución educativa (TecNM - Tecnológico Nacional de México). El sistema permite a los empleados solicitar diferentes tipos de permisos y a los supervisores gestionarlos a través de un flujo de aprobación.

### 📋 Contexto Técnico

**Arquitectura del Sistema**

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 3.4.0
- **Backend**: PHP (versión 8.1.13)
- **Base de Datos**: MySQL 8.0.31
- **Servidor Local**: Laragon (Apache + MySQL)
- **Estructura**: MVC básica sin framework

**Estructura de Directorios**

```plaint/text
permisos/
├── index.php                 # Página de login principal
├── registro.php              # Registro de nuevos usuarios
├── permisos.sql              # Script de base de datos
├── CSS/                      # Estilos del sistema
├── JS/                       # Scripts JavaScript
├── IMG/                      # Recursos gráficos
├── DB/                       # Controladores de base de datos
├── PHPMailer/               # Librería para envío de emails
├── Adjuntos_tmp/            # Archivos adjuntos temporales
├── ROL1/                    # Interfaz para Personal
├── ROL2/                    # Interfaz para Jefes Directos
├── ROL3/                    # Interfaz para Recursos Humanos
├── ROL_AD/                  # Interfaz para Administradores
└── ROL_IN/                  # Interfaz para usuarios inactivos
```

**Base de Datos**

**Nombre**: `gestorpermisos`

**Tablas principales**:

* `usuario`: Credenciales y datos básicos
* `perfil`: Información personal detallada
* `solicitud`: Solicitudes de permisos
* `rol`: Tipos de usuario (Personal, Jefe, Admin, RH, Inactivo)
* `tipo_solicitud`: Tipos de permisos (Permiso, Justificación Médica, Cambio de Horario)
* `estado`: Estados de solicitud (En espera, Aceptada, Rechazada, Visto Bueno)


**Tecnologías Utilizadas**

* **PHP**: Lógica del servidor, manejo de sesiones
* **MySQL**: Almacenamiento de datos con relaciones FK
* **Bootstrap**: Framework CSS para responsividad
* **Font Awesome**: Iconografía
* **PHPMailer**: Notificaciones por correo electrónico
* **XLSX.js**: Exportación de reportes a Excel

### 🏢 Contexto Lógico/Proyecto

**Propósito del Sistema**

El GPW digitaliza el proceso tradicional de solicitud de permisos laborales en instituciones educativas, eliminando el papeleo y centralizando la gestión en una plataforma web accesible.

**Flujo de Trabajo**

1. **Solicitud**: El empleado ingresa y crea una solicitud de permiso
2. **Revisión Inicial**: El jefe directo revisa y puede aceptar/rechazar
3. **Revisión Final**: Recursos Humanos da el visto bueno final
4. **Notificación**: El sistema notifica por email sobre cambios de estado
5. **Seguimiento**: Todas las partes pueden consultar el historial

**Tipos de Usuario y Roles**

**ROL1 - Personal (Empleados)**

* **Archivos**: [Inicio.php](ROL1/Inicio.php), [Permiso.php](ROL1/Permiso.php), [Justifiacion.php](ROL1/Justificacion.php)
* **Funciones**:
    - Crear solicitudes de permisos
    - Consultar estatus de solicitudes
    - Ver historial personal
    - Recibir notificaciones

**ROL2 - Jefes Directos**

* **Archivos**: [Inicio2.php](ROL2/Inicio2.php), [status.php](ROL2/status.php)
* **Funciones**:
    - Revisar solicitudes de su área
    - Aprobar/rechazar con comentarios
    - Ver historial de su departamento

**ROL3 - Recursos Humanos**

* **Archivos**: [Inicio3.php](ROL3/Inicio3.php), [bitacora.php](ROL3/bitacora.php)
* **Funciones**:
    - Dar visto bueno final
    - Generar reportes y bitácoras
    - Exportar datos a Excel
    - Gestionar motivos de permisos

**ROL_AD - Administradores**

* **Archivos**: [inicio_Ad.php](ROL_AD/inicio_Ad.php), [usuarios.php](ROL_AD/usuarios.php)
* **Funciones**:
    - Gestión completa de usuarios
    - Configuración del sistema
    - Mantenimiento de datos

**Tipos de Solicitudes**

1. **Permiso Regular**: Ausencias planificadas con/sin reposición de horario
2. **Justificación Médica**: Ausencias por motivos de salud con documentación
3. **Cambio de Horario**: Modificaciones en horarios de trabajo

**Estados de Solicitud**

* **En espera (31)**: Solicitud pendiente de revisión
* **Aceptada (32)**: Aprobada por jefe directo
* **Rechazada (33)**: Denegada con motivo
* **Visto Bueno (34)**: Aprobación final de RH

**Características del Sistema**

**Seguridad**

* Autenticación por sesiones PHP
* Contraseñas hasheadas con `password_hash()`
* Control de acceso por roles
* Validación de formularios

**Notificaciones**
* Email automático via `PHPMailer` en cambios de estado
* Alertas en interfaz web
* Sistema de notificaciones internas

**Reportes y Seguimiento**
* Bitácora completa en [bitacora.php](ROL3/bitacora.php)
* Exportación a Excel
* Historial por usuario y departamento
* Filtros por tipo de solicitud y fecha

**Flujo de Datos**

1. **Login**: [index.php](index.php) → [Login_C.php](DB/Login_C.php)
2. **Solicitud**: ROL1 → [permiso_C.php](DB/permiso_C.php) → Base de datos
3. **Aprobación**: ROL2 → [status.php](ROL2/status.php) → Email + BD
4. **Visto** Bueno: ROL3 → [status3.php](ROL3/status3.php) → Email + BD

**Configuración de Entorno**

Para levantar el proyecto localmente:

1. **Laragon activo** con Apache y MySQL
2. **Base de datos**: Importar [permisos.sql](permisos.sql)
3. **Acceso**: `http://localhost/permisos/`
4. **Configuración BD**: Verificar [Db.php](DB/Db.php)

El sistema está diseñado para instituciones educativas del TecNM, con una estructura organizacional específica (Subdirección Académica, Planeación y Vinculación, Administración y Finanzas) y flujos de aprobación jerárquicos típicos del sector educativo público mexicano.