<?php
#   Funcion para la conexion a la bd    #
function conexion()
{
    $host = 'localhost:3306';
    $db = 'inventario';
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host; dbname=$db; charset=$charset";
    $username = 'root';
    $password = '';
    $pdo = new PDO($dsn, $username,  $password);

    return $pdo;
}

#   Verificar Datos    #

function verificar_datos($filtro, $cadena)
{
    if (preg_match("/^" . $filtro . "$/", $cadena)) {
        return false;
    } else {
        return true;
    }
}
#   limpiar cadena de textos    #
function limpiar_cadenas($cadena)
{
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    $cadena = str_ireplace("<script>", "", $cadena);
    $cadena = str_ireplace("</script>", "", $cadena);
    $cadena = str_ireplace("<script src>", "", $cadena);
    $cadena = str_ireplace("<script type=>", "", $cadena);
    $cadena = str_ireplace("SELECT * FROM>", "", $cadena);
    $cadena = str_ireplace("DELETE FROM", "", $cadena);
    $cadena = str_ireplace("INSERT INTO", "", $cadena);
    $cadena = str_ireplace("DROP TABLE", "", $cadena);
    $cadena = str_ireplace("DROP DATABASE", "", $cadena);
    $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
    $cadena = str_ireplace("SHOW TABLES", "", $cadena);
    $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
    $cadena = str_ireplace("<?php", "", $cadena);
    $cadena = str_ireplace("?>", "", $cadena);
    $cadena = str_ireplace("--", "", $cadena);
    $cadena = str_ireplace("^", "", $cadena);
    $cadena = str_ireplace("<", "", $cadena);
    $cadena = str_ireplace("[", "", $cadena);
    $cadena = str_ireplace("]", "", $cadena);
    $cadena = str_ireplace("==", "", $cadena);
    $cadena = str_ireplace(";", "", $cadena);
    $cadena = str_ireplace("::", "", $cadena);
    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);
    return $cadena;
}
#   funcion renombrar fotos #  
function renombrar_fotos($nombre)
{
    $nombre = str_ireplace(" ", "_", $nombre);
    $nombre = str_ireplace("/", "_", $nombre);
    $nombre = str_ireplace("#", "_", $nombre);
    $nombre = str_ireplace("-", "_", $nombre);
    $nombre = str_ireplace("$", "_", $nombre);
    $nombre = str_ireplace(".", "_", $nombre);
    $nombre = str_ireplace(",", "_", $nombre);
    $nombre = $nombre . "_" . rand(0, 100);
    return $nombre;
}

#   funcion paginadores  de tablas   #

function paginador_tablas($pagina, $nPaginas, $url, $botones)
{
    $tabla = '<nav class="pagination is-centered is-rounded"
     role="navigation" aria-label="pagination">';

    #   boton Anterior #
    if ($pagina <= 1) {
        $tabla .= '
        <a class="pagination-previous is-disabled" disabled >Anterior</a>
        <ul class="pagination-list">
        ';
    } else {
        $tabla .= '
        <a href="' . $url . ($pagina - 1) . '" 
        class="pagination-previous">Anterior</a>
        <ul class="pagination-list">
            <li><a href="' . $url . '1" 
            class="pagination-link">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
    
    ';
    }

    #   Botones centrales   #

    $ci = 0;

    for ($i = $pagina; $i <= $nPaginas; $i++) {
        if ($ci >= $botones) {
            break;
        }
        if ($pagina == $i) {
            $tabla .= '<li><a href="' . $url . $i . '" class="pagination-link is-current">' . $i . '</a></li>';
        } else {
            $tabla .= '<li><a href="' . $url . $i . '" class="pagination-link">' . $i . '</a></li>';
        }

        $ci++;
    }



    #   boton siguiente    #

    if ($pagina == $nPaginas) {
        $tabla .= '
        </ul>
        <a class="pagination-next is-disabled" disabled >Siguiente</a>
        ';
    } else {
        $tabla .= ' 
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a href="' . $url . $nPaginas . '" 
            class="pagination-link">' . $nPaginas . '</a></li>
        </ul>
        <a href="' . $url . ($pagina + 1) . '" 
        class="pagination-next">Siguiente</a>
        ';
    }




    $tabla .= '</nav>';
    return $tabla;
}
