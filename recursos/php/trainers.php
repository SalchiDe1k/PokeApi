<?php
header('Content-Type: application/json');
include 'database.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM trainers WHERE id = $id");
            $trainer = $result->fetch_assoc();
            $result_pokemons = $conn->query("SELECT p.* FROM pokemons p JOIN trainer_pokemons tp ON p.id = tp.pokemon_id WHERE tp.trainer_id = $id");
            $pokemons = [];
            while ($row = $result_pokemons->fetch_assoc()) {
                $pokemons[] = $row;
            }
            $trainer['pokemons'] = $pokemons;
            echo json_encode($trainer);
        } else {
            $result = $conn->query("SELECT * FROM trainers");
            $trainers = [];
            while ($row = $result->fetch_assoc()) {
                $trainers[] = $row;
            }
            echo json_encode($trainers);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'];
        $pokemons = $data['pokemons'];

        $conn->query("INSERT INTO trainers (name) VALUES ('$name')");
        $trainer_id = $conn->insert_id;
        foreach ($pokemons as $pokemon) {
            $pokemon_id = intval($pokemon['id']);
            $conn->query("INSERT INTO trainer_pokemons (trainer_id, pokemon_id) VALUES ($trainer_id, $pokemon_id)");
        }
        echo json_encode(["status" => "success"]);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = intval($data['id']);
        $name = $data['name'];
        $pokemons = $data['pokemons'];

        $conn->query("UPDATE trainers SET name = '$name' WHERE id = $id");
        $conn->query("DELETE FROM trainer_pokemons WHERE trainer_id = $id");
        foreach ($pokemons as $pokemon) {
            $pokemon_id = intval($pokemon['id']);
            $conn->query("INSERT INTO trainer_pokemons (trainer_id, pokemon_id) VALUES ($id, $pokemon_id)");
        }
        echo json_encode(["status" => "success"]);
        break;
    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $conn->query("DELETE FROM trainers WHERE id = $id");
            $conn->query("DELETE FROM trainer_pokemons WHERE trainer_id = $id");
            echo json_encode(["status" => "success"]);
        }
        break;
}
$conn->close();
?>
