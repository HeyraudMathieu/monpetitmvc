<?php
namespace APP\Model;

use \PDO;
use APP\Entity\Client;
use Tools\Connexion;

class GestionClientModel {
    
    public function find($id) {
        $unObjetPdo = Connexion::getConnexion();
        $sql = "select * from client where id = :id";
        $ligne = $unObjetPdo->prepare($sql);
        $ligne->bindValue(':id', $id, PDO::PARAM_INT);
        $ligne->execute();
        return $ligne->fetchObject(Client::class);
    }
    
    public function findAll(){
        $unObjetPdo = Connexion::getConnexion();
        $sql = "select * from client";
        $ligne = $unObjetPdo->query($sql);
        return $ligne->fetchAll(PDO::FETCH_CLASS ,Client::class);
    }
    
    public function recupChampTable() {
        $unObjetPdo = Connexion::getConnexion();
        $sql = "SELECT column_name FROM information_schema.columns WHERE table_name = 'client' AND table_schema='clicommvc';";
        $ligne = $unObjetPdo->query($sql);
        return $ligne->fetchAll(PDO::FETCH_CLASS ,Client::class);
    }
    
    public function enregistreClient($client) {
        $unObjetPdo = Connexion::getConnexion();
        $sql = "insert into client(titreCli, nomCli, prenomCli, adresseRue1Cli, adresseRue2Cli, cpCli, villeCli, telCli)"
                . "values (:titreCli, :nomCli, :prenomCli, :adresseRue1Cli, :adresseRue2Cli)";
    }
    
}