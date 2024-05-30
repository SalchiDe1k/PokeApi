<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon y Entrenadores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Pokémon y Entrenadores</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <input type="text" id="search" class="form-control mt-2 mb-2" placeholder="Buscar Pokémon">
                    </li>
                    <li class="nav-item">
                        <input type="text" id="filter-move" class="form-control mt-2 mb-2" placeholder="Filtrar por Movimiento">
                    </li>
                    <li class="nav-item">
                        <input type="text" id="filter-type" class="form-control mt-2 mb-2" placeholder="Filtrar por Tipo">
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h3>Pokémon</h3>
                <div id="pokemon-gallery" class="row"></div>
            </div>
            <div class="col-md-6">
                <h3>Entrenadores</h3>
                <div id="trainer-list"></div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editFormModal = new bootstrap.Modal(document.getElementById('editFormModal'), {});
        const editForm = document.getElementById('editForm');

        // Función para abrir el formulario de edición
        window.openEditFormModal = (id) => {
            if (id) {
                // Si se pasa un ID, se está editando un Pokémon/Entrenador existente
                fetch(`api.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        // Llenar el formulario con los datos del Pokémon/Entrenador
                        document.getElementById('entity-id').value = data.id;
                        document.getElementById('entity-name').value = data.name;
                        document.getElementById('entity-image').value = data.image_url;
                        // Puedes cargar los tipos y movimientos dinámicamente aquí
                        // Por ejemplo:
                        // data.types.forEach(type => {
                        //     const option = document.createElement('option');
                        //     option.value = type.id;
                        //     option.textContent = type.name;
                        //     document.getElementById('entity-types').appendChild(option);
                        // });
                        editFormModal.show();
                    })
                    .catch(error => console.error('Error al cargar los datos del Pokémon/Entrenador:', error));
            } else {
                // Si no se pasa un ID, se está agregando un nuevo Pokémon/Entrenador
                // Limpiar el formulario
                editForm.reset();
                editFormModal.show();
            }
        };

        // Manejo del envío del formulario
        editForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(editForm);
            const id = formData.get('entity-id');
            const name = formData.get('entity-name');
            const image_url = formData.get('entity-image');
            // Puedes obtener los tipos y movimientos seleccionados aquí
            // Por ejemplo:
            // const types = formData.getAll('entity-types');
            // const moves = formData.getAll('entity-moves');
            const data = {
                name: name,
                image_url: image_url,
                // types: types,
                // moves: moves
            };
            const method = id ? 'PUT' : 'POST';
            let url = 'api.php';
            if (id) {
                url += `?id=${id}`;
            }
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                // Aquí puedes manejar la respuesta del servidor
                console.log(data);
                // Por ejemplo, cerrar el modal después de guardar los datos
                editFormModal.hide();
            })
            .catch(error => console.error('Error al guardar los datos:', error));
        });
    });
</script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
