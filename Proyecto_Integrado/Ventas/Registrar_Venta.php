<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style.css">
    <link rel="stylesheet" href="../jquery/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Papelería UNES</title>
</head>
<body>
    <header>
        <a href="../Home.php"><img src="../Imagenes/Logo-removebg-preview.png"></a>
        <div class="User">
            <!--QUITAR EL :8080 -->
            <form class="User_log" action="http://localhost:/Proyecto_Integrado/logout.php" method="post">
            <button class="Btn">
                <div class="sign"><svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path><svg>
                </div>
            <div class="text">Cerrar sesión</div>
            </button>
        </form>
          <!-- Botón de ayuda -->
        <form class="User_help" action="../Ayuda/ayuda.php" method="get">
            <button class="faq-button">
                    <svg viewBox="0 0 320 512">
                        <path d="M80 160c0-35.3 28.7-64 64-64h32c35.3 0 64 28.7 64 64v3.6c0 21.8-11.1 42.1-29.4 53.8l-42.2 27.1c-25.2 16.2-40.4 44.1-40.4 74V320c0 17.7 14.3 32 32 32s32-14.3 32-32v-1.4c0-8.2 4.2-15.8 11-20.2l42.2-27.1c36.6-23.6 58.8-64.1 58.8-107.7V160c0-70.7-57.3-128-128-128H144C73.3 32 16 89.3 16 160c0 17.7 14.3 32 32 32s32-14.3 32-32zm80 320a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"></path>
                    </svg>
            <span class="tooltip">Ayuda</span>
        </button>
        </form>
            <img class="User_icon" src="../Imagenes/colegio.png" alt="User Icon">
        </div>
        <h1>Venta</h1>
    </header>
    <?php include "../Menu.php"; ?>
    <br>

    <?php
require_once "../conexionesBD.php";
$conexion = conectarBD();

// Recuperar el ID del usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'];

// Obtener el rol del usuario desde la base de datos
$query = "SELECT tipo_usuario AS rol FROM usuarios WHERE id_usuario = $id_usuario";
$result = $conexion->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $rol = $row['rol'];
} else {
    echo "Error al obtener el rol del usuario.";
    session_destroy(); // Cerrar sesión en caso de error crítico
    //Aqui solo borra el 8080 para que furule
    header("Location: http://localhost:8080/Proyecto_Integrado/index.php");
    exit();
}
mysqli_close($conexion);
?>

    <div class="Fondo_Agregar">
        <div class="buscador2">
            <i class="fas fa-search"></i>
            <input type="text" class="search_bar" id="buscar" name="tipoProducto" placeholder="Añade Productos">
        </div>
    </div>
<form id="formularioPago" action="guardar_venta.php" method="POST" onsubmit="return validarVenta()">
    <table>
        <thead>
            <tr>
                <th class="PCI_Venta">Producto</th>
                <th class="PCI_Venta">Cantidad</th>
                <th class="PCI_Venta">Precio</th>
                <th class="PCI_Venta">Importe</th>
            </tr>
        </thead>
        <tbody id="contenedor_productos">
            <!-- Dynamic rows will be added here -->
        </tbody>
    </table>

    <div class="linea">_____________________________________________________________________________________________________________</div><br>
    <div class="Importe">
        <label><b>Importe Total:</b></label> <span id="importe_total">0</span>
    </div>
        <button class="Pagar">Pagar</button>
        <input type="hidden" value="0" name="numProductos" name="numProductos" id="numProductos">
    </form><br>
    <!--QUITAR 8080-->
    <a href="http://localhost:8080/Proyecto_Integrado/Vales/Registrar_Vale.php">
        <button class="Pagar">Vale</button><br><br>
    </a>
        <input type="hidden" id="idProducto" name="idProducto"disabled>
        <input type="hidden" id="nombre" name="nombre" disabled>
        <input type="hidden" id="precio" name="precio" disabled>

    <script src="../jquery/external/jquery/jquery.js"></script>
    <script src="../jquery/jquery-ui.js"></script>

   <script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("formularioPago").addEventListener("submit", function(event) {
        let numProductos = document.getElementById("numProductos").value; // Obtener el número de productos

        if (numProductos == 0) {
            event.preventDefault(); // Evita que el formulario se envíe
            return; // Sale de la función sin mostrar la confirmación
        }

        let confirmacion = confirm("¿Está seguro de que desea realizar el pago?");
        if (!confirmacion) {
            event.preventDefault(); // Evita que el formulario se envíe
            alert("Pago cancelado.");
        }
    });
});



    function validarVenta() {
    let numProductos = document.getElementById("numProductos").value; // Obtener el número de productos
    if (numProductos == 0) {
        alert("Por favor, añade al menos un producto antes de registrar la venta.");
        return false; // Evita el envío del formulario
    }

    // Validar cantidades
    for (let i = 1; i <= numProductos; i++) {
        let cantidad = document.getElementById("cantidad_" + i).value;
        if (cantidad <= 0 || isNaN(cantidad)) {
            alert("La cantidad de cada producto debe ser mayor a 0.");
            return false; // Evita el envío del formulario
        }
    }

    return true; // Permite el envío del formulario si todo es válido
}

    
    $( "#buscar" ).autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "ObtenerProductosV.php",  
            dataType: "json",
            data: { nombre: request.term },
            success: function (data) {
                response(data.map(producto => ({
                    label: producto.nombre,  // Lo que se mostrará en la lista de sugerencias
                    value: producto.nombre,  // Lo que se pondrá en el input al seleccionar
                    id: producto.id_producto,
                    precio: producto.precio
                })));
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
            }
        });
    },
    select: function (e, ui) {
        // Asigna la información del producto a los campos correspondientes
        document.getElementById("idProducto").value = ui.item.id;  
        document.getElementById("nombre").value = ui.item.value;   
        document.getElementById("precio").value = ui.item.precio.replace("$ ", "");  
        
        // Limpia el campo de búsqueda
        document.getElementById("buscar").value = "";

        // Agrega el producto a la tabla
        agregarProducto([ui.item.id, ui.item.value, ui.item.precio]);
    }
});

