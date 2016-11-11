<?php

namespace MDQ\QuizzBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartieQuizz
 *
 * @ORM\Table(name="partiequizz")
 * @ORM\Entity(repositoryClass="MDQ\QuizzBundle\Entity\PartieQuizzRepository")
 */
class PartieQuizz
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
     * @ORM\Column(name="username", type="string", length=50)
     */
    private $username;
	
	/**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;
	
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;
	
	/**
     * @var boolean
     *
     * @ORM\Column(name="valid", type="boolean")
     */
    private $valid;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q1", type="integer")
     */
    private $q1;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q2", type="integer")
     */
    private $q2;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q3", type="integer")
     */
    private $q3;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q4", type="integer")
     */
    private $q4;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q5", type="integer")
     */
    private $q5;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q6", type="integer", nullable=true)
     */
    private $q6;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q7", type="integer", nullable=true)
     */
    private $q7;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q8", type="integer", nullable=true))
     */
    private $q8;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q9", type="integer", nullable=true))
     */
    private $q9;

    /**
     * @var integer
     *
     * @ORM\Column(name="Q10", type="integer", nullable=true))
     */
    private $q10;
	
	 /**
     * @var integer
     *
     * @ORM\Column(name="nbQjoue", type="integer")
     */
    private $nbQjoue;

    /**
     * @var integer
     *
     * @ORM\Column(name="error", type="integer")
     */
    private $error;
	
	/**
	* @ORM\ManyToOne(targetEntity="MDQ\UserBundle\Entity\User", inversedBy="partiesQuizz")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $user;
	
		
	public function __construct()
		{
		$this->date = new \Datetime(); 
		$this->error = 0;
		$this->nbQjoue=0;
		$this->score=0;	
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
     * Set username
     *
     * @param string $username
     * @return PartieQuizz
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return PartieQuizz
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return PartieQuizz
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }
	
	/**
     * Set valid
     *
     * @param boolean $valid
     * @return PartieQuizz
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
     * Set q1
     *
     * @param integer $q1
     * @return PartieQuizz
     */
    public function setQ1($q1)
    {
        $this->q1 = $q1;

        return $this;
    }

    /**
     * Get q1
     *
     * @return integer 
     */
    public function getQ1()
    {
        return $this->q1;
    }

    /**
     * Set q2
     *
     * @param integer $q2
     * @return PartieQuizz
     */
    public function setQ2($q2)
    {
        $this->q2 = $q2;

        return $this;
    }

    /**
     * Get q2
     *
     * @return integer 
     */
    public function getQ2()
    {
        return $this->q2;
    }

    /**
     * Set q3
     *
     * @param integer $q3
     * @return PartieQuizz
     */
    public function setQ3($q3)
    {
        $this->q3 = $q3;

        return $this;
    }

    /**
     * Get q3
     *
     * @return integer 
     */
    public function getQ3()
    {
        return $this->q3;
    }

    /**
     * Set q4
     *
     * @param integer $q4
     * @return PartieQuizz
     */
    public function setQ4($q4)
    {
        $this->q4 = $q4;

        return $this;
    }

    /**
     * Get q4
     *
     * @return integer 
     */
    public function getQ4()
    {
        return $this->q4;
    }

    /**
     * Set q5
     *
     * @param integer $q5
     * @return PartieQuizz
     */
    public function setQ5($q5)
    {
        $this->q5 = $q5;

        return $this;
    }

    /**
     * Get q5
     *
     * @return integer 
     */
    public function getQ5()
    {
        return $this->q5;
    }

    /**
     * Set q6
     *
     * @param integer $q6
     * @return PartieQuizz
     */
    public function setQ6($q6)
    {
        $this->q6 = $q6;

        return $this;
    }

    /**
     * Get q6
     *
     * @return integer 
     */
    public function getQ6()
    {
        return $this->q6;
    }

    /**
     * Set q7
     *
     * @param integer $q7
     * @return PartieQuizz
     */
    public function setQ7($q7)
    {
        $this->q7 = $q7;

        return $this;
    }

    /**
     * Get q7
     *
     * @return integer 
     */
    public function getQ7()
    {
        return $this->q7;
    }

    /**
     * Set q8
     *
     * @param integer $q8
     * @return PartieQuizz
     */
    public function setQ8($q8)
    {
        $this->q8 = $q8;

        return $this;
    }

    /**
     * Get q8
     *
     * @return integer 
     */
    public function getQ8()
    {
        return $this->q8;
    }

    /**
     * Set q9
     *
     * @param integer $q9
     * @return PartieQuizz
     */
    public function setQ9($q9)
    {
        $this->q9 = $q9;

        return $this;
    }

    /**
     * Get q9
     *
     * @return integer 
     */
    public function getQ9()
    {
        return $this->q9;
    }

    /**
     * Set q10
     *
     * @param integer $q10
     * @return PartieQuizz
     */
    public function setQ10($q10)
    {
        $this->q10 = $q10;

        return $this;
    }

    /**
     * Get q10
     *
     * @return integer 
     */
    public function getQ10()
    {
        return $this->q10;
    }

	/**
     * Set nbQjoue
     *
     * @param integer $nbQjoue
     * @return PartieQuizz
     */
    public function setNbQjoue($nbQjoue)
    {
        $this->nbQjoue = $nbQjoue;

        return $this;
    }

    /**
     * Get nbQjoue
     *
     * @return integer 
     */
    public function getNbQjoue()
    {
        return $this->nbQjoue;
    }

    /**
     * Set error
     *
     * @param integer $error
     * @return PartieQuizz
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return integer 
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set user
     *
     * @param \MDQ\UserBundle\Entity\User $user
     * @return PartieQuizz
     */
    public function setUser(\MDQ\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MDQ\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set type
     *
     * @param string $type
     * @return PartieQuizz
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
