<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Comidas</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <h1>Listado de Comidas</h1>

    <!-- Formulario para agregar comida -->
    <h2>Agregar Comida</h2>
    <form id="comidaForm">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="tipo">Tipo:</label>
        <input type="text" id="tipo" name="tipo" required><br>
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required><br>
        <button type="submit">Agregar Comida</button>
    </form>

    <!-- Tabla de comidas -->
    <table id="tabla_comidas" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            var table = $('#tabla_comidas').DataTable({
                ajax: {
                    url: '/api/comidas',
                    dataSrc: ''
                },
                columns: [
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'tipo' },
                    { data: 'precio' },
                    { data: 'created_at' },
                    { data: 'updated_at' },
                    { 
                        data: null, 
                        render: function(data, type, row) {
                            return `
                                <button class="edit-btn" data-id="${row.id}">Editar</button>
                                <button class="delete-btn" data-id="${row.id}">Eliminar</button>
                            `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                }
            });

            // Función para agregar una comida
            $('#comidaForm').on('submit', function(e) {
                e.preventDefault();

                var formData = {
                    nombre: $('#nombre').val(),
                    tipo: $('#tipo').val(),
                    precio: $('#precio').val()
                };

                $.ajax({
                    url: '/api/comidas',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        table.ajax.reload();  
                        $('#comidaForm')[0].reset();  
                    },
                    error: function(error) {
                        alert('Error al agregar comida');
                    }
                });
            });

            // Función para editar una comida
            $(document).on('click', '.edit-btn', function() {
                var comidaId = $(this).data('id');
                $.ajax({
                    url: '/api/comidas/' + comidaId,
                    method: 'GET',
                    success: function(response) {
                        $('#nombre').val(response.nombre);
                        $('#tipo').val(response.tipo);
                        $('#precio').val(response.precio);
                        $('#comidaForm').off('submit').on('submit', function(e) {
                            e.preventDefault();
                            var updatedData = {
                                nombre: $('#nombre').val(),
                                tipo: $('#tipo').val(),
                                precio: $('#precio').val()
                            };

                            $.ajax({
                                url: '/api/comidas/' + comidaId,
                                method: 'PUT',
                                data: updatedData,
                                success: function() {
                                    table.ajax.reload();
                                    $('#comidaForm')[0].reset();
                                },
                                error: function() {
                                    alert('Error al actualizar comida');
                                }
                            });
                        });
                    }
                });
            });

            // Función para eliminar una comida
            $(document).on('click', '.delete-btn', function() {
                var comidaId = $(this).data('id');
                if (confirm('¿Estás seguro de eliminar esta comida?')) {
                    $.ajax({
                        url: '/api/comidas/' + comidaId,
                        method: 'DELETE',
                        success: function() {
                            table.ajax.reload();  
                        },
                        error: function() {
                            alert('Error al eliminar comida');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
