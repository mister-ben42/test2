<?php

namespace MDQ\QuestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dom3
 *
 * @ORM\Table(name="dom3")
 * @ORM\Entity(repositoryClass="MDQ\QuestionBundle\Repository\Dom3Repository")
 */
class Dom3
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=75)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="nbQ", type="integer", nullable=true)
     */
    private $nbQ;

    /**
     * @var int
     *
     * @ORM\Column(name="prct1", type="integer", nullable=true)
     */
    private $prct1;

    /**
     * @var int
     *
     * @ORM\Column(name="prct2", type="integer", nullable=true)
     */
    private $prct2;

    /**
     * @var int
     *
     * @ORM\Column(name="prct3", type="integer", nullable=true)
     */
    private $prct3;

    /**
     * @var int
     *
     * @ORM\Column(name="prct4", type="integer", nullable=true)
     */
    private $prct4;

    /**
     * @var int
     *
     * @ORM\Column(name="prct5", type="integer", nullable=true)
     */
    private $prct5;

    /**
     * @var array
     *
     * @ORM\Column(name="dom2", type="array", nullable=true)
     */
    private $dom2;
    

    /**
    * @ORM\ManyToOne(targetEntity="MDQ\QuestionBundle\Entity\Theme")
    * @ORM\JoinColumn(nullable=false)
    */
    private $theme;

    /**
     * @var string
     *
     * @ORM\Column(name="dom1", type="string", length=50)
     */
    private $dom1;


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
     * Set nom
     *
     * @param string $nom
     * @return Dom3
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nbQ
     *
     * @param integer $nbQ
     * @return Dom3
     */
    public function setNbQ($nbQ)
    {
        $this->nbQ = $nbQ;

        return $this;
    }

    /**
     * Get nbQ
     *
     * @return integer 
     */
    public function getNbQ()
    {
        return $this->nbQ;
    }

    /**
     * Set prct1
     *
     * @param integer $prct1
     * @return Dom3
     */
    public function setPrct1($prct1)
    {
        $this->prct1 = $prct1;

        return $this;
    }

    /**
     * Get prct1
     *
     * @return integer 
     */
    public function getPrct1()
    {
        return $this->prct1;
    }

    /**
     * Set prct2
     *
     * @param integer $prct2
     * @return Dom3
     */
    public function setPrct2($prct2)
    {
        $this->prct2 = $prct2;

        return $this;
    }

    /**
     * Get prct2
     *
     * @return integer 
     */
    public function getPrct2()
    {
        return $this->prct2;
    }

    /**
     * Set prct3
     *
     * @param integer $prct3
     * @return Dom3
     */
    public function setPrct3($prct3)
    {
        $this->prct3 = $prct3;

        return $this;
    }

    /**
     * Get prct3
     *
     * @return integer 
     */
    public function getPrct3()
    {
        return $this->prct3;
    }

    /**
     * Set prct4
     *
     * @param integer $prct4
     * @return Dom3
     */
    public function setPrct4($prct4)
    {
        $this->prct4 = $prct4;

        return $this;
    }

    /**
     * Get prct4
     *
     * @return integer 
     */
    public function getPrct4()
    {
        return $this->prct4;
    }

    /**
     * Set prct5
     *
     * @param integer $prct5
     * @return Dom3
     */
    public function setPrct5($prct5)
    {
        $this->prct5 = $prct5;

        return $this;
    }

    /**
     * Get prct5
     *
     * @return integer 
     */
    public function getPrct5()
    {
        return $this->prct5;
    }

    /**
     * Set dom2
     *
     * @param array $dom2
     * @return Dom3
     */
    public function setDom2($dom2)
    {
        $this->dom2 = $dom2;

        return $this;
    }

    /**
     * Get dom2
     *
     * @return array 
     */
    public function getDom2()
    {
        return $this->dom2;
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return Dom3
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
     * Set dom1
     *
     * @param string $dom1
     * @return Dom3
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
}