$( "#buscar" ).on("autocompleteclose", function(event, ui) {
    document.getElementById("buscar").value = "";
});


function agregarProducto(arrayInfoProducto) {
    let divContenedorProductos = document.getElementById("contenedor_productos");
    let numProductos = document.getElementById("numProductos");
    let indiceProducto = parseInt(numProductos.value) + 1;
    numProductos.value = indiceProducto;

    // Usamos la información del producto (arrayInfoProducto)
    let htmlProducto = '<tr id="detalle_producto_' + indiceProducto + '">';
    htmlProducto += '<td>' + arrayInfoProducto[1] + '</td>'; // Nombre del producto
    htmlProducto += '<td><input class="input_V" type="number" id="cantidad_' + indiceProducto + '" name="cantidad_' + indiceProducto + '" placeholder="Cantidad" value="1" min="1" oninput="validarCantidad(this)" onchange="calcularImporte(' + indiceProducto + ')"></td>'; // Cantidad

    htmlProducto += '<td id="precio_' + indiceProducto + '">' + arrayInfoProducto[2] + '</td>'; // Precio (sin editar)
    htmlProducto += '<td> $ <input class="input_V" id="importe_' + indiceProducto + '" value="0" disabled> </td>'; // Importe
    htmlProducto += '<td><input type="hidden" name="idProducto_' + indiceProducto + '" value="' + arrayInfoProducto[0] + '">' + // ID del producto oculto
        '<img class="icono1" onclick="deleteRow(' + indiceProducto + ')" src="../Imagenes/eliminar.png"></td>'; // Icono eliminar
    htmlProducto += '</tr>';

    divContenedorProductos.insertAdjacentHTML('beforeend', htmlProducto);
    calcularImporte(indiceProducto); // Recalcular el importe al agregar el producto
    calcularTotal(); // Recalcular el total
}


function deleteRow(indice) {
    // Elimina la fila correspondiente
    let row = document.getElementById('detalle_producto_' + indice);
    row.remove();

    // Recalcula el total de productos
    actualizarNumProductos();
    calcularTotal(); // Recalcula el total después de eliminar una fila
}

function actualizarNumProductos() {
    const rows = document.querySelectorAll('#contenedor_productos tr'); // Seleccionar todas las filas
    let numProductos = 0;

    // Recorre todas las filas para reasignar IDs y recalcular el número de productos
    rows.forEach((row, index) => {
        const nuevoIndice = index + 1; // Índice basado en 1

        // Actualiza el ID del producto
        row.id = 'detalle_producto_' + nuevoIndice;

        // Actualiza el nombre e ID de los campos dinámicos dentro de la fila
        const cantidadInput = row.querySelector(`input[id^="cantidad_"]`);
        const importeInput = row.querySelector(`input[id^="importe_"]`);
        const idProductoInput = row.querySelector(`input[name^="idProducto_"]`);
        const eliminarIcono = row.querySelector('img.icono1');

        if (cantidadInput) {
            cantidadInput.id = 'cantidad_' + nuevoIndice;
            cantidadInput.setAttribute('name', 'cantidad_' + nuevoIndice);
            cantidadInput.setAttribute('onchange', `calcularImporte(${nuevoIndice})`);
        }

        if (importeInput) {
            importeInput.id = 'importe_' + nuevoIndice;
        }

        if (idProductoInput) {
            idProductoInput.setAttribute('name', 'idProducto_' + nuevoIndice);
        }

        if (eliminarIcono) {
            eliminarIcono.setAttribute('onclick', `deleteRow(${nuevoIndice})`);
        }

        // Incrementa el contador de productos
        numProductos++;
    });

    // Actualiza el valor en el campo oculto
    document.getElementById("numProductos").value = numProductos;
}


    function calcularImporte(indice) {
    let cantidad = document.getElementById("cantidad_" + indice).value;
    let precioElemento = document.getElementById("precio_" + indice);

    // Verifica si el precio está en textContent o en un input
    let precio = precioElemento.tagName === "INPUT" ? precioElemento.value : precioElemento.textContent;

    // Elimina el símbolo "$" si está presente
    precio = precio.replace("$", "").trim();

    precio = parseFloat(precio); // Convertir a número

    if (isNaN(precio) || isNaN(cantidad)) {
        console.error("Error: Precio o cantidad inválidos.");
        return;
    }

    let importe = cantidad * precio;

    // Actualiza el importe en la tabla
    document.getElementById("importe_" + indice).value = importe.toFixed(2);

    calcularTotal(); // Recalcular el total después de cambiar el importe
}

    function calcularTotal() {
    let total = 0;
    let rows = document.querySelectorAll('#contenedor_productos tr');
    
    rows.forEach(row => {
        let inputImporte = row.querySelector('input[id^="importe_"]');
        if (inputImporte) {
            let importe = parseFloat(inputImporte.value) || 0;
            total += importe;
        }
    });

    document.getElementById('importe_total').textContent = total.toFixed(2);
}

</script>
</body>
</html>

