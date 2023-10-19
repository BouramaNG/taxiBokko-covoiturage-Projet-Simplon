<?php

session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$mysqli = new mysqli("localhost", "root", "", "etaxibokko");

if ($mysqli->connect_error) {
    die("La connexion à la base de données a échoué : " . $mysqli->connect_error);
}

if (!isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    echo '<div class="success-message">Vous vous êtes connecté avec succès. Veuillez choisir votre trajet, ' . $user['prenom'] . ' !</div>';
    echo '<a href="deconnection.php" class="btn btn-danger">Déconnexion</a>';
} else {
    echo '<div class="success-message">Vous vous êtes connecté avec succès. Veuillez choisir votre trajet !</div>';
}

$query = "SELECT * FROM client";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Prénom</th>';
    echo '<th>Nom</th>'; 
    echo '<th>Email</th>';
    echo '<th>Telephone</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['prenom'] . '</td>';
        echo '<td>' . $row['nom'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['telephone'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo 'Aucun utilisateur trouvé dans la base de données.';
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Voir Covoiturage</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
 .container{
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
   
 } 
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    width: 40%;
    background-color: yellow;
    margin-right: 20px;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    background-color: #f5f5f5;
}
.card-link{
    background-color: green;
    color: white;
}
.success-message{
    background-color: green;
    color: white;
    text-align: center;
}

    </style> 
</head>
<body>
<h1>Liste des Covoiturages</h1>

    <div class="container">
       
        
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Trajet de Konowa à Iwa</h5>
                <h6 class="card-subtitle mb-2 text-muted">Lieu de départ: Konowa</h6>
                <h6 class="card-subtitle mb-2 text-muted">Lieu d'arrivée: Iwa</h6>
                <p class="card-text">Temps estimé: 2 heures</p>
                <p class="card-text">Personnes réservées: 3/4</p>
                <button href="#" class="card-link">Réserver</button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Trajet de Kiri à Suna</h5>
                <h6 class="card-subtitle mb-2 text-muted">Lieu de départ: Suna</h6>
                <h6 class="card-subtitle mb-2 text-muted">Lieu d'arrivée: Kiri</h6>
                <p class="card-text">Temps estimé: 2 heures</p>
                <p class="card-text">Personnes réservées: 2/4</p>
                <button href="#" class="card-link">Réserver</button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Trajet de Konowa à Suna</h5>
                <h6 class="card-subtitle mb-2 text-muted">Lieu de départ: Konowa</h6>
                <h6 class="card-subtitle mb-2 text-muted">Lieu d'arrivée: Suna</h6>
                <p class="card-text">Temps estimé: 2 heures</p>
                <p class="card-text">Personnes réservées: 3/4</p>
                <button href="#" class="card-link">Réserver</button>
            </div>
        </div>
    
        
    </div>

 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
