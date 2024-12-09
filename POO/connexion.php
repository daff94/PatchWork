<?php
    

/** Class form
 * 
* Permet de gérer la connexion avec la base de données
*/

 Class Connexion {

    /**
     * Objet correspondant à la base de données
     *
     * @var [Msqli]
     */
    public $condatabase;

    /**
     * Indicateur si nous sommes connecté ou pas à la base
     *
     * @var boolean
     */
    private $connected=false;


    /**
     * Contructeur d'ouverture et connexion sur une base MySQL
     *
     * @param [string] $hostname
     * @param [string] $useradmin
     * @param [string] $mdpuseradmin
     * @param [string] $database
     */
    public function __construct($hostname, $useradmin, $mdpuseradmin, $database) {
        /* Connexion sur la base de travail */
        // echo $hostname, $useradmin, $mdpuseradmin, $database;
        try {
            $this->condatabase = mysqli_connect($hostname, $useradmin, $mdpuseradmin, $database);
        } catch (mysqli_sql_exception $e) {
            die("Probleme de connexion au serveur de données");
        }
        $this->connected = true;
    }

    /**
     * Lance une requete SQL
     *
     * @param [string] $req
     * @return mysqli_result
     */
    public function lanceSQL($req) {
        if ($this->connected) {
            return $this->condatabase->query($req); 
        }
    }

    /**
     * Ferme la base ouverte
     *
     * @return void
     */
    public function fermerdatabase() {
        $this->condatabase->close();
        $this->connected=false;
        echo "Connexion à la base fermée<br>";
    }

    /**
     * Statut de connexion sur la base
     *
     * @return void
     */
    public function statusconnect() {
        $statusConnexion = false;
        if ($this->connected) {
            echo "Connecté a la base<br>";
            $statusConnexion=true;
        } else {
            echo "Nous ne sommes pas connecté<br>";
            $statusConnexion=false;
        }
        return $statusConnexion;
    }


}

?>