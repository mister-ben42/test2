<?php

// src/MDQ/UserBundle/Controller/ResettingController.php

namespace MDQ\UserBundle\Controller;

use FOS\UserBundle\Controller\ResettingController as BaseController;
use Symfony\Component\HttpFoundation\Request;


class ResettingController extends BaseController
{
    public function requestAction()
    {
	// Mon rajout
		if(!$this->container->get('mdq_admin.security')->testAutorize("simpleAction", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
	else{
	// Le register de FOS User
	    $response = parent::requestAction();
            return $response;
          }
        }
    public function sendEmailAction(Request $request)
    {
	// Mon rajout
		if(!$this->container->get('mdq_admin.security')->testAutorize("simpleAction", null)){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
	else{
	// Le register de FOS User
	    $response = parent::sendEmailAction($request);
            return $response;
          }
        }

}
