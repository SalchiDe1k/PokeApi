<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'usuario', 'contraseña', 'pokemon_db');

// Consulta SQL para recuperar los tipos de Pokémon
$sql = "SELECT * FROM types";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si hay resultados y mostrarlos en el formulario
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
} else {
    echo "<option value=''>No se encontraron tipos de Pokémon</option>";
}

// Cerrar la conexión
$conn->close();
?>
