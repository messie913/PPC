<?php

//require '../../_Bend/_sub_forms/conn_DB.php';

$produitsParPage = 9;
$pageActuelle = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($pageActuelle - 1) * $produitsParPage;

// Récupérer les produits pour la page actuelle
$sql = "SELECT * FROM produits ORDER BY id_produit DESC LIMIT ? OFFSET ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $produitsParPage, $offset);
$stmt->execute();
$res = $stmt->get_result();
$produits = $res->fetch_all(MYSQLI_NUM); // ou MYSQLI_ASSOC si tu préfères

// Récupérer le total pour générer la pagination
$totalSql = "SELECT COUNT(*) AS total FROM produits";
$totalRes = $conn->query($totalSql);
$totalRow = $totalRes->fetch_assoc();
$totalProduits = $totalRow['total'];
$nbPages = ceil($totalProduits / $produitsParPage);
?>
