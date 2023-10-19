<?php

function check()
{
    if (!empty($_POST)) {
        if (empty($_POST["prenom"])) {
            $GLOBALS["errorPrenom"] = "Merci de remplir ce champ !";
        }else {
            $GLOBALS["valuePrenom"] = $_POST["prenom"];
        }
    
        if (empty($_POST["nom"])) {
            $GLOBALS["errorNom"] = "Merci de remplir ce champ !";
        }else {
            $GLOBALS["valueNnom"] = $_POST["nom"];
        }
    
        if (empty($_POST["email"])) {
            $GLOBALS["errorEmail"] ="Merci de remplir ce champ !";
        }else {
            $GLOBALS["valueEmail"] = $_POST["email"];
        }
        if (empty($_POST["telephone"])) {
            $GLOBALS["errorTelephone"] ="Merci de remplir ce champ !";
        }else {
            $GLOBALS["valueTelephone"] = $_POST["telephone"];
        }
    
        if (empty($_POST["password"])) {
            $GLOBALS["errorPassword"] ="Merci de remplir ce champ !";
        }else {
            $GLOBALS["valuePassword"] = $_POST["password"];
        }
    
    
    }
    
    
}


?>