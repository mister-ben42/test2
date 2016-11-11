<?php

namespace MDQ\GeneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DateReference
 *
 * @ORM\Table(name="date_reference")
 * @ORM\Entity(repositoryClass="MDQ\GeneBundle\Entity\DateReferenceRepository")
 */
class DateReference
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
     * @ORM\Column(name="day", type="date")
     */
    private $day;

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="integer")
     */
    private $month;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="week", type="date")
     */
    private $week;

	/**
	* @ORM\OneToOne(targetEntity="MDQ\UserBundle\Entity\ScUser")
	*/
    private $rMDQ;

	/**
	* @ORM\OneToOne(targetEntity="MDQ\UserBundle\Entity\ScUser")
	*/
    private $mMDQ;

    /**
	* @ORM\OneToOne(targetEntity="MDQ\UserBundle\Entity\ScUser")
	*/
    private $sMDQ;
	
	 /**
	* @ORM\OneToOne(targetEntity="MDQ\UserBundle\Entity\ScUser")
	*/
    private $muMDQ;
	
	 /**
	* @ORM\OneToOne(targetEntity="MDQ\UserBundle\Entity\ScUser")
	*/
    private $arMDQ;
	
	 /**
	* @ORM\OneToOne(targetEntity="MDQ\UserBundle\Entity\ScUser")
	*/
    private $lxMDQ;
	
	 /**
	* @ORM\OneToOne(targetEntity="MDQ\UserBundle\Entity\ScUser")
	*/
    private $ffMDQ;

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
     * @return DateReference
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
     * Set month
     *
     * @param integer $month
     * @return DateReference
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer 
     */
    public function getMonth()
    {
        return $this->month;
    }

    

    /**
     * Set rMDQ
     *
     * @param \MDQ\UserBundle\Entity\ScUser $rMDQ
     * @return DateReference
     */
    public function setRMDQ(\MDQ\UserBundle\Entity\ScUser $rMDQ = null)
    {
        $this->rMDQ = $rMDQ;

        return $this;
    }

    /**
     * Get rMDQ
     *
     * @return \MDQ\UserBundle\Entity\ScUser 
     */
    public function getRMDQ()
    {
        return $this->rMDQ;
    }

    /**
     * Set mMDQ
     *
     * @param \MDQ\UserBundle\Entity\ScUser $mMDQ
     * @return DateReference
     */
    public function setMMDQ(\MDQ\UserBundle\Entity\ScUser $mMDQ = null)
    {
        $this->mMDQ = $mMDQ;

        return $this;
    }

    /**
     * Get mMDQ
     *
     * @return \MDQ\UserBundle\Entity\ScUser 
     */
    public function getMMDQ()
    {
        return $this->mMDQ;
    }

    /**
     * Set sMDQ
     *
     * @param \MDQ\UserBundle\Entity\ScUser $sMDQ
     * @return DateReference
     */
    public function setSMDQ(\MDQ\UserBundle\Entity\ScUser $sMDQ = null)
    {
        $this->sMDQ = $sMDQ;

        return $this;
    }

    /**
     * Get sMDQ
     *
     * @return \MDQ\UserBundle\Entity\ScUser 
     */
    public function getSMDQ()
    {
        return $this->sMDQ;
    }

    /**
     * Set week
     *
     * @param \DateTime $week
     * @return DateReference
     */
    public function setWeek($week)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * Get week
     *
     * @return \DateTime 
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * Set muMDQ
     *
     * @param \MDQ\UserBundle\Entity\ScUser $muMDQ
     * @return DateReference
     */
    public function setMuMDQ(\MDQ\UserBundle\Entity\ScUser $muMDQ = null)
    {
        $this->muMDQ = $muMDQ;

        return $this;
    }

    /**
     * Get muMDQ
     *
     * @return \MDQ\UserBundle\Entity\ScUser 
     */
    public function getMuMDQ()
    {
        return $this->muMDQ;
    }

    /**
     * Set arMDQ
     *
     * @param \MDQ\UserBundle\Entity\ScUser $arMDQ
     * @return DateReference
     */
    public function setArMDQ(\MDQ\UserBundle\Entity\ScUser $arMDQ = null)
    {
        $this->arMDQ = $arMDQ;

        return $this;
    }

    /**
     * Get arMDQ
     *
     * @return \MDQ\UserBundle\Entity\ScUser 
     */
    public function getArMDQ()
    {
        return $this->arMDQ;
    }

    /**
     * Set lxMDQ
     *
     * @param \MDQ\UserBundle\Entity\ScUser $lxMDQ
     * @return DateReference
     */
    public function setLxMDQ(\MDQ\UserBundle\Entity\ScUser $lxMDQ = null)
    {
        $this->lxMDQ = $lxMDQ;

        return $this;
    }

    /**
     * Get lxMDQ
     *
     * @return \MDQ\UserBundle\Entity\ScUser 
     */
    public function getLxMDQ()
    {
        return $this->lxMDQ;
    }

    /**
     * Set ffMDQ
     *
     * @param \MDQ\UserBundle\Entity\ScUser $ffMDQ
     * @return DateReference
     */
    public function setFfMDQ(\MDQ\UserBundle\Entity\ScUser $ffMDQ = null)
    {
        $this->ffMDQ = $ffMDQ;

        return $this;
    }

    /**
     * Get ffMDQ
     *
     * @return \MDQ\UserBundle\Entity\ScUser 
     */
    public function getFfMDQ()
    {
        return $this->ffMDQ;
    }
}
