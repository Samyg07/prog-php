<?php

require_once "main.php";

#   Almacenando Datos   #

$usuario = limpiar_cadenas($_POST['login_usuario']);
$clave = limpiar_cadenas($_POST['login_clave']);

#   Verificar campos obligatorios      #
if ($usuario == "" || $clave == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}
#   Verificar datos     #
if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El USUARIO no coincide con el formato solicitado
    </div>
    ';
    exit();
}

#   Verificar Clave     #
if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El CLAVE no coincide con el formato solicitado
    </div>
    ';
    exit();
}

$cheack_user = conexion();
$cheack_user = $cheack_user->query("SELECT * FROM usuarios 
WHERE usuario_usuario = '$usuario'");

if ($cheack_user->rowCount() == 1) {
    $cheack_user = $cheack_user->fetch();

    if ($cheack_user['usuario_usuario'] == $usuario && password_verify($clave, $cheack_user['usuario_clave'])) {

        $_SESSION['id'] = $cheack_user['usuario_id'];
        $_SESSION['nombre'] = $cheack_user['usuario_nombre'];
        $_SESSION['apellido'] = $cheack_user['usuario_apellido'];
        $_SESSION['usuario'] = $cheack_user['usuario_usuario'];

        if (headers_sent()) {
            echo "<script> window.location.href='index.php?vista=home' </script>";
        } else {
            header("Location: index.php?vista=home");
        }
    } else {
        echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Usuario o clave incorrectos
        </div>
        ';
    }
} else {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Usuario o clave incorrectos
    </div>
    ';
}

$cheack_user = null;
