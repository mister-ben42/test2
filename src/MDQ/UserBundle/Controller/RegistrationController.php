<?php

// src/MDQ/UserBundle/Controller/RegistrationController.php

namespace MDQ\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;


class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
	// Mon rajout
		if(!$this->container->get('mdq_admin.security')->testAutorize("register", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
	else{
	// Le register de FOS User
	    $response = parent::registerAction($request);
            return $response;
          }
        }

}
