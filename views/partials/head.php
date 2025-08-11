<?php
// obtener el nombre de la aplicación desde el archivo .env
$envPath = dirname(__DIR__, 2) . '/.env';
if (file_exists($envPath)) {
	$env = parse_ini_file($envPath);
	$app_name = $env['APP_NAME'] ?? 'Gestor de Permisos Web';
} else {
	$app_name = 'Gestor de Permisos Web'; // Valor por defecto si no se encuentra el archivo .env
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title><?= htmlspecialchars($title ?? $app_name, ENT_QUOTES, 'UTF-8') ?> - GPW</title>
	<!-- Responsividad -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?= htmlspecialchars($description ?? $app_name, ENT_QUOTES, 'UTF-8') ?> - Gestor de Permisos Web">
	<meta name="author" content="TecNM - Campus Valles">

	<!-- Link hacia los archivos de Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" 
		rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	
	<!-- Link hacia el archivo de estilos css -->
	<link rel="stylesheet" href="../CSS/Inicio.css">
	<link rel="icon" href="../IMG/logIts.png" type="image/png">

	<!-- Datatables Links -->
	<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
</head>