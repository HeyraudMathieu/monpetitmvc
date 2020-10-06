<?php
namespace APP\Controller;

class IdentificationController {
    public function login() {
        header('location:http://monpetitmvc/?c=gestionClient&a=chercheUn');
    }
    
    
}