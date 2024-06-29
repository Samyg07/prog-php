<?php
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";

if (isset($busqueda) && $busqueda != "") {
    $consulta_datos = "SELECT * FROM usuarios   WHERE ((usuario_id!='" . $_SESSION['id'] . "') 
        AND (usuario_nombre LIKE '%$busqueda%' OR 
        usuario_apellido LIKE '%$busqueda%' OR 
        usuario_usuario LIKE '%$busqueda%' 
        OR usuario_email LIKE '%$busqueda%'))
    ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
    
    $consulta_total = "SELECT COUNT(usuario_id) FROM usuarios WHERE ((usuario_id!='" . $_SESSION['id'] . "') 
        AND (usuario_nombre LIKE '%$busqueda%' OR 
        usuario_apellido LIKE '%$busqueda%' OR 
        usuario_usuario LIKE '%$busqueda%' 
        OR usuario_email LIKE '%$busqueda%'))";

} else {
    $consulta_datos = "SELECT * FROM usuarios   WHERE usuario_id!='" . $_SESSION['id'] . "'
    ORDER BY usuario_nombre ASC LIMIT $inicio, $registros";
    
    $consulta_total = "SELECT COUNT(usuario_id) FROM usuarios WHERE usuario_id!='" . $_SESSION['id'] . "'";
}

$conexion= conexion();
 
