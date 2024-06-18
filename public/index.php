<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Productos</title>
    <link href="./public/css/tailwind.css" rel="stylesheet">
    <style>
        .error {
            color: red;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body class="bg-gray-100 p-4">

<?php
session_start();

if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = [];
}

// Funciones de validación
function validar_nombre($nombre) {
    return preg_match('/^[a-zA-Z ]+$/', $nombre);
}

function validar_numero($numero) {
    return is_numeric($numero);
}

// Función para agregar producto al array $_SESSION['productos']
function agregar_producto($nombre, $precio, $cantidad) {
    if (validar_nombre($nombre) && validar_numero($precio) && validar_numero($cantidad)) {
        $_SESSION['productos'][] = [
            'nombre' => $nombre,
            'precio' => $precio,
            'cantidad' => $cantidad
        ];
        return true;
    } else {
        return false;
    }
}

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    
    $agregado = agregar_producto($nombre, $precio, $cantidad);
    if ($agregado) {
        echo "<p class='text-green-600'>Producto agregado correctamente.</p>";
    } else {
        echo "<p class='error'>Por favor, revise los datos ingresados.</p>";
    }
}
?>

<div class="max-w-4xl mx-auto bg-white p-8 my-10 rounded shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Formulario de Productos</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="precio" class="block text-sm font-medium text-gray-700">Precio por Unidad:</label>
            <input type="text" id="precio" name="precio" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div class="mb-4">
            <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad en Inventario:</label>
            <input type="text" id="cantidad" name="cantidad" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">Agregar Producto</button>
        </div>
    </form>
</div>

<div class="max-w-4xl mx-auto bg-white p-8 my-10 rounded shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Lista de Productos</h2>
    <table class="w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Nombre del Producto</th>
                <th class="px-4 py-2">Precio por Unidad</th>
                <th class="px-4 py-2">Cantidad en Inventario</th>
                <th class="px-4 py-2">Valor Total</th>
                <th class="px-4 py-2">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($_SESSION['productos'] as $producto) {
                $nombre = $producto['nombre'];
                $precio = $producto['precio'];
                $cantidad = $producto['cantidad'];
                $valor_total = $precio * $cantidad;
                $estado = ($cantidad > 0) ? 'Stock' : 'Agotado';

                echo "<tr>";
                echo "<td class='border px-4 py-2'>$nombre</td>";
                echo "<td class='border px-4 py-2'>$precio</td>";
                echo "<td class='border px-4 py-2'>$cantidad</td>";
                echo "<td class='border px-4 py-2'>$valor_total</td>";
                echo "<td class='border px-4 py-2'>$estado</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>


