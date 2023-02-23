<?php
# Este es el simple encabezado HTML
// include_once "encabezado.php";
# Incluimos la conexión
include_once "Conexion.php";

# Cuántos productos mostrar por página
$productosPorPagina = 5;
// Por defecto es la página 1; pero si está presente en la URL, tomamos esa
$pagina = 1;
if (isset($_GET["pagina"])) {
    $pagina = $_GET["pagina"];
}
# El límite es el número de productos por página
$limit = $productosPorPagina;
# El offset es saltar X productos que viene dado por multiplicar la página - 1 * los productos por página
$offset = ($pagina - 1) * $productosPorPagina;
# Necesitamos el conteo para saber cuántas páginas vamos a mostrar
$sentencia = $c->query("SELECT count(*) AS conteo FROM t_rgu_usuario");
$conteo = $sentencia->fetchObject()->conteo;
# Para obtener las páginas dividimos el conteo entre los productos por página, y redondeamos hacia arriba
$paginas = ceil($conteo / $productosPorPagina);

# Ahora obtenemos los productos usando ya el OFFSET y el LIMIT
$sentencia = $c->prepare("SELECT * FROM t_rgu_usuario LIMIT ? OFFSET ?");
$sentencia->execute([$limit, $offset]);
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
# Y más abajo los dibujamos...
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Paginación con PHP y MySQL - By Parzibyte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="./css/2.css">
    <link rel="stylesheet" href="./css/estilo.css"> -->
</head>
<body>
<!-- <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="//parzibyte.me/blog">Paginación con PHP y MySQL - By Parzibyte</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="./index.php">Productos</a></li>
            </ul>
        </div>
    </div>
</nav> -->
<div class="container">
    <div class="row">
      
    <div class="col-xs-12">
        <h1>Usuarios</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Genero</th>
                <th>direccion</th>
                <th>Correo</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $producto) { ?>
                <tr>
                    <td><?php echo $producto->RGU_ID ?></td>
                    <td><?php echo $producto->RGU_NOMBRES ?></td>
                    <td><?php echo $producto->RGU_APELLIDOS ?></td>
                    <td><?php echo $producto->RGU_GENERO ?></td>
                    <td><?php echo $producto->RGU_DIRECCION ?></td>
                    <td><?php echo $producto->RGU_CORREO ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        
        <nav aria-label="Page navigation example">
            <div class="row">
                <div class="col-xs-12 col-sm-6">

                    <p>Mostrando <?php echo $productosPorPagina ?> de <?php echo $conteo ?> productos disponibles</p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <p>Página <?php echo $pagina ?> de <?php echo $paginas ?> </p>
                </div>
            </div>


            <ul class="pagination justify-content-end">
                <!-- Si la página actual es mayor a uno, mostramos el botón para ir una página atrás -->
                <?php if ($pagina > 1) { ?>
                    <li class="page-item disabled">
                        <a href="./index.php?pagina=<?php echo $pagina - 1 ?>" class="page-link" tabindex="-1" aria-disabled="true">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php } ?>

                <!-- Mostramos enlaces para ir a todas las páginas. Es un simple ciclo for-->
                <?php for ($x = 1; $x <= $paginas; $x++) { ?>
                    <li class="<?php if ($x == $pagina) echo "active" ?>">
                        <a href="./index.php?pagina=<?php echo $x ?>" class="page-link">
                            <?php echo $x ?></a>
                    </li>
                <?php } ?>
                <!-- Si la página actual es menor al total de páginas, mostramos un botón para ir una página adelante -->
                <?php if ($pagina < $paginas) { ?>
                    <li>
                        <a href="./index.php?pagina=<?php echo $pagina + 1 ?>" class="page-link" >
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

      
    </div>
