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
    
}