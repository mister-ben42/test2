<?php

namespace MDQ\QuestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QaValider
 *
 * @ORM\Table(name="qavalider")
 * @ORM\Entity(repositoryClass="MDQ\QuestionBundle\Entity\QaValiderRepository")
 */
class QaValider
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
     * @var string
     *
     * @ORM\Column(name="intitule", type="string", length=255)
     */
    private $intitule;

    /**
     * @var string
     *
     * @ORM\Column(name="brep", type="string", length=100)
     */
    private $brep;

    /**
     * @var string
     *
     * @ORM\Column(name="mrep1", type="string", length=100)
     */
    private $mrep1;

    /**
     * @var string
     *
     * @ORM\Column(name="mrep2", type="string", length=100)
     */
    private $mrep2;

    /**
     * @var string
     *
     * @ORM\Column(name="mrep3", type="string", length=100)
     */
    private $mrep3;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=250)
     */
    private $commentaire;
	
    /**
     * @var string
     *
     * @ORM\Column(name="dom1", type="string", length=100)
     */
    private $dom1;

    /**
     * @var integer
     *
     * @ORM\Column(name="diff", type="integer")
     */
    private $diff;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=100)
     */
    private $type;

	/**
     * @var \Date
     *
     * @ORM\Column(name="datecreate", type="date")
     */
    private $datecreate;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="repAdmin", type="integer")
     */
    private $repAdmin;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="retournee", type="boolean")
     */
    private $retournee;
	
	/**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=100)
     */
    private $theme;
	
	/**
     * @var string
     *
     * @ORM\Column(name="dom2", type="string", length=100)
     */
    private $dom2;
	
	/**
     * @var string
     *
     * @ORM\Column(name="dom3", type="string", length=100)
     */
    private $dom3;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="delai", type="integer", nullable=true)
     */
    private $delai;
	
	 /**     
 	 * @ORM\ManyToOne(targetEntity="MDQ\UserBundle\Entity\ScUser", inversedBy="qavaliders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;
	
	public function __construct()
	{
		$this->type = "texte";
		$this->repAdmin = 0;// idée 0:pas traité, 1 à 9 refusé, les cause, 10 à 19 retournée et cause. Si accepté, sera effacée. 
		$this->datecreate = new \Datetime(); // Par défaut, la date de 	création est la date d'aujourd'hui
		$this->theme="none";
		$this->dom2="none";
		$this->dom3="none";
		$this->delai=null;
		$this->retournee=0;
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
     * Set intitule
     *
     * @param string $intitule
     * @return QaValider
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string 
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set brep1
     *
     * @param string $brep1
     * @return QaValider
     */
    public function setBrep1($brep1)
    {
        $this->brep1 = $brep1;

        return $this;
    }

    /**
     * Get brep1
     *
     * @return string 
     */
    public function getBrep1()
    {
        return $this->brep1;
    }

    /**
     * Set mrep1
     *
     * @param string $mrep1
     * @return QaValider
     */
    public function setMrep1($mrep1)
    {
        $this->mrep1 = $mrep1;

        return $this;
    }

    /**
     * Get mrep1
     *
     * @return string 
     */
    public function getMrep1()
    {
        return $this->mrep1;
    }

    /**
     * Set mrep2
     *
     * @param string $mrep2
     * @return QaValider
     */
    public function setMrep2($mrep2)
    {
        $this->mrep2 = $mrep2;

        return $this;
    }

    /**
     * Get mrep2
     *
     * @return string 
     */
    public function getMrep2()
    {
        return $this->mrep2;
    }

    /**
     * Set mrep3
     *
     * @param string $mrep3
     * @return QaValider
     */
    public function setMrep3($mrep3)
    {
        $this->mrep3 = $mrep3;

        return $this;
    }

    /**
     * Get mrep3
     *
     * @return string 
     */
    public function getMrep3()
    {
        return $this->mrep3;
    }

    /**
     * Set dom1
     *
     * @param string $dom1
     * @return QaValider
     */
    public function setDom1($dom1)
    {
        $this->dom1 = $dom1;

        return $this;
    }

    /**
     * Get dom1
     *
     * @return string 
     */
    public function getDom1()
    {
        return $this->dom1;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return QaValider
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set diff
     *
     * @param integer $diff
     * @return QaValider
     */
    public function setDiff($diff)
    {
        $this->diff = $diff;

        return $this;
    }

    /**
     * Get diff
     *
     * @return integer 
     */
    public function getDiff()
    {
        return $this->diff;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return QaValider
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set datecreate
     *
     * @param \DateTime $datecreate
     * @return QaValider
     */
    public function setDatecreate($datecreate)
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    /**
     * Get datecreate
     *
     * @return \DateTime 
     */
    public function getDatecreate()
    {
        return $this->datecreate;
    }

    /**
     * Set valid
     *
     * @param integer $valid
     * @return QaValider
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return integer 
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set auteur
     *
     * @param \MDQ\UserBundle\Entity\ScUser $auteur
     * @return QaValider
     */
    public function setAuteur(\MDQ\UserBundle\Entity\ScUser $auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \MDQ\UserBundle\Entity\ScUser 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set brep
     *
     * @param string $brep
     * @return QaValider
     */
    public function setBrep($brep)
    {
        $this->brep = $brep;

        return $this;
    }

    /**
     * Get brep
     *
     * @return string 
     */
    public function getBrep()
    {
        return $this->brep;
    }

    /**
     * Set repAdmin
     *
     * @param integer $repAdmin
     * @return QaValider
     */
    public function setRepAdmin($repAdmin)
    {
        $this->repAdmin = $repAdmin;

        return $this;
    }

    /**
     * Get repAdmin
     *
     * @return integer 
     */
    public function getRepAdmin()
    {
        return $this->repAdmin;
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return QaValider
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string 
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set dom2
     *
     * @param string $dom2
     * @return QaValider
     */
    public function setDom2($dom2)
    {
        $this->dom2 = $dom2;

        return $this;
    }

    /**
     * Get dom2
     *
     * @return string 
     */
    public function getDom2()
    {
        return $this->dom2;
    }

    /**
     * Set dom3
     *
     * @param string $dom3
     * @return QaValider
     */
    public function setDom3($dom3)
    {
        $this->dom3 = $dom3;

        return $this;
    }

    /**
     * Get dom3
     *
     * @return string 
     */
    public function getDom3()
    {
        return $this->dom3;
    }

    /**
     * Set delai
     *
     * @param integer $delai
     * @return QaValider
     */
    public function setDelai($delai)
    {
        $this->delai = $delai;

        return $this;
    }

    /**
     * Get delai
     *
     * @return integer 
     */
    public function getDelai()
    {
        return $this->delai;
    }

  

    /**
     * Set retournee
     *
     * @param boolean $retournee
     * @return QaValider
     */
    public function setRetournee($retournee)
    {
        $this->retournee = $retournee;

        return $this;
    }

    /**
     * Get retournee
     *
     * @return boolean 
     */
    public function getRetournee()
    {
        return $this->retournee;
    }
}
