<?php

// src/MDQ/UserBundle/Controller/RegistrationController.php

namespace MDQ\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends BaseController
{
    public function loginAction(Request $request)
    {
	// Mon rajout - Attention, bloque aussi la connexion admin.
		$em = $this->getDoctrine()->getManager();
		$gestion=$gestion=$em->getRepository('MDQAdminBundle:Gestion')->find(1);
		if($gestion->getBlocageTot()==1){return $this->redirect($this->generateUrl('mdqgene_accueil'));}
	else{
	// Le register de FOS User
	    $response = parent::loginAction($request);
            return $response;
          }
        }

}
