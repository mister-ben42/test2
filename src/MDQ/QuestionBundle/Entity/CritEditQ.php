<?php

namespace MDQ\QuestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MDQ\QuestionBundle\Entity\CritEditQaVal;

/**
 * CritEditQ
 *
 * @ORM\Table(name="criteeditq")
 * @ORM\Entity
 */
class CritEditQ extends CritEditQaVal
{

    /**
     * @var boolean
     *
     * @ORM\Column(name="error", type="boolean")
     */
    private $error;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="valid", type="integer")
     */
    private $valid;
	

     /**
     * @var string
     *
     * @ORM\Column(name="game", type="string", length=50)
     */
    private $game;    
 

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=50)
     */
    private $theme;

    /**
     * @var string
     *
     * @ORM\Column(name="dom2", type="string", length=50)
     */
    private $dom2;

    /**
     * @var string
     *
     * @ORM\Column(name="dom3", type="string", length=50)
     */
    private $dom3;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;


    /**
     * Set error
     *
     * @param boolean $error
     *
     * @return CritEditQ
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return boolean
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set valid
     *
     * @param integer $valid
     *
     * @return CritEditQ
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
     * Set game
     *
     * @param string $game
     *
     * @return CritEditQ
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return string
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return CritEditQ
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
     *
     * @return CritEditQ
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
     *
     * @return CritEditQ
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
     * Set type
     *
     * @param string $type
     *
     * @return CritEditQ
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
}

