<?php

namespace MDQ\GeneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatsQuot
 *
 * @ORM\Table(name="statsquot")
 * @ORM\Entity(repositoryClass="MDQ\GeneBundle\Entity\StatsQuotRepository")
 */
class StatsQuot
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Day", type="date")
     */
    private $day;

    /**
     * @var integer
     *
     * @ORM\Column(name="rMDQ", type="integer", nullable=true)
     */
    private $rMDQ;

    /**
     * @var integer
     *
     * @ORM\Column(name="mMDQ", type="integer", nullable=true)
     */
    private $mMDQ;

    /**
     * @var integer
     *
     * @ORM\Column(name="sMDQ", type="integer", nullable=true)
     */
    private $sMDQ;

    /**
     * @var integer
     *
     * @ORM\Column(name="ffMDQ", type="integer", nullable=true)
     */
    private $ffMDQ;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="lxMDQ", type="integer", nullable=true)
     */
    private $lxMDQ;
    
        /**
     * @var integer
     *
     * @ORM\Column(name="arMDQ", type="integer", nullable=true)
     */
    private $arMDQ;

        /**
     * @var integer
     *
     * @ORM\Column(name="muMDQ", type="integer", nullable=true)
     */
    private $muMDQ;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbPtot", type="integer")
     */
    private $nbPtot;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbPMq", type="integer")
     */
    private $nbPMq;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPFf", type="integer")
     */
    private $nbPFf;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPMu", type="integer")
     */
    private $nbPMu;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPLx", type="integer")
     */
    private $nbPLx;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPAr", type="integer")
     */
    private $nbPAr;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPTotbot", type="integer")
     */
    private $nbPTotbot;    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbPMqbot", type="integer")
     */
    private $nbPMqbot;

    /**
     * @var integer
     *
     * @ORM\Column(name="scMoyP", type="integer", nullable=true)
     */
    private $scMoyP;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="scMoyPbot", type="integer", nullable=true)
     */
    private $scMoyPbot;

    
     /**
     * @var integer
     *
     * @ORM\Column(name="nbQMqV", type="integer", nullable=true)
     */
    private $nbQMqV;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="nbQFfV", type="integer", nullable=true)
     */
    private $nbQFfV;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="nbQLxV", type="integer", nullable=true)
     */
    private $nbQLxV;
    
         /**
     * @var integer
     *
     * @ORM\Column(name="nbQArx", type="integer", nullable=true)
     */
    private $nbQArV;
    
         /**
     * @var integer
     *
     * @ORM\Column(name="nbQMuV", type="integer", nullable=true)
     */
    private $nbQMuV;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbQprop", type="integer")
     */
    private $nbQprop;


    /**
     * @var integer
     *
     * @ORM\Column(name="nbUserDay", type="integer")
     */
    private $nbUserDay;

     /**
     * @var integer
     *
     * @ORM\Column(name="nbUser7j", type="integer")
     */
    private $nbUser7j;
    
         /**
     * @var integer
     *
     * @ORM\Column(name="nbUser30j", type="integer")
     */
    private $nbUser30j;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbNewUser", type="integer")
     */
    private $nbNewUser;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid;

	public function __construct()
	{
		$this->day = new \Datetime(date('Y-m-d')); 
		$this->rMDQ = null;
		$this->mMDQ = null;
		$this->sMDQ = null;
		$this->ffMDQ = null;
		$this->arMDQ = null;
		$this->lxMDQ = null;
		$this->muMDQ = null;
		$this->nbPtot=0;
		$this->nbPMq=0;
		$this->nbPLx=0;
		$this->nbPMu=0;
		$this->nbPAr=0;
		$this->nbPFf=0;
		$this->nbPTotbot=0;
		$this->nbPMqbot=0;
		$this->nbQprop=0;
		$this->scMoyP=null;		
		$this->scMoyPbot=null;
		$this->nbUserDay=0;
		$this->nbUser7j=0;
		$this->nbUser30j=0;
		$this->nbNewUser=0;
		$this->nbQMqV=null;
		$this->nbQFfV=null;
		$this->nbQLxV=null;
		$this->nbQArV=null;
		$this->nbQMuV=null;
		$this->valid=false;
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
     * Set day
     *
     * @param \DateTime $day
     * @return StatsQuot
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set rMDQ
     *
     * @param integer $rMDQ
     * @return StatsQuot
     */
    public function setRMDQ($rMDQ)
    {
        $this->rMDQ = $rMDQ;

        return $this;
    }

    /**
     * Get rMDQ
     *
     * @return integer 
     */
    public function getRMDQ()
    {
        return $this->rMDQ;
    }

    /**
     * Set mMDQ
     *
     * @param integer $mMDQ
     * @return StatsQuot
     */
    public function setMMDQ($mMDQ)
    {
        $this->mMDQ = $mMDQ;

        return $this;
    }

    /**
     * Get mMDQ
     *
     * @return integer 
     */
    public function getMMDQ()
    {
        return $this->mMDQ;
    }

    /**
     * Set sMDQ
     *
     * @param integer $sMDQ
     * @return StatsQuot
     */
    public function setSMDQ($sMDQ)
    {
        $this->sMDQ = $sMDQ;

        return $this;
    }

    /**
     * Get sMDQ
     *
     * @return integer 
     */
    public function getSMDQ()
    {
        return $this->sMDQ;
    }

    /**
     * Set ffMDQ
     *
     * @param integer $ffMDQ
     * @return StatsQuot
     */
    public function setFfMDQ($ffMDQ)
    {
        $this->ffMDQ = $ffMDQ;

        return $this;
    }

    /**
     * Get ffMDQ
     *
     * @return integer 
     */
    public function getFfMDQ()
    {
        return $this->ffMDQ;
    }

    /**
     * Set lxMDQ
     *
     * @param integer $lxMDQ
     * @return StatsQuot
     */
    public function setLxMDQ($lxMDQ)
    {
        $this->lxMDQ = $lxMDQ;

        return $this;
    }

    /**
     * Get lxMDQ
     *
     * @return integer 
     */
    public function getLxMDQ()
    {
        return $this->lxMDQ;
    }

    /**
     * Set arMDQ
     *
     * @param integer $arMDQ
     * @return StatsQuot
     */
    public function setArMDQ($arMDQ)
    {
        $this->arMDQ = $arMDQ;

        return $this;
    }

    /**
     * Get arMDQ
     *
     * @return integer 
     */
    public function getArMDQ()
    {
        return $this->arMDQ;
    }

    /**
     * Set muMDQ
     *
     * @param integer $muMDQ
     * @return StatsQuot
     */
    public function setMuMDQ($muMDQ)
    {
        $this->muMDQ = $muMDQ;

        return $this;
    }

    /**
     * Get muMDQ
     *
     * @return integer 
     */
    public function getMuMDQ()
    {
        return $this->muMDQ;
    }

    /**
     * Set nbPtot
     *
     * @param integer $nbPtot
     * @return StatsQuot
     */
    public function setNbPtot($nbPtot)
    {
        $this->nbPtot = $nbPtot;

        return $this;
    }

    /**
     * Get nbPtot
     *
     * @return integer 
     */
    public function getNbPtot()
    {
        return $this->nbPtot;
    }

    /**
     * Set nbPMq
     *
     * @param integer $nbPMq
     * @return StatsQuot
     */
    public function setNbPMq($nbPMq)
    {
        $this->nbPMq = $nbPMq;

        return $this;
    }

    /**
     * Get nbPMq
     *
     * @return integer 
     */
    public function getNbPMq()
    {
        return $this->nbPMq;
    }

    /**
     * Set nbPFf
     *
     * @param integer $nbPFf
     * @return StatsQuot
     */
    public function setNbPFf($nbPFf)
    {
        $this->nbPFf = $nbPFf;

        return $this;
    }

    /**
     * Get nbPFf
     *
     * @return integer 
     */
    public function getNbPFf()
    {
        return $this->nbPFf;
    }

    /**
     * Set nbPMu
     *
     * @param integer $nbPMu
     * @return StatsQuot
     */
    public function setNbPMu($nbPMu)
    {
        $this->nbPMu = $nbPMu;

        return $this;
    }

    /**
     * Get nbPMu
     *
     * @return integer 
     */
    public function getNbPMu()
    {
        return $this->nbPMu;
    }

    /**
     * Set nbPLx
     *
     * @param integer $nbPLx
     * @return StatsQuot
     */
    public function setNbPLx($nbPLx)
    {
        $this->nbPLx = $nbPLx;

        return $this;
    }

    /**
     * Get nbPLx
     *
     * @return integer 
     */
    public function getNbPLx()
    {
        return $this->nbPLx;
    }

    /**
     * Set nbPAr
     *
     * @param integer $nbPAr
     * @return StatsQuot
     */
    public function setNbPAr($nbPAr)
    {
        $this->nbPAr = $nbPAr;

        return $this;
    }

    /**
     * Get nbPAr
     *
     * @return integer 
     */
    public function getNbPAr()
    {
        return $this->nbPAr;
    }

    /**
     * Set nbPTotbot
     *
     * @param integer $nbPTotbot
     * @return StatsQuot
     */
    public function setNbPTotbot($nbPTotbot)
    {
        $this->nbPTotbot = $nbPTotbot;

        return $this;
    }

    /**
     * Get nbPTotbot
     *
     * @return integer 
     */
    public function getNbPTotbot()
    {
        return $this->nbPTotbot;
    }

    /**
     * Set nbPMqbot
     *
     * @param integer $nbPMqbot
     * @return StatsQuot
     */
    public function setNbPMqbot($nbPMqbot)
    {
        $this->nbPMqbot = $nbPMqbot;

        return $this;
    }

    /**
     * Get nbPMqbot
     *
     * @return integer 
     */
    public function getNbPMqbot()
    {
        return $this->nbPMqbot;
    }

    /**
     * Set scMoyP
     *
     * @param integer $scMoyP
     * @return StatsQuot
     */
    public function setScMoyP($scMoyP)
    {
        $this->scMoyP = $scMoyP;

        return $this;
    }

    /**
     * Get scMoyP
     *
     * @return integer 
     */
    public function getScMoyP()
    {
        return $this->scMoyP;
    }

    /**
     * Set nbQprop
     *
     * @param integer $nbQprop
     * @return StatsQuot
     */
    public function setNbQprop($nbQprop)
    {
        $this->nbQprop = $nbQprop;

        return $this;
    }

    /**
     * Get nbQprop
     *
     * @return integer 
     */
    public function getNbQprop()
    {
        return $this->nbQprop;
    }

    /**
     * Set nbUser
     *
     * @param integer $nbUser
     * @return StatsQuot
     */
    public function setNbUser($nbUser)
    {
        $this->nbUser = $nbUser;

        return $this;
    }

    /**
     * Get nbUser
     *
     * @return integer 
     */
    public function getNbUser()
    {
        return $this->nbUser;
    }

    /**
     * Set nbNewUser
     *
     * @param integer $nbNewUser
     * @return StatsQuot
     */
    public function setNbNewUser($nbNewUser)
    {
        $this->nbNewUser = $nbNewUser;

        return $this;
    }

    /**
     * Get nbNewUser
     *
     * @return integer 
     */
    public function getNbNewUser()
    {
        return $this->nbNewUser;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     * @return StatsQuot
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean 
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set nbUserDay
     *
     * @param integer $nbUserDay
     * @return StatsQuot
     */
    public function setNbUserDay($nbUserDay)
    {
        $this->nbUserDay = $nbUserDay;

        return $this;
    }

    /**
     * Get nbUserDay
     *
     * @return integer 
     */
    public function getNbUserDay()
    {
        return $this->nbUserDay;
    }

    /**
     * Set nbUser7j
     *
     * @param integer $nbUser7j
     * @return StatsQuot
     */
    public function setNbUser7j($nbUser7j)
    {
        $this->nbUser7j = $nbUser7j;

        return $this;
    }

    /**
     * Get nbUser7j
     *
     * @return integer 
     */
    public function getNbUser7j()
    {
        return $this->nbUser7j;
    }

    /**
     * Set nbUser30j
     *
     * @param integer $nbUser30j
     * @return StatsQuot
     */
    public function setNbUser30j($nbUser30j)
    {
        $this->nbUser30j = $nbUser30j;

        return $this;
    }

    /**
     * Get nbUser30j
     *
     * @return integer 
     */
    public function getNbUser30j()
    {
        return $this->nbUser30j;
    }

    /**
     * Set scMoyPbot
     *
     * @param integer $scMoyPbot
     * @return StatsQuot
     */
    public function setScMoyPbot($scMoyPbot)
    {
        $this->scMoyPbot = $scMoyPbot;

        return $this;
    }

    /**
     * Get scMoyPbot
     *
     * @return integer 
     */
    public function getScMoyPbot()
    {
        return $this->scMoyPbot;
    }

    /**
     * Set nbQMqV
     *
     * @param integer $nbQMqV
     * @return StatsQuot
     */
    public function setNbQMqV($nbQMqV)
    {
        $this->nbQMqV = $nbQMqV;

        return $this;
    }

    /**
     * Get nbQMqV
     *
     * @return integer 
     */
    public function getNbQMqV()
    {
        return $this->nbQMqV;
    }

    /**
     * Set nbQFfV
     *
     * @param integer $nbQFfV
     * @return StatsQuot
     */
    public function setNbQFfV($nbQFfV)
    {
        $this->nbQFfV = $nbQFfV;

        return $this;
    }

    /**
     * Get nbQFfV
     *
     * @return integer 
     */
    public function getNbQFfV()
    {
        return $this->nbQFfV;
    }

    /**
     * Set nbQLxV
     *
     * @param integer $nbQLxV
     * @return StatsQuot
     */
    public function setNbQLxV($nbQLxV)
    {
        $this->nbQLxV = $nbQLxV;

        return $this;
    }

    /**
     * Get nbQLxV
     *
     * @return integer 
     */
    public function getNbQLxV()
    {
        return $this->nbQLxV;
    }

    /**
     * Set nbQArV
     *
     * @param integer $nbQArV
     * @return StatsQuot
     */
    public function setNbQArV($nbQArV)
    {
        $this->nbQArV = $nbQArV;

        return $this;
    }

    /**
     * Get nbQArV
     *
     * @return integer 
     */
    public function getNbQArV()
    {
        return $this->nbQArV;
    }

    /**
     * Set nbQMuV
     *
     * @param integer $nbQMuV
     * @return StatsQuot
     */
    public function setNbQMuV($nbQMuV)
    {
        $this->nbQMuV = $nbQMuV;

        return $this;
    }

    /**
     * Get nbQMuV
     *
     * @return integer 
     */
    public function getNbQMuV()
    {
        return $this->nbQMuV;
    }
}
