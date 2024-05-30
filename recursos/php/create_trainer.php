<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si el nombre del entrenador se ha enviado correctamente
    if (isset($_POST['name'])) {
        // Obtiene el nombre del entrenador desde el formulario
        $name = $_POST['name'];

        // Prepara la consulta SQL para insertar el entrenador en la base de datos
        $stmt = $conn->prepare("INSERT INTO trainers (name) VALUES (?)");

        // Vincula los parámetros y ejecuta la consulta
        $stmt->bind_param("s", $name);
        $stmt->execute();

        // Verifica si la inserción fue exitosa
        if ($stmt->affected_rows > 0) {
            echo "Entrenador creado exitosamente.";
        } else {
            echo "Error al crear el entrenador.";
        }

        // Cierra la consulta y la conexión a la base de datos
        $stmt->close();
        $conn->close();
    } else {
        echo "El nombre del entrenador no se ha especificado.";
    }
}
?>
