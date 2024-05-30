<?php
header('Content-Type: application/json');
include 'database.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM pokemons WHERE id = $id");
            $pokemon = $result->fetch_assoc();
            echo json_encode($pokemon);
        } else {
            $result = $conn->query("SELECT * FROM pokemons");
            $pokemons = [];
            while ($row = $result->fetch_assoc()) {
                $pokemons[] = $row;
            }
            echo json_encode($pokemons);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'];
        $image_url = $data['image_url'];
        $types = $data['types'];
        $moves = $data['moves'];

        $conn->query("INSERT INTO pokemons (name, image_url) VALUES ('$name', '$image_url')");
        $pokemon_id = $conn->insert_id;
        foreach ($types as $type) {
            $type_id = intval($type['id']);
            $conn->query("INSERT INTO pokemon_types (pokemon_id, type_id) VALUES ($pokemon_id, $type_id)");
        }
        foreach ($moves as $move) {
            $move_id = intval($move['id']);
            $conn->query("INSERT INTO pokemon_moves (pokemon_id, move_id) VALUES ($pokemon_id, $move_id)");
        }
        echo json_encode(["status" => "success"]);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = intval($data['id']);
        $name = $data['name'];
        $image_url = $data['image_url'];
        $types = $data['types'];
        $moves = $data['moves'];

        $conn->query("UPDATE pokemons SET name = '$name', image_url = '$image_url' WHERE id = $id");
        $conn->query("DELETE FROM pokemon_types WHERE pokemon_id = $id");
        $conn->query("DELETE FROM pokemon_moves WHERE pokemon_id = $id");
        foreach ($types as $type) {
            $type_id = intval($type['id']);
            $conn->query("INSERT INTO pokemon_types (pokemon_id, type_id) VALUES ($id, $type_id)");
        }
        foreach ($moves as $move) {
            $move_id = intval($move['id']);
            $conn->query("INSERT INTO pokemon_moves (pokemon_id, move_id) VALUES ($id, $move_id)");
        }
        echo json_encode(["status" => "success"]);
        break;
    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $conn->query("DELETE FROM pokemons WHERE id = $id");
            $conn->query("DELETE FROM pokemon_types WHERE pokemon_id = $id");
            $conn->query("DELETE FROM pokemon_moves WHERE pokemon_id = $id");
            echo json_encode(["status" => "success"]);
        }
        break;
}
$conn->close();
?>
