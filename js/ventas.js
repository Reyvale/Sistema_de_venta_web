document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form-agregar-producto");
    const tablaCarrito = document.getElementById("contenido-carrito");
    const totalElemento = document.getElementById("total");
    const finalizarBtn = document.getElementById("finalizar-venta");

    let carrito = [];

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const selectProducto = document.getElementById("producto");
        const id = selectProducto.value;
        const nombre = selectProducto.options[selectProducto.selectedIndex].text;
        const precio = parseFloat(selectProducto.options[selectProducto.selectedIndex].dataset.precio);
        const cantidad = parseInt(document.getElementById("cantidad").value);

        if (!id || cantidad <= 0) {
            alert("Seleccione un producto y cantidad válida.");
            return;
        }

        // Verificar si ya está en el carrito
        const existente = carrito.find(p => p.id === id);
        if (existente) {
            existente.cantidad += cantidad;
            existente.subtotal = existente.precio * existente.cantidad;
        } else {
            carrito.push({
                id,
                nombre,
                precio,
                cantidad,
                subtotal: precio * cantidad
            });
        }

        actualizarCarrito();
        form.reset();
    });

    function actualizarCarrito() {
        tablaCarrito.innerHTML = "";
        let total = 0;

        carrito.forEach((producto, index) => {
            total += producto.subtotal;

            const fila = `
                <tr>
                    <td>${producto.nombre}</td>
                    <td>${producto.cantidad}</td>
                    <td>$${producto.precio.toFixed(2)}</td>
                    <td>$${producto.subtotal.toFixed(2)}</td>
                    <td><button onclick="eliminarProducto(${index})">❌</button></td>
                </tr>
            `;
            tablaCarrito.innerHTML += fila;
        });

        totalElemento.textContent = total.toFixed(2);
    }

    window.eliminarProducto = function (index) {
        carrito.splice(index, 1);
        actualizarCarrito();
    };

    finalizarBtn.addEventListener("click", function () {
        if (carrito.length === 0) {
            alert("No hay productos en el carrito.");
            return;
        }

        // Enviar datos al servidor (siguiente paso)
        fetch("../ventas/guardar_venta.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(carrito)
        })
        .then(res => res.json())
      .then(data => {
    if (data.success) {
        alert("✅ Venta guardada correctamente.");
        carrito = [];
        actualizarCarrito();
        window.location.href = `../ventas/ticket.php?id=${data.id_venta}`;
    } else {
        alert("❌ Error al guardar la venta.");
    }
});
   
});
