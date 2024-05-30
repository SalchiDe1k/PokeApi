<?php
include 'database.php';

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $name = $_POST['name'];
    $image_url = $_POST['image_url'];
    $type_id = $_POST['type_id'];

    // Insertar el nuevo Pokémon en la tabla `pokemons`
    $sql = "INSERT INTO pokemons (name, image_url) VALUES ('$name', '$image_url')";
    if ($conn->query($sql) === TRUE) {
        // Obtener el ID del nuevo Pokémon
        $pokemon_id = $conn->insert_id;

        // Insertar la asociación entre el Pokémon y el tipo en la tabla `pokemon_types`
        $sql = "INSERT INTO pokemon_types (pokemon_id, type_id) VALUES ($pokemon_id, $type_id)";
        if ($conn->query($sql) === TRUE) {
            echo "Pokémon creado exitosamente";
        } else {
            echo "Error al asociar el tipo al Pokémon: " . $conn->error;
        }
    } else {
        echo "Error al crear el Pokémon: " . $conn->error;
    }
}

$conn->close();
?>
