<?php

require_once "main.php";

#   Almacenando Datos   #

$nombre = limpiar_cadenas($_POST['usuario_nombre']);
$apellido = limpiar_cadenas($_POST['usuario_apellido']);

$usuario = limpiar_cadenas($_POST['usuario_usuario']);
$email = limpiar_cadenas($_POST['usuario_email']);

$clave1 = limpiar_cadenas($_POST['usuario_clave_1']);
$clave2 = limpiar_cadenas($_POST['usuario_clave_2']);

#   verificando Datos Obligatorios  #

if ($nombre == '' || $apellido == '' || $usuario == '' || $clave1 == '' || $clave2 == '') {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
        ';
    exit();
}

#   verificar integridad Datos  #
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El NOMBRE no coincide con el formato solicitado
    </div>
    ';
    exit();
}
#apellido#
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El APELLIDO no coincide con el formato solicitado
    </div>
    ';
    exit();
}

#USUARIO#
if (verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El APELLIDO no coincide con el formato solicitado
    </div>
    ';
    exit();
}
#clave#
if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave2)) {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Las CLAVES no coincide con el formato solicitado
    </div>
    ';
    exit();
}

#   Verificando Email   #
if ($email != '') {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $check_email = conexion();
        $check_email = $check_email->query("SELECT usuario_email FROM   
            usuarios WHERE usuario_email='$email' ");
        if ($check_email->rowCount() > 0) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El EMAIL ingresado ya se encuentra registrado, ingrese otro
                </div>
                ';
            exit();
        }
        $check_email = null;
    } else {
        echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El EMAIL ingresado no es valio
                </div>
                ';
        exit();
    }
}

#   Verificando Usuario   #


$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT usuario_usuario FROM   
            usuarios WHERE usuario_usuario='$usuario' ");
if ($check_usuario->rowCount() > 0) {
    echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El USUARIO ingresado ya se encuentra en uso, por favor ingrese otro
                </div>
                ';
    exit();
}
$check_email = null;

#   Verificar clave   #
if ($clave1 != $clave2) {
    echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las Claves ingresadas no coinciden
            </div>
            ';
    exit();
} else {
    $clave = password_hash($clave1, PASSWORD_BCRYPT, ["cost" => 10]);
}

#       guardando datos    #
$guardar_usuario = conexion();
$guardar_usuario = $guardar_usuario->prepare("INSERT INTO usuarios(usuario_nombre,usuario_apellido,usuario_usuario,usuario_clave,usuario_email)
         VALUES(:nombre,:apellido,:usuario,:clave,:email)");

$marcadores = [
    ":nombre" => $nombre,
    ":apellido" => $apellido,
    ":usuario" => $usuario,
    ":clave"    => $clave,
    ":email" => $email
];

$guardar_usuario->execute($marcadores);

if ($guardar_usuario->rowCount() == 1) {
    echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO REGISTRADO!</strong><br>
                Usuario registrado con exito
            </div>
            ';
} else {
    echo '
    <div class="notification is-danger is-light">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No se pudo regristrar el usuario, intente nuevamente
    </div>
    ';
}
$guardar_usuario = null;
