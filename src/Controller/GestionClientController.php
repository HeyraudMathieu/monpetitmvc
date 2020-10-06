<?php
namespace APP\Controller;

use APP\Model\GestionClientModel;
use ReflectionClass;
use Exception;
use APP\Entity\Client;
use Tools\Repository;

class GestionClientController {
    
    public function chercheUn($params){
        $repository = Repository::getRepository("APP\Entity\Client");
        $ids = $repository->findIds();
        //on place ces ids dans le tableau de paramètres que l'on va envoyer à la vue
        $params['lesIds'] = $ids;
        //on teste si l'id du client à chercher à été passé dans l'url
        if(array_key_exists('id', $params)) {
            $id = filter_var(intval($params["id"]), FILTER_VALIDATE_INT);
            $unClient = $repository->find($id);
            //on place le client trouvé dans le tableau de parametre que l'on va envoyer a la vue
            $params['unClient'] = $unClient;
        }
        $r = new \ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName()) ."/unClient.html.twig";
        \Tools\MyTwig::afficheVue($vue, $params);
    }
    
    public function chercheTous() {
        // appel de la méthode findAll()
        //$model = new GestionClientModel();
        //$tousClients = $model->findAll();
        
        // instanciation du repository
        $repository = Repository::getRepository("APP\Entity\Client");
        $tousClients = $repository->findAll();
        if($tousClients) {
            $r = new ReflectionClass($this);
            $vue = str_replace('Controller', 'View', $r->getShortName()) ."/tousClients.html.twig";
            \Tools\MyTwig::afficheVue($vue, array('tousClients' => $tousClients));
        } else {
            throw new Exception("Aucun client à afficher");
        }
    }
    
    public function creerClient($params) {
        if(empty($params)) {
            $vue = "GestionClientView\\creerClient.html.twig";
            \Tools\MyTwig::afficheVue($vue, array());
        } else {
            // création de l'objet client
            $client = new Client($params);
            $repository = Repository::getRepository("APP\Entity\Client");
            $repository->insert($client);
            $this->chercheTous();
        }
        
    }
    
    public function enregistreClient($params){
        $client = new Client($params);
        $modele = new GestionClientModel();
        $modele->enregistreClient($client);
    }
    
    public function nbClients($params){
        $repository = Repository::getRepository("APP\Entity\Client");
        $nbClients = $repository->countRows();
        echo "nombre de clients : " . $nbClients;
    }
    
}