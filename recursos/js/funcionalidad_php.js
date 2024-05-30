document.addEventListener('DOMContentLoaded', () => {
    const pokemonGallery = document.getElementById('pokemon-gallery');
    const searchInput = document.getElementById('search');
    const filterMoveInput = document.getElementById('filter-move');
    const filterTypeInput = document.getElementById('filter-type');
    const pokemonForm = document.getElementById('pokemonForm');
    const pokemonFormModal = new bootstrap.Modal(document.getElementById('pokemonFormModal'), {});
    let pokemonList = [];
    let editingPokemon = null;

    // Función para cargar los pokémon desde la API
    function loadPokemons() {
        fetch('api.php')
            .then(response => response.json())
            .then(data => {
                pokemonList = data;
                displayPokemon(pokemonList);
            })
            .catch(error => console.error('Error al cargar los pokémon:', error));
    }

    // Función para mostrar los pokémon en la galería
    function displayPokemon(pokemons) {
        pokemonGallery.innerHTML = '';
        pokemons.forEach(pokemon => {
            const pokemonCard = document.createElement('div');
            pokemonCard.className = 'col-md-4 pokemon-card';
            pokemonCard.innerHTML = `
                <div class="card">
                    <img src="${pokemon.image_url}" class="card-img-top pokemon-image" alt="${pokemon.name}">
                    <div class="card-body">
                        <h5 class="card-title">${pokemon.name}</h5>
                        <p class="card-text">#${pokemon.id}</p>
                        <a href="#" class="btn btn-primary" onclick="showPokemonDetails(${pokemon.id})">Ver más</a>
                        <button class="btn btn-secondary" onclick="openEditPokemonForm(${pokemon.id})">Editar</button>
                        <button class="btn btn-danger" onclick="confirmDeletePokemon(${pokemon.id})">Eliminar</button>
                    </div>
                </div>
            `;
            pokemonGallery.appendChild(pokemonCard);
        });
    }

    // Función para buscar y filtrar los pokémon
    function filterAndDisplayPokemon() {
        const searchValue = searchInput.value.trim().toLowerCase();
        const moveValue = filterMoveInput.value.trim().toLowerCase();
        const typeValue = filterTypeInput.value.trim().toLowerCase();

        const filteredPokemons = pokemonList.filter(pokemon => {
            const matchesName = pokemon.name.toLowerCase().includes(searchValue);
            const matchesMove = moveValue ? pokemon.moves.some(move => move.move.name.toLowerCase().includes(moveValue)) : true;
            const matchesType = typeValue ? pokemon.types.some(type => type.type.name.toLowerCase().includes(typeValue)) : true;
            return matchesName && matchesMove && matchesType;
        });

        displayPokemon(filteredPokemons);
    }

    // Cargar los pokémon al cargar la página
    loadPokemons();

    // Escuchar los cambios en los campos de búsqueda y filtrado
    searchInput.addEventListener('input', filterAndDisplayPokemon);
    filterMoveInput.addEventListener('input', filterAndDisplayPokemon);
    filterTypeInput.addEventListener('input', filterAndDisplayPokemon);

    // Mostrar los detalles de un pokémon
    window.showPokemonDetails = (id) => {
        const pokemon = pokemonList.find(p => p.id === id);
        // Aquí puedes implementar la lógica para mostrar los detalles del pokémon en la interfaz
        console.log(pokemon);
    };

    // Abrir el formulario para editar un pokémon
    window.openEditPokemonForm = (id) => {
        editingPokemon = pokemonList.find(p => p.id === id);
        // Aquí puedes implementar la lógica para abrir el formulario de edición y cargar los datos del pokémon
        console.log('Editar Pokémon:', editingPokemon);
    };

    // Confirmar y eliminar un pokémon
    window.confirmDeletePokemon = (id) => {
        const confirmed = confirm('¿Estás seguro de que deseas eliminar este Pokémon?');
        if (confirmed) {
            deletePokemon(id);
        }
    };

    // Eliminar un pokémon
    function deletePokemon(id) {
        // Aquí debes implementar la lógica para eliminar el pokémon de la base de datos y recargar la lista de pokémon
        console.log('Eliminar Pokémon con ID:', id);
    }

    // Abre el formulario para agregar un nuevo pokémon
    window.openAddPokemonForm = () => {
        editingPokemon = null;
        // Aquí puedes implementar la lógica para abrir el formulario de añadir un nuevo pokémon
        console.log('Agregar Nuevo Pokémon');
    };

    // Submit del formulario de pokémon
    pokemonForm.addEventListener('submit', (event) => {
        event.preventDefault();
        // Aquí debes implementar la lógica para enviar los datos del formulario al servidor y actualizar la lista de pokémon
        console.log('Enviar Formulario de Pokémon');
    });
});