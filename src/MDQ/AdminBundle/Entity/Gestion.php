<?php

namespace MDQ\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gestion
 *
 * @ORM\Table(name="gestion")
 * @ORM\Entity(repositoryClass="MDQ\AdminBundle\Entity\GestionRepository")
 */
class Gestion
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
     * @var boolean
     *
     * @ORM\Column(name="BlocageTot", type="boolean")
     */
    private $blocageTot;

    /**
     * @var boolean
     *
     * @ORM\Column(name="JeuTot", type="boolean")
     */
    private $jeuTot;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Mq", type="boolean")
     */
    private $mq;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Ff", type="boolean")
     */
    private $ff;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Ar", type="boolean")
     */
    private $ar;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Mc", type="boolean")
     */
    private $mc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Lx", type="boolean")
     */
    private $lx;

    /**
     * @var boolean
     *
     * @ORM\Column(name="PropQ", type="boolean")
     */
    private $propQ;

    /**
     * @var boolean
     *
     * @ORM\Column(name="SignalE", type="boolean")
     */
    private $signalE;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Inscription", type="boolean")
     */
    private $inscription;

     /**
     * @var boolean
     *
     * @ORM\Column(name="Jetons_uniques", type="boolean")
     */
    private $jetons_uniques;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbJinit", type="integer")
     */
    private $nbJinit;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbJquot", type="integer")
     */
    private $nbJquot;
    
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
     * Set blocageTot
     *
     * @param boolean $blocageTot
     * @return Gestion
     */
    public function setBlocageTot($blocageTot)
    {
        $this->blocageTot = $blocageTot;

        return $this;
    }

    /**
     * Get blocageTot
     *
     * @return boolean 
     */
    public function getBlocageTot()
    {
        return $this->blocageTot;
    }

    /**
     * Set jeuTot
     *
     * @param boolean $jeuTot
     * @return Gestion
     */
    public function setJeuTot($jeuTot)
    {
        $this->jeuTot = $jeuTot;

        return $this;
    }

    /**
     * Get jeuTot
     *
     * @return boolean 
     */
    public function getJeuTot()
    {
        return $this->jeuTot;
    }

    /**
     * Set mq
     *
     * @param boolean $mq
     * @return Gestion
     */
    public function setMq($mq)
    {
        $this->mq = $mq;

        return $this;
    }

    /**
     * Get mq
     *
     * @return boolean 
     */
    public function getMq()
    {
        return $this->mq;
    }

    /**
     * Set ff
     *
     * @param boolean $ff
     * @return Gestion
     */
    public function setFf($ff)
    {
        $this->ff = $ff;

        return $this;
    }

    /**
     * Get ff
     *
     * @return boolean 
     */
    public function getFf()
    {
        return $this->ff;
    }

    /**
     * Set ar
     *
     * @param boolean $ar
     * @return Gestion
     */
    public function setAr($ar)
    {
        $this->ar = $ar;

        return $this;
    }

    /**
     * Get ar
     *
     * @return boolean 
     */
    public function getAr()
    {
        return $this->ar;
    }

    /**
     * Set mc
     *
     * @param boolean $mc
     * @return Gestion
     */
    public function setMc($mc)
    {
        $this->mc = $mc;

        return $this;
    }

    /**
     * Get mc
     *
     * @return boolean 
     */
    public function getMc()
    {
        return $this->mc;
    }

    /**
     * Set lx
     *
     * @param boolean $lx
     * @return Gestion
     */
    public function setLx($lx)
    {
        $this->lx = $lx;

        return $this;
    }

    /**
     * Get lx
     *
     * @return boolean 
     */
    public function getLx()
    {
        return $this->lx;
    }

    /**
     * Set propQ
     *
     * @param boolean $propQ
     * @return Gestion
     */
    public function setPropQ($propQ)
    {
        $this->propQ = $propQ;

        return $this;
    }

    /**
     * Get propQ
     *
     * @return boolean 
     */
    public function getPropQ()
    {
        return $this->propQ;
    }

    /**
     * Set signalE
     *
     * @param boolean $signalE
     * @return Gestion
     */
    public function setSignalE($signalE)
    {
        $this->signalE = $signalE;

        return $this;
    }

    /**
     * Get signalE
     *
     * @return boolean 
     */
    public function getSignalE()
    {
        return $this->signalE;
    }

    /**
     * Set inscription
     *
     * @param boolean $inscription
     * @return Gestion
     */
    public function setInscription($inscription)
    {
        $this->inscription = $inscription;

        return $this;
    }

    /**
     * Get inscription
     *
     * @return boolean 
     */
    public function getInscription()
    {
        return $this->inscription;
    }

    /**
     * Set jetons_uniques
     *
     * @param boolean $jetonsUniques
     * @return Gestion
     */
    public function setJetonsUniques($jetonsUniques)
    {
        $this->jetons_uniques = $jetonsUniques;

        return $this;
    }

    /**
     * Get jetons_uniques
     *
     * @return boolean 
     */
    public function getJetonsUniques()
    {
        return $this->jetons_uniques;
    }

    /**
     * Set nbJinit
     *
     * @param integer $nbJinit
     * @return Gestion
     */
    public function setNbJinit($nbJinit)
    {
        $this->nbJinit = $nbJinit;

        return $this;
    }

    /**
     * Get nbJinit
     *
     * @return integer 
     */
    public function getNbJinit()
    {
        return $this->nbJinit;
    }

    /**
     * Set nbJquot
     *
     * @param integer $nbJquot
     * @return Gestion
     */
    public function setNbJquot($nbJquot)
    {
        $this->nbJquot = $nbJquot;

        return $this;
    }

    /**
     * Get nbJquot
     *
     * @return integer 
     */
    public function getNbJquot()
    {
        return $this->nbJquot;
    }
}
