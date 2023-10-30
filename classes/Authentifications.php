<?php
namespace APP;
use PDO;
class Authentifications
{
  protected $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;  
  }
  public function ValidationFormulaire()
  {
    if (isset($_POST["inscription"])) {
      $nom = $_POST["nom"];
      $prenom = $_POST["prenom"];
      $email = $_POST["email"]; 
      $telephone = $_POST["telephone"];
      $password = $_POST["password"]; 
      if (!preg_match('/^[A-Za-z]+$/', $nom) || !preg_match('/^[A-Za-z]+$/', $prenom)) {
        echo "Le nom et le prénom doivent contenir uniquement des lettres.";
        return;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse email n'est pas valide.";
        return;
    }

    if (!preg_match('/^77\d{7}$/', $telephone)) {
        echo "Le numéro de téléphone n'est pas valide.";
        return;
    }
    if (strlen($password) < 6 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        echo "Le mot de passe doit contenir au moins 6 caractères avec des caractères spéciaux.";
        return;
    }
      $this->InsereUtilisateur($nom,$prenom,$email,$telephone,$password);
    }
 
    
  }

  private function InsereUtilisateur($nom,$prenom,$email,$telephone,$password)
  {
    $sql = "INSERT INTO client (nom,prenom,email,telephone,password) VALUES (:nom,:prenom,:email,:telephone,:password)";
    $boura = $this->conn->prepare($sql);  
    $boura->bindParam(":nom",$nom,PDO::PARAM_STR);  
    $boura->bindParam(":prenom",$prenom,PDO::PARAM_STR);
    $boura->bindParam(":email",$email,PDO::PARAM_STR);
    $boura->bindParam("telephone",$telephone,PDO::PARAM_STR);
    $boura->bindParam(":password",$password,PDO::PARAM_STR);
    if ($boura->execute()) {
      echo "vous vous etes inscrit avec succe";
    }else {
      echo "oupss une erreur sest produit";
    }
  }

  public function KayMaAuthentifierLa($email,$password)
  {
    if (isset($_POST["connexion"])) {
      $email = $_POST["email"]; 
      $password = $_POST["password"];
      $sql = "SELECT * FROM client WHERE email=:email";
      $boura = $this->conn->prepare($sql);
      $boura->bindParam(":email",$email,PDO::PARAM_STR);
      $boura->execute();  
      $user = $boura->fetch(PDO::FETCH_ASSOC);
      if ($user && $password === $user["password"]) {
        // echo "vous vous etes connecter avec succee";
        // header('location:acceuil.php');
        echo "<script>window.location.href='acceuil.php';</script>";
        
      }else {
        echo "oupss xolatal araf yigua douguale amna lousi mbenguowoule";
      }
    }
  }

  public function toutUtilisateur()
  {
    $sql = "SELECT * FROM client";
    $boura = $this->conn->prepare($sql);  
    $boura->execute();  
    return $boura->fetchAll(PDO::FETCH_ASSOC);

  }
}



?>