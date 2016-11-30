<?php

namespace MDQ\UserBundle\Services;


class UserServ
{    
      private $myrepository;
 
      public function __construct($myrepository ) {
	  $this->myrepository = $myrepository ;
      }
      
      public function recupData($medailles)
      {
	      $data['medKmOr']="<img src={{ asset('bundles/UserBundle/MedOr4.png') }} alt='Med' width='60px'>";
	      $data['medKmAg']=$medailles->getKm2();
	      $data['medKmBz']=$medailles->getKm3();
	      $data['medKmCh']=$medailles->getKm4();
	      $data['medKmCt']=$medailles->getKm5();
	      //$dateref=$this->myrepository->findById(1);// juste pour essayer
      

	      return $data;
      }

}


