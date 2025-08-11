<?php
session_start();
require '../_Bend/_sub_forms/conn_DB.php';

header('Content-Type: application/json'); // Optionnel mais utile

// Si l'utilisateur n'est pas connecté
if (!isset($_SESSION['userId'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['status' => 'error', 'message' => 'not_logged_in']);
    exit();
}

// Si la requête n'a pas de product_id
if (!isset($_POST['product_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'missing_product_id']);
    exit();
}

$userId = $_SESSION['userId']; 
$productId = $_POST['product_id'];

// Vérifie si le favori existe déjà
$sql = "SELECT * FROM favorites WHERE user_id = ? AND produit_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $userId, $productId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Le produit est déjà un favori : on le retire
    $stmt->close();
    $sql = "DELETE FROM favorites WHERE user_id = ? AND produit_id = ?";
    $delete = $conn->prepare($sql);
    $delete->bind_param("ii", $userId, $productId);
    $delete->execute();
    echo json_encode(['status' => 'removed']);
} else {
    // Le produit n’est pas encore favori : on l’ajoute
    $stmt->close();
    $sql = "INSERT INTO favorites(user_id, produit_id) VALUES (?, ?)";
    $insert = $conn->prepare($sql);
    $insert->bind_param("ii", $userId, $productId);
    $insert->execute();
    echo json_encode(['status' => 'added']);
}