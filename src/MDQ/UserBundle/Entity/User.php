<?php
// src/Sdz/UserBundle/Entity/User.php

namespace MDQ\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="mdq_user")
 * @ORM\Entity(repositoryClass="MDQ\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;  
   
  
   /**
    * @var boolean
    *
    * @ORM\Column(name="sexe", type="boolean")
    */
    private $sexe;

	 /**
     * @var \Date
     *
     * @ORM\Column(name="datenaissance", type="date")
     */
    private $datenaissance;
	
	/**
     * @var string
     *
     * @ORM\Column(name="departement", type="string", length=50)
     */
    private $departement;
	
	/**
     * @var string
     *
     * @ORM\Column(name="devise", type="string", length=255, nullable=true)
     */
    private $devise;
	
	 /**
     * @var \Date
     *
     * @ORM\Column(name="datecreate", type="date")
     */
    private $datecreate;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="allowError", type="boolean")
     */
	private $allowError;

      /**
      * @var boolean
      *
      * @ORM\Column(name="bot", type="boolean")
      */
      private $bot;
      
      /**
      * @var boolean
      *
      * @ORM\Column(name="supprime", type="boolean")
      */
      private $supprime;
      
       /**
      * @var boolean
      *
      * @ORM\Column(name="allowPropQ", type="boolean")
      */
      private $allowPropQ;
	
	/**
	* @ORM\OneToMany(targetEntity="MDQ\QuizzBundle\Entity\PartieQuizz",
	mappedBy="user")
	*/
	private $partiesQuizz;	
	
	/**
	* @ORM\OneToOne(targetEntity="MDQ\UserBundle\Entity\ScUser", inversedBy="usermap", cascade={"persist"})
	*/
	private $scUser;	
	
	
	public function __construct()
    {
        parent::__construct();
		$this->datecreate = new \Datetime(); // Par défaut, la date de 	création est la date d'aujourd'hui
		$this->roles=['ROLE_USER'];
		$this->scUser = new ScUser();
		$this->allowError=false;
		$this->bot=0;
		$this->supprime=0;
		$this->allowPropQ=0;
    }
	/**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
	
	 /**
     * Set sexe
     *
     * @param boolean $sexe
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return boolean 
     */
    public function getSexe()
    {
        return $this->sexe;
    }
	
	  /**
     * Set datenaissance
     *
     * @param \Date $datenaissance
     * @return User
     */
    public function setDatenaissance($datenaissance)
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    /**
     * Get datenaissance
     *
     * @return \Date
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }
	
	 /**
     * Set departement
     *
     * @param string $departement
     * @return User
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return string 
     */
    public function getDepartement()
    {
        return $this->departement;
    }
	
	 /**
     * Set dewise
     *
     * @param string $devise
     * @return User
     */
    public function setDevise($devise)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Get devise
     *
     * @return string 
     */
    public function getDevise()
    {
        return $this->devise;
    }
	
	/**
     * Set datecreate
     *
     * @param \Date $datecreate
     * @return User
     */
    public function setDatecreate($datecreate)
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    /**
     * Get datecreate
     *
     * @return \Date
     */
    public function getDatecreate()
    {
        return $this->datecreate;
    }
	
	/**
     * Set allowError
     *
     * @param boolean $allowError
     * @return ScUser
     */
    public function setAllowError($allowError)
    {
        $this->allowError = $allowError;

        return $this;
    }

    /**
     * Get allowError
     *
     * @return boolean 
     */
    public function getAllowError()
    {
        return $this->allowError;
    }
    
    	 /**
     * Set bot
     *
     * @param boolean $bot
     * @return User
     */
    public function setBot($bot)
    {
        $this->bot = $bot;

        return $this;
    }

    /**
     * Get bot
     *
     * @return boolean 
     */
    public function getBot()
    {
        return $this->bot;
    }

        	 /**
     * Set supprime
     *
     * @param boolean $supprime
     * @return User
     */
    public function setSupprime($supprime)
    {
        $this->supprime = $supprime;

        return $this;
    }

    /**
     * Get supprime
     *
     * @return boolean 
     */
    public function getSupprime()
    {
        return $this->supprime;
    }
    
     /**
     * Set allowPropQ
     *
     * @param boolean $allowPropQ
     * @return User
     */
    public function setAllowPropQ($allowPropQ)
    {
        $this->allowPropQ = $allowPropQ;

        return $this;
    }

    /**
     * Get allowPropQ
     *
     * @return boolean 
     */
    public function getAllowPropQ()
    {
        return $this->allowPropQ;
    }
    
    /**
     * Add partiesQuizz
     *
     * @param \MDQ\QuizzBundle\Entity\PartieQuizz $pariesQuizz
     * @return User
     */
    public function addPartiesQuizz(\MDQ\QuizzBundle\Entity\PartieQuizz $partiesQuizz)
    {
        $this->partiesQuizz[] = $partiesQuizz;

        return $this;
    }

    /**
     * Remove partiesQuizz
     *
     * @param \MDQ\QuizzBundle\Entity\PartieQuizz $partiesQuizz
     */
    public function removePartiesQuizz(\MDQ\QuizzBundle\Entity\PartieQuizz $partiesQuizz)
    {
        $this->partiesQuizz->removeElement($partiesQuizz);
    }

    /**
     * Get partiesQuizz
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPartiesQuizz()
    {
        return $this->partiesQuizz;
    }
	
	
	

    /**
     * Set scUser
     *
     * @param \MDQ\UserBundle\Entity\ScUser $scUser
     * @return User
     */
    public function setScUser(\MDQ\UserBundle\Entity\ScUser $scUser)
    {
        $this->scUser = $scUser;

        return $this;
    }

    /**
     * Get scUser
     *
     * @return \MDQ\UserBundle\Entity\ScUser 
     */
    public function getScUser()
    {
        return $this->scUser;
	}
   
    
}
