<?php
    
 Class Connexion {

    public $condatabase;
    public $connected;

    public function __construct($hostname, $useradmin, $mdpuseradmin, $database) {
        /* Connexion sur la base de travail */
        $this->condatabase = mysqli_connect($hostname, $useradmin, $mdpuseradmin, $database);
        // Check connection
        if (mysqli_connect_errno())
        {   echo "Failed to connect to MySQL: " . mysqli_connect_error();
            $this->connected = false;  }
        else {
            echo "Vous etes connecté sur la base<br>";
            $this->connected = true;
        }
    }


    public function lanceSQL($req) {
        echo "Lancement avec instruction SQL : " . $req . "<br>";
        var_dump($this->condatabase);
        $result = $this->condatabase->query($req);
        while ($row = mysqli_fetch_array($result)) {
            echo $row[2];
        }

        /* 
        if ($this->condatabase->query($req) === FALSE) {
            echo "Error: Création de la view COULEUR" . $this->condatabase->error; }
            */
            
    }

    public function fermerdatabase() {
        $this->condatabase->close();
        $this->connected=false;
        echo "Connexion à la base fermée<br>";
    }

    public function statusconnect() {
        if ($this->connected) {
            echo "Connecté a la base<br>";
        } else {
            echo "Nous ne sommes pas connecté<br>";
        }
    }


}

?>