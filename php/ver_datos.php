<?php
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Ver Datos Computadoras</title>
<style>
table {
  border-collapse: collapse;
  width: 100%;
}
th, td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: left;
}
button {
  margin: 2px;
  padding: 5px 10px;
}

/* Modal styles */
.modal {
  display: none;
  position: fixed; 
  z-index: 100; 
  left: 0; top: 0; width: 100%; height: 100%;
  overflow: auto; background-color: rgba(0,0,0,0.4);
}
.modal-content {
  background-color: #fefefe;
  margin: 10% auto; 
  padding: 20px;
  border: 1px solid #888;
  width: 400px;
  border-radius: 8px;
}
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}
</style>
</head>
<body>
<a href="../index.html">ATRAS</a>
<h2>Listado de Computadoras de la Empresa</h2>
<button class="btnDescargarPDF">Descargar PDF</button>
<table id="tablaComputadoras">
    <thead>
        <tr>
            <th>ID Computadora</th>
            <th>Tipo</th>
            <th>Año Fabricación</th>
            <th>Gerencia</th>
            <th>Último Mantenimiento</th>
            <th>Observaciones</th>
            <th>Próximo Mantenimiento</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM computadorasdelaempresa ORDER BY id_computadora DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
echo "<tr data-id='{$row['id_computadora']}'>
<td>" . htmlspecialchars($row['id_computadora']) . "</td>
    <td>" . htmlspecialchars($row['tipo_computadora']) . "</td>
    <td>" . htmlspecialchars($row['anio_fabricacion']) . "</td>
    <td>" . htmlspecialchars($row['gerencia']) . "</td>
    <td>" . htmlspecialchars($row['ultimo_mantenimiento']) . "</td>
    <td>" . htmlspecialchars($row['observaciones']) . "</td>
    <td>" . htmlspecialchars($row['fecha_proximo_mantenimiento']) . "</td>
    <td>
        <button class='btnEditar'>Editar</button>
        <button class='btnEliminar'>Eliminar</button>
        
    </td>
</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay datos para mostrar</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>

<!-- Modal editar -->
<div id="modalEditar" class="modal">
  <div class="modal-content">
    <span class="close" id="cerrarModal">&times;</span>
    <h3>Editar Computadora</h3>
    <form id="formEditar">
      <input type="hidden" name="id_computadora" id="id_computadora" />

      <label>Tipo de Computadora:</label><br/>
      <select name="tipo_computadora" id="tipo_computadora" required>
        <option value="PC DE ESCRITORIO">PC DE ESCRITORIO</option>
        <option value="NOTEBOOK">NOTEBOOK</option>
      </select><br/><br/>
      
      <label>Año de Fabricación:</label><br/>
      <input type="number" name="anio_fabricacion" id="anio_fabricacion" min="1980" max="2099" required/><br/><br/>
      
      <label>Último Mantenimiento:</label><br/>
      <input type="date" name="ultimo_mantenimiento" id="ultimo_mantenimiento" required/><br/><br/>
      
      <label>Observaciones:</label><br/>
      <textarea name="observaciones" id="observaciones" rows="3"></textarea><br/><br/>
      
      <label>Fecha Próximo Mantenimiento:</label><br/>
      <input type="date" name="fecha_proximo_mantenimiento" id="fecha_proximo_mantenimiento" required/><br/><br/>
      
<label>Gerencia:</label><br/>
<select name="gerencia" id="gerencia" required>
  <option value="Gerencia General">Gerencia General</option>
  <option value="Gerencia Administrativa">Gerencia Administrativa</option>
  <option value="Gerencia Ventas">Gerencia Ventas</option>
  <option value="Gerencia Productos">Gerencia Productos</option>
</select><br/><br/>
        
      </select><br/><br/>
      
      <button type="submit">Guardar Cambios</button>
    </form>
  </div>
</div>


<script>
// Variables modal
const modal = document.getElementById('modalEditar');
const cerrarModal = document.getElementById('cerrarModal');
const formEditar = document.getElementById('formEditar');

// Abrir modal con datos para editar
document.querySelectorAll('.btnEditar').forEach(button => {
    button.addEventListener('click', function(){
        const tr = this.closest('tr');
        const id = tr.getAttribute('data-id');
        const id_computadora = tr.cells[0].innerText;
        const tipo = tr.cells[1].innerText;
        const anio = tr.cells[2].innerText;
        const gerencia = tr.cells[3].innerText;
        const ultimo = tr.cells[4].innerText;
        const obs = tr.cells[5].innerText;
        const prox = tr.cells[6].innerText;

        document.getElementById('id_computadora').value = id;
        document.getElementById('tipo_computadora').value = tipo;
        document.getElementById('anio_fabricacion').value = anio;
        document.getElementById('ultimo_mantenimiento').value = ultimo;
        document.getElementById('observaciones').value = obs;
        document.getElementById('fecha_proximo_mantenimiento').value = prox;
        document.getElementById('gerencia').value = gerencia;   
        modal.style.display = 'block';
    });
});

// Cerrar modal
cerrarModal.onclick = () => modal.style.display = 'none';
window.onclick = e => { if(e.target == modal) modal.style.display = 'none'; };

// Enviar datos editados
formEditar.addEventListener('submit', function(e){
    e.preventDefault();

    const formData = new FormData(this);

    fetch('editar_computadora.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert('Datos actualizados correctamente.');
            // Actualizar fila en la tabla sin recargar
            const id = formData.get('id_computadora');
            const filas = document.querySelectorAll(`#tablaComputadoras tr[data-id="${id}"]`);
            if(filas.length > 0){
                const tr = filas[0];
                tr.cells[0].innerText = formData.get('id_computadora');
                tr.cells[0].innerText = formData.get('tipo_computadora');
                tr.cells[1].innerText = formData.get('anio_fabricacion');
                tr.cells[2].innerText = formData.get('ultimo_mantenimiento');
                tr.cells[3].innerText = formData.get('observaciones');
                tr.cells[4].innerText = formData.get('fecha_proximo_mantenimiento');
                tr.cells[5].innerText = formData.get('gerencia');
            }
            modal.style.display = 'none';
        } else {
            alert('Error al actualizar: ' + data.error);
        }
    })
    .catch(() => alert('Error en la comunicación con el servidor.'));
});

// Eliminar
document.querySelectorAll('.btnEliminar').forEach(button => {
    button.addEventListener('click', function(){
        if(confirm('¿Estás seguro que deseas eliminar este registro?')) {
            const tr = this.closest('tr');
            const id = tr.getAttribute('data-id');

            fetch('eliminar_computadora.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id_computadora=' + encodeURIComponent(id)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    alert('Registro eliminado.');
                    tr.remove();
                } else {
                    alert('Error al eliminar: ' + data.error);
                }
            })
            .catch(() => alert('Error en la comunicación con el servidor.'));
        }
    });
});

document.querySelectorAll('.btnDescargarPDF').forEach(btn => {
    btn.addEventListener('click', () => {
        window.open('generar_pdf.php', '_blank');
    });
});


</script>

</body>
</html>
