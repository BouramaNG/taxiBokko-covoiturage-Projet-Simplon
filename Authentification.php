<?php 
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache");
header("Expires: 0"); 

require("functions.php");
$errorPrenom=$errorNom=$errorEmail=$errorTelephone=$errorPassword="";
$valuePrenom=$valueNom=$valueEmail=$valueTelephone=$valuePassword="";
check();

$host = "localhost"; 
$dbname= "etaxibokko";
$username = "root";
$password = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
   // echo "connexion reuissi";
} catch (PDOException $e) {
    echo "erreur de connexion a la base de donnee".$e->getMessage();
}
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST["inscription"])) {
        $prenom = $_POST["prenom"];
        $nom =  $_POST["nom"];
        $email = $_POST["email"];
        $telephone = $_POST["telephone"];
        $password = $_POST["password"];

        if (!preg_match('/^[A-Za-z ]+$/', $prenom) || !preg_match('/^[A-Za-z ]+$/', $nom)) {
            echo '<div class="error-message">Le prénom et le nom doivent contenir uniquement des lettres.</div>';
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<div class="error-message">L\'email n\'est pas valide.</div>';
        }
        elseif (!preg_match('/^77[0-9]{7}$/', $telephone)) {
            echo '<div class="error-message">Le numéro de téléphone n\'est pas valide. Il doit commencer par \'77\' suivi de 7 chiffres.</div>';
        }
     
        elseif (strlen($password) < 7 || !preg_match('/[!@#$%^&*(),.?":{}|<>0-9A-Za-z]+/', $password)) {
            echo '<div class="error-message">Le mot de passe n\'est pas sécurisé. Il doit contenir au moins 7 caractères avec des caractères spéciaux, lettres et chiffres.</div>';
        } else {
            // Vérifier si l'adresse e-mail existe déjà
            $checkUserExists = "SELECT * FROM client WHERE email = :email";
            $checkUserExistsStmt = $db->prepare($checkUserExists);
            $checkUserExistsStmt->bindValue(':email', $email);
            $checkUserExistsStmt->execute();

            if ($checkUserExistsStmt->rowCount() > 0) {
                echo '<div class="error-message">L\'adresse e-mail est déjà enregistrée.</div>';
            } else {
                // Insérer l'utilisateur dans la base de données
                $password = md5($password);
                $insertUser = "INSERT INTO client (prenom, nom, email, telephone, password) VALUES (:prenom, :nom, :email, :telephone, :password)";
                $insertUserStmt = $db->prepare($insertUser);
                $insertUserStmt->bindValue(':prenom', $prenom);
                $insertUserStmt->bindValue(':nom', $nom);
                $insertUserStmt->bindValue(':email', $email);
                $insertUserStmt->bindValue(':telephone', $telephone);
                $insertUserStmt->bindValue(':password', $password);

                if ($insertUserStmt->execute()) {
                    echo '<div class="success-message">E-taxiBoko vous remercie de votre inscription !</div>';
                } else {
                    echo '<div class="error-message">Oups, une erreur s\'est produite lors de l\'inscription.</div>';
                }
            }
        }
    } elseif (isset($_POST["connexion"])) {
        $email = $_POST["email"];
        $passworde = $_POST["password"];
        $boura = "SELECT * FROM client WHERE email = :email";
        $bourama = $db->prepare($boura);
        $bourama->bindValue(':email', $email);
        $bourama->execute();
        $utilisateur = $bourama->fetch();
       // var_dump($utilisateur);

       if ($utilisateur && md5($passworde) === $utilisateur['password']) {
        session_start();
       $_SESSION['user'] = $utilisateur;       
            header("Location: covoiturage.php");
            exit;
        } else {
            echo '<div class="error-message">Oupsss Veuillez revoir vos identifiant de connexion Amna lousi bakhoule.</div>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-Taxibokko</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
<style type="text/css">
label{
    font-size:16px;
    font-weight:bold;
    color:#000;
}
.error{
    color: red;
    font-size: 10px;
}
.container{
    display: flex;
    justify-content: space-between;

}
.form1{
    width: 40%;
    
}
.form2{
    width: 50%;
  
 
}
.error-message {
    color: white;
    font-weight: bold;
    background-color: red;
    text-align: center;
}

.success-message {
    color: white;
    font-weight: bold;
    text-align: center;
    background-color: green;
}
</style>


</head>

<body>

                <div class="container">
               

               <div class="form1">
               <form  method="post">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h3 class="m-0 font-weight-bold text-dark">Incription</h3>
                                    <h6 class="m-0 font-weight-bold">Votre Chauffeur en un clic</h6>
                                </div>
 
                                <div class="card-body">
                                <div class="form-group">
                                 <input type="submit" class="btn btn-primary btn-user btn-block" name="submit" id="submit" value="Continuer avec facebook">                           
                             </div>
                        <div class="form-group">
                            <label for="email">Email </label>
                            <input type="email" class="form-control" placeholder="Veuillez entre votre email" name="email" required>
                                        </div>
                                      
                                        <div class="form-group">
                            <label for="password">Mot de passe </label>
                            <input type="password" class="form-control" placeholder="Veuillez entre votre mot de passe" name="password" required>
                                        </div>
                                        <div class="form-group float-right">
                                 <input type="submit" class="btn btn-primary btn-user mr-20" name="connexion" id="submit" value="Connexion">                           
                             </div>
                                </div>
                            </div>
                            </form>
                        </div>
 
                        <div class="form2">
                        <form class="shadow" name="newtesting" method="post">
                           <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h3 class="m-0 font-weight-bold text-dark">Bienvenue</h3>
                                    <h6 class="m-0 font-weight-bold">Finalisez votre inscription en renseignat les infos manqauntes !</h6>
                                </div>
                                <div class="card-body">
                           
                                <div class="form-row">
    <div class="col">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrer votre prénom..." pattern="[A-Za-z ]+" title="lettres uniquement" required="true" value="<?php echo $valuePrenom ?>">
        <p class="error"><?php echo $errorPrenom ?></p>
    </div>
    <div class="col">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrer votre nom..." pattern="[A-Za-z ]+" title="lettres uniquement" required="true" value="<?php echo $valueNom ?>">
        <p class="error"><?php echo $errorNom ?></p>
    </div>
</div>
<div class="form-group">
                            <label for="email">Email </label>
                            <input type="email" class="form-control" placeholder="Veuillez entre votre email" name="email" required value="<?php echo $valueEmail ?>">
                            <p class="error"><?php echo $errorEmail ?></p>
                                        </div>
<div class="form-group">
    <label for="telephone">Téléphone</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTi_VP_W13HvnlsImXBExW_WM03q4ByIK6Aqxh12HqCqQ&s" alt="Drapeau Sénégal" width="20" height="20">&nbsp &nbsp &nbsp+221 </span>
        </div>
        <input type="phone" class="form-control" placeholder="Entrez votre numéro de téléphone" name="telephone" required value="<?php echo $valueTelephone ?>">
        <p class="error"><?php echo $errorTelephone ?></p>
    </div>
</div> 
<div class="form-group">
                            <label for="password">Mot de passe </label>
                            <input type="password" class="form-control" placeholder="Veuillez choisir un mot de passe" name="password" required value="<?php echo $valuePassword ?>">
                            <p class="error"><?php echo $errorPassword ?></p>
                                        </div>
<div class="">
            <span class=""><img src="https://www.3suisses.fr/media/images/web/produit/308589/20201125161646/cadeau3slast_1200x1200.png" alt="Drapeau Sénégal" width="30" height="30">&nbspAjouter un code promo </span>
        </div>                             
                               
        <div class="form-group float-right">
                                 <input type="submit" class="btn btn-primary btn-user mr-20" name="inscription" id="submit" value="S'inscrire">                           
                             </div>

                                </div>
                            </div>
                       
                            </form>
                        </div>

                    </div>



    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>