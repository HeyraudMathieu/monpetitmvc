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
    
    public function nbClients(){
        $repository = Repository::getRepository("APP\Entity\Client");
        $nbClients = $repository->countRows();
        echo "nombre de clients : " . $nbClients;
    }
    
    public function testFindBy(){
        $repository = Repository::getRepository("APP\Entity\Client");
        $params = array("cpCli" => "14000", "titreCli" => "Madame");
        $clients = $repository->findBycpCli_and_titreCli($params);
        $r = new \ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName()) . "/tousClients.html.twig";
        \Tools\MyTwig::afficheVue($vue, array('tousClients' => $clients));
    }
    
    public function rechercheClients($params) {
        $repository = Repository::getRepository("APP\Entity\Client");
        $titres = $repository->findColumnDistinctValues('titreCli');
        $cps = $repository->findColumnDistinctValues('cpCli');
        $villes = $repository->findColumnDistinctValues('villeCli');
        $paramsVue['titres'] = $titres;
        $paramsVue['cps'] = $cps;
        $paramsVue['villes'] = $villes;
        if(isset($params['titreCli']) || isset($params['cpCli']) || isset($params['villeCli'])) {
            $element = "Choisir...";
            while(in_array($element, $params)){
                unset($params[array_search($element, $params)]);
            }
            if(count($params) > 0) {
                $clients = $repository->findBy($params);
                $paramsVue['tousClients'] = $clients;
                foreach($_POST as $valeur) {
                    ($valeur != "Choisir...") ? ($criteres[] = $valeur) : (null);
                }
                $paramsVue['criteres'] = $criteres;
            }
        }
        $vue = "GestionClientView\\filtreClients.html.twig";
        \Tools\MyTwig::afficheVue($vue, $paramsVue);
    }
    
    public function recupereDesClients($params){
        $repository = Repository::getRepository("APP\Entity\Client");
        $clients = $repository->findBy($params);
        $r = new \ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName()) . "/tousClients.html.twig";
        \Tools\MyTwig::afficheVue($vue, array('tousClients' => $clients));
    }
    
    public function chercheUnAjax($params): void {
        $repository = Repository::getRepository("APP\Entity\Client");
        $ids = $repository->findIds();
        $params['lesIds'] = $ids;
        $r = new ReflectionClass($this);
        $vue = str_replace('Controller', 'View', $r->getShortName()) . "/unClientAjax.html.twig";
        \Tools\MyTwig::afficheVue($vue, $params);
    }
    
}