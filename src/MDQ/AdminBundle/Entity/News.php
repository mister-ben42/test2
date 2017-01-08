<?php

namespace MDQ\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="MDQ\AdminBundle\Entity\NewsRepository")
 */
class News
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="text")
     */
    private $texte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreate", type="date")
     */
    private $dateCreate;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=100)
     */
    private $auteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="publication", type="integer")
     */
    private $publication;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="priorite", type="boolean")
     */
	private $priorite;
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
	public function __construct($auteur)
	{
	$this->auteur=$auteur; // Par défaut, la date de 	création est la date d'aujourd'hui

	}
	
    /**
     * Set titre
     *
     * @param string $titre
     * @return News
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set texte
     *
     * @param string $texte
     * @return News
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string 
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return News
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return News
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set publication
     *
     * @param integer $publication
     * @return News
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return integer 
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Set priorite
     *
     * @param boolean $priorite
     * @return News
     */
    public function setPriorite($priorite)
    {
        $this->priorite = $priorite;

        return $this;
    }

    /**
     * Get priorite
     *
     * @return boolean 
     */
    public function getPriorite()
    {
        return $this->priorite;
    }
}
