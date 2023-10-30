<?php
namespace APP;
use PDO;
use InvalidArgumentException;
class MyDB 
{
    protected $host;
    protected $username;
    protected $dbname;
    protected $password;
    protected $conn;
    
    public function __construct()
    {
        $this->host = "localhost";
        $this->username = "root";
        $this->dbname ="taxi";
        $this->password = "root";
    }
    public function getHost()   
    {
        return $this->host;
    }
    public function getUsername()   
    {
        return $this->username; 
    }
    public function getPassword()   
    {
                    return $this->password;
    }
        public function getDbname() 
        {
            return $this->dbname;
        }
    
        public function setHost($host)
        {
            
            if (filter_var($host, FILTER_VALIDATE_IP) || filter_var(gethostbyname($host), FILTER_VALIDATE_IP)) {
                $this->host = $host;
            } else {
                throw new InvalidArgumentException("Hôte non valide");
            }
        }
    
        public function setUsername($username)
        {
            if (ctype_alnum($username)) {
                $this->username = $username;
            } else {
                throw new InvalidArgumentException("Nom d'utilisateur non valide");
            }
        }
    
        public function setPassword($password)
        {
            if (strlen($password) >= 6) {
                $this->password = $password;
            } else {
                throw new InvalidArgumentException("Mot de passe non valide");
            }
        }
    
        public function setDbname($dbname)
        {
            
            $this->dbname = $dbname;
        }
    public function Connection()
    {
        try {
            $_dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $this->conn = new PDO($_dsn, $this->username, $this->password);  
            echo "connexion a la base de donne reussi"; 
        } catch (\PDOException $e) {
            echo "Oups erreur de la connexion";
        }
    }

    public function getConn()
    {
        return $this->conn;
    }
}



?>