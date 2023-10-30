<?php
use APP\Authentifications;
use APP\MyDB;
require_once'classes/MyDB.php';
require_once'classes/Authentifications.php';
$host = "localhost";
$dbname ="taxi";
$username="root";
$password= "root";

$connection1 = new MyDB($host, $dbname, $username, $password); 
$connection1->Connection();
$conn = $connection1->getConn();
$user = new Authentifications($conn);
$users=$user->toutUtilisateur();
// var_dump($users);   
// die();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <style>

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 5px 5px 0 0;
        }

        nav {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h2>Liste des utilisateurs</h2>
    </header>

    <div class="content">
        <?php
   
        if (!empty($users)) {
            echo "<ul>";
            foreach ($users as $user) {
                echo "<li>" . $user['nom'] . " " . $user['prenom'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Aucun utilisateur trouvé.";
        }
        ?>
    </div>
</html>
