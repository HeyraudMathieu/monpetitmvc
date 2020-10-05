<?php
namespace APP\Controller;

use APP\Model\GestionClientModel;
use ReflectionClass;
use Exception;

class GestionClientController {
    
    public function chercheUn($params) {
        // appel de la méthode find($id) de la classe Model adequate
        $model = new GestionClientModel();
        $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
        $unClient = $model->find($id);
        if($unClient) {
            $r = new ReflectionClass($this);
            //include_once PATH_VIEW . str_replace('Controller', 'View', $r->getShortName()) ."/unClient.php";
            $vue = str_replace('Controller', 'View', $r->getShortName()) ."/unClient.html.twig";
            \Tools\MyTwig::afficheVue($vue, array('unClient' => $unClient));
        } else {
            throw new Exception("Client " . $id . " inconnu");
        }
    }
    
    public function chercheTous() {
        // appel de la méthode findAll()
        $model = new GestionClientModel();
        $tousClients = $model->findAll();
        if($tousClients) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName()) ."/tousClients.html.twig";
            \Tools\MyTwig::afficheVue($vue, array('tousClients' => $tousClients));
        } else {
            throw new Exception("Aucun client à afficher");
        }
    }
    
    public function creerClient($params) {
        $vue = "GestionClientView\\creerClient;html.twig";
        \Tools\MyTwig::afficheVue($vue, array());
    }
    
}