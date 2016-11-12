<?php

namespace MDQ\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medailles
 *
 * @ORM\Table(name="medailles")
 * @ORM\Entity(repositoryClass="MDQ\UserBundle\Entity\MedaillesRepository")
 */
class Medailles
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
     * @var integer
     *
     * @ORM\Column(name="km1", type="integer")
     */
    private $km1;

    /**
     * @var integer
     *
     * @ORM\Column(name="km2", type="integer")
     */
    private $km2;

    /**
     * @var integer
     *
     * @ORM\Column(name="km3", type="integer")
     */
    private $km3;

    /**
     * @var integer
     *
     * @ORM\Column(name="km4", type="integer")
     */
    private $km4;

    /**
     * @var integer
     *
     * @ORM\Column(name="km5", type="integer")
     */
    private $km5;

    /**
     * @var integer
     *
     * @ORM\Column(name="mq1", type="integer")
     */
    private $mq1;

    /**
     * @var integer
     *
     * @ORM\Column(name="mq2", type="integer")
     */
    private $mq2;

    /**
     * @var integer
     *
     * @ORM\Column(name="mq3", type="integer")
     */
    private $mq3;

    /**
     * @var integer
     *
     * @ORM\Column(name="mq4", type="integer")
     */
    private $mq4;

    /**
     * @var integer
     *
     * @ORM\Column(name="mq5", type="integer")
     */
    private $mq5;

    /**
     * @var integer
     *
     * @ORM\Column(name="tm1", type="integer")
     */
    private $tm1;

    /**
     * @var integer
     *
     * @ORM\Column(name="tm2", type="integer")
     */
    private $tm2;

    /**
     * @var integer
     *
     * @ORM\Column(name="tm3", type="integer")
     */
    private $tm3;

    /**
     * @var integer
     *
     * @ORM\Column(name="tm4", type="integer")
     */
    private $tm4;

    /**
     * @var integer
     *
     * @ORM\Column(name="tm5", type="integer")
     */
    private $tm5;

    /**
     * @var integer
     *
     * @ORM\Column(name="mu1", type="integer")
     */
    private $mu1;

    /**
     * @var integer
     *
     * @ORM\Column(name="mu2", type="integer")
     */
    private $mu2;

    /**
     * @var integer
     *
     * @ORM\Column(name="mu3", type="integer")
     */
    private $mu3;

    /**
     * @var integer
     *
     * @ORM\Column(name="mu4", type="integer")
     */
    private $mu4;

    /**
     * @var integer
     *
     * @ORM\Column(name="mu5", type="integer")
     */
    private $mu5;

    /**
     * @var integer
     *
     * @ORM\Column(name="ar1", type="integer")
     */
    private $ar1;

    /**
     * @var integer
     *
     * @ORM\Column(name="ar2", type="integer")
     */
    private $ar2;

    /**
     * @var integer
     *
     * @ORM\Column(name="ar3", type="integer")
     */
    private $ar3;

    /**
     * @var integer
     *
     * @ORM\Column(name="ar4", type="integer")
     */
    private $ar4;

    /**
     * @var integer
     *
     * @ORM\Column(name="ar5", type="integer")
     */
    private $ar5;

    /**
     * @var integer
     *
     * @ORM\Column(name="ff1", type="integer")
     */
    private $ff1;

    /**
     * @var integer
     *
     * @ORM\Column(name="ff2", type="integer")
     */
    private $ff2;

    /**
     * @var integer
     *
     * @ORM\Column(name="ff3", type="integer")
     */
    private $ff3;

    /**
     * @var integer
     *
     * @ORM\Column(name="ff4", type="integer")
     */
    private $ff4;

    /**
     * @var integer
     *
     * @ORM\Column(name="ff5", type="integer")
     */
    private $ff5;

    /**
     * @var integer
     *
     * @ORM\Column(name="lx1", type="integer")
     */
    private $lx1;

    /**
     * @var integer
     *
     * @ORM\Column(name="lx2", type="integer")
     */
    private $lx2;

    /**
     * @var integer
     *
     * @ORM\Column(name="lx3", type="integer")
     */
    private $lx3;

    /**
     * @var integer
     *
     * @ORM\Column(name="lx4", type="integer")
     */
    private $lx4;

    /**
     * @var integer
     *
     * @ORM\Column(name="lx5", type="integer")
     */
    private $lx5;

    /**
     * @var integer
     *
     * @ORM\Column(name="totMed", type="integer")
     */
    private $totMed;

	public function __construct()
	{
		$this->km1=0;
		$this->km2=0;
		$this->km3=0;
		$this->km4=0;
		$this->km5=0;
		$this->mq1=0;
		$this->mq2=0;
		$this->mq3=0;
		$this->mq4=0;
		$this->mq5=0;
		$this->tm1=0;
		$this->tm2=0;
		$this->tm3=0;
		$this->tm4=0;
		$this->tm5=0;
		$this->mu1=0;
		$this->mu2=0;
		$this->mu3=0;
		$this->mu4=0;
		$this->mu5=0;
		$this->ar1=0;
		$this->ar2=0;
		$this->ar3=0;
		$this->ar4=0;
		$this->ar5=0;
		$this->ff1=0;
		$this->ff2=0;
		$this->ff3=0;
		$this->ff4=0;
		$this->ff5=0;
		$this->lx1=0;
		$this->lx2=0;
		$this->lx3=0;
		$this->lx4=0;
		$this->lx5=0;
		$this->totMed=0;
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
     * Set km1
     *
     * @param integer $km1
     * @return Medailles
     */
    public function setKm1($km1)
    {
        $this->km1 = $km1;

        return $this;
    }

    /**
     * Get km1
     *
     * @return integer 
     */
    public function getKm1()
    {
        return $this->km1;
    }

    /**
     * Set km2
     *
     * @param integer $km2
     * @return Medailles
     */
    public function setKm2($km2)
    {
        $this->km2 = $km2;

        return $this;
    }

    /**
     * Get km2
     *
     * @return integer 
     */
    public function getKm2()
    {
        return $this->km2;
    }

    /**
     * Set km3
     *
     * @param integer $km3
     * @return Medailles
     */
    public function setKm3($km3)
    {
        $this->km3 = $km3;

        return $this;
    }

    /**
     * Get km3
     *
     * @return integer 
     */
    public function getKm3()
    {
        return $this->km3;
    }

    /**
     * Set km4
     *
     * @param integer $km4
     * @return Medailles
     */
    public function setKm4($km4)
    {
        $this->km4 = $km4;

        return $this;
    }

    /**
     * Get km4
     *
     * @return integer 
     */
    public function getKm4()
    {
        return $this->km4;
    }

    /**
     * Set km5
     *
     * @param integer $km5
     * @return Medailles
     */
    public function setKm5($km5)
    {
        $this->km5 = $km5;

        return $this;
    }

    /**
     * Get km5
     *
     * @return integer 
     */
    public function getKm5()
    {
        return $this->km5;
    }

    /**
     * Set mq1
     *
     * @param integer $mq1
     * @return Medailles
     */
    public function setMq1($mq1)
    {
        $this->mq1 = $mq1;

        return $this;
    }

    /**
     * Get mq1
     *
     * @return integer 
     */
    public function getMq1()
    {
        return $this->mq1;
    }

    /**
     * Set mq2
     *
     * @param integer $mq2
     * @return Medailles
     */
    public function setMq2($mq2)
    {
        $this->mq2 = $mq2;

        return $this;
    }

    /**
     * Get mq2
     *
     * @return integer 
     */
    public function getMq2()
    {
        return $this->mq2;
    }

    /**
     * Set mq3
     *
     * @param integer $mq3
     * @return Medailles
     */
    public function setMq3($mq3)
    {
        $this->mq3 = $mq3;

        return $this;
    }

    /**
     * Get mq3
     *
     * @return integer 
     */
    public function getMq3()
    {
        return $this->mq3;
    }

    /**
     * Set mq4
     *
     * @param integer $mq4
     * @return Medailles
     */
    public function setMq4($mq4)
    {
        $this->mq4 = $mq4;

        return $this;
    }

    /**
     * Get mq4
     *
     * @return integer 
     */
    public function getMq4()
    {
        return $this->mq4;
    }

    /**
     * Set mq5
     *
     * @param integer $mq5
     * @return Medailles
     */
    public function setMq5($mq5)
    {
        $this->mq5 = $mq5;

        return $this;
    }

    /**
     * Get mq5
     *
     * @return integer 
     */
    public function getMq5()
    {
        return $this->mq5;
    }

    /**
     * Set tm1
     *
     * @param integer $tm1
     * @return Medailles
     */
    public function setTm1($tm1)
    {
        $this->tm1 = $tm1;

        return $this;
    }

    /**
     * Get tm1
     *
     * @return integer 
     */
    public function getTm1()
    {
        return $this->tm1;
    }

    /**
     * Set tm2
     *
     * @param integer $tm2
     * @return Medailles
     */
    public function setTm2($tm2)
    {
        $this->tm2 = $tm2;

        return $this;
    }

    /**
     * Get tm2
     *
     * @return integer 
     */
    public function getTm2()
    {
        return $this->tm2;
    }

    /**
     * Set tm3
     *
     * @param integer $tm3
     * @return Medailles
     */
    public function setTm3($tm3)
    {
        $this->tm3 = $tm3;

        return $this;
    }

    /**
     * Get tm3
     *
     * @return integer 
     */
    public function getTm3()
    {
        return $this->tm3;
    }

    /**
     * Set tm4
     *
     * @param integer $tm4
     * @return Medailles
     */
    public function setTm4($tm4)
    {
        $this->tm4 = $tm4;

        return $this;
    }

    /**
     * Get tm4
     *
     * @return integer 
     */
    public function getTm4()
    {
        return $this->tm4;
    }

    /**
     * Set tm5
     *
     * @param integer $tm5
     * @return Medailles
     */
    public function setTm5($tm5)
    {
        $this->tm5 = $tm5;

        return $this;
    }

    /**
     * Get tm5
     *
     * @return integer 
     */
    public function getTm5()
    {
        return $this->tm5;
    }

    /**
     * Set mu1
     *
     * @param integer $mu1
     * @return Medailles
     */
    public function setMu1($mu1)
    {
        $this->mu1 = $mu1;

        return $this;
    }

    /**
     * Get mu1
     *
     * @return integer 
     */
    public function getMu1()
    {
        return $this->mu1;
    }

    /**
     * Set mu2
     *
     * @param integer $mu2
     * @return Medailles
     */
    public function setMu2($mu2)
    {
        $this->mu2 = $mu2;

        return $this;
    }

    /**
     * Get mu2
     *
     * @return integer 
     */
    public function getMu2()
    {
        return $this->mu2;
    }

    /**
     * Set mu3
     *
     * @param integer $mu3
     * @return Medailles
     */
    public function setMu3($mu3)
    {
        $this->mu3 = $mu3;

        return $this;
    }

    /**
     * Get mu3
     *
     * @return integer 
     */
    public function getMu3()
    {
        return $this->mu3;
    }

    /**
     * Set mu4
     *
     * @param integer $mu4
     * @return Medailles
     */
    public function setMu4($mu4)
    {
        $this->mu4 = $mu4;

        return $this;
    }

    /**
     * Get mu4
     *
     * @return integer 
     */
    public function getMu4()
    {
        return $this->mu4;
    }

    /**
     * Set mu5
     *
     * @param integer $mu5
     * @return Medailles
     */
    public function setMu5($mu5)
    {
        $this->mu5 = $mu5;

        return $this;
    }

    /**
     * Get mu5
     *
     * @return integer 
     */
    public function getMu5()
    {
        return $this->mu5;
    }

    /**
     * Set ar1
     *
     * @param integer $ar1
     * @return Medailles
     */
    public function setAr1($ar1)
    {
        $this->ar1 = $ar1;

        return $this;
    }

    /**
     * Get ar1
     *
     * @return integer 
     */
    public function getAr1()
    {
        return $this->ar1;
    }

    /**
     * Set ar2
     *
     * @param integer $ar2
     * @return Medailles
     */
    public function setAr2($ar2)
    {
        $this->ar2 = $ar2;

        return $this;
    }

    /**
     * Get ar2
     *
     * @return integer 
     */
    public function getAr2()
    {
        return $this->ar2;
    }

    /**
     * Set ar3
     *
     * @param integer $ar3
     * @return Medailles
     */
    public function setAr3($ar3)
    {
        $this->ar3 = $ar3;

        return $this;
    }

    /**
     * Get ar3
     *
     * @return integer 
     */
    public function getAr3()
    {
        return $this->ar3;
    }

    /**
     * Set ar4
     *
     * @param integer $ar4
     * @return Medailles
     */
    public function setAr4($ar4)
    {
        $this->ar4 = $ar4;

        return $this;
    }

    /**
     * Get ar4
     *
     * @return integer 
     */
    public function getAr4()
    {
        return $this->ar4;
    }

    /**
     * Set ar5
     *
     * @param integer $ar5
     * @return Medailles
     */
    public function setAr5($ar5)
    {
        $this->ar5 = $ar5;

        return $this;
    }

    /**
     * Get ar5
     *
     * @return integer 
     */
    public function getAr5()
    {
        return $this->ar5;
    }

    /**
     * Set ff1
     *
     * @param integer $ff1
     * @return Medailles
     */
    public function setFf1($ff1)
    {
        $this->ff1 = $ff1;

        return $this;
    }

    /**
     * Get ff1
     *
     * @return integer 
     */
    public function getFf1()
    {
        return $this->ff1;
    }

    /**
     * Set ff2
     *
     * @param integer $ff2
     * @return Medailles
     */
    public function setFf2($ff2)
    {
        $this->ff2 = $ff2;

        return $this;
    }

    /**
     * Get ff2
     *
     * @return integer 
     */
    public function getFf2()
    {
        return $this->ff2;
    }

    /**
     * Set ff3
     *
     * @param integer $ff3
     * @return Medailles
     */
    public function setFf3($ff3)
    {
        $this->ff3 = $ff3;

        return $this;
    }

    /**
     * Get ff3
     *
     * @return integer 
     */
    public function getFf3()
    {
        return $this->ff3;
    }

    /**
     * Set ff4
     *
     * @param integer $ff4
     * @return Medailles
     */
    public function setFf4($ff4)
    {
        $this->ff4 = $ff4;

        return $this;
    }

    /**
     * Get ff4
     *
     * @return integer 
     */
    public function getFf4()
    {
        return $this->ff4;
    }

    /**
     * Set ff5
     *
     * @param integer $ff5
     * @return Medailles
     */
    public function setFf5($ff5)
    {
        $this->ff5 = $ff5;

        return $this;
    }

    /**
     * Get ff5
     *
     * @return integer 
     */
    public function getFf5()
    {
        return $this->ff5;
    }

    /**
     * Set lx1
     *
     * @param integer $lx1
     * @return Medailles
     */
    public function setLx1($lx1)
    {
        $this->lx1 = $lx1;

        return $this;
    }

    /**
     * Get lx1
     *
     * @return integer 
     */
    public function getLx1()
    {
        return $this->lx1;
    }

    /**
     * Set lx2
     *
     * @param integer $lx2
     * @return Medailles
     */
    public function setLx2($lx2)
    {
        $this->lx2 = $lx2;

        return $this;
    }

    /**
     * Get lx2
     *
     * @return integer 
     */
    public function getLx2()
    {
        return $this->lx2;
    }

    /**
     * Set lx3
     *
     * @param integer $lx3
     * @return Medailles
     */
    public function setLx3($lx3)
    {
        $this->lx3 = $lx3;

        return $this;
    }

    /**
     * Get lx3
     *
     * @return integer 
     */
    public function getLx3()
    {
        return $this->lx3;
    }

    /**
     * Set lx4
     *
     * @param integer $lx4
     * @return Medailles
     */
    public function setLx4($lx4)
    {
        $this->lx4 = $lx4;

        return $this;
    }

    /**
     * Get lx4
     *
     * @return integer 
     */
    public function getLx4()
    {
        return $this->lx4;
    }

    /**
     * Set lx5
     *
     * @param integer $lx5
     * @return Medailles
     */
    public function setLx5($lx5)
    {
        $this->lx5 = $lx5;

        return $this;
    }

    /**
     * Get lx5
     *
     * @return integer 
     */
    public function getLx5()
    {
        return $this->lx5;
    }

    /**
     * Set totMed
     *
     * @param integer $totMed
     * @return Medailles
     */
    public function setTotMed($totMed)
    {
        $this->totMed = $totMed;

        return $this;
    }

    /**
     * Get totMed
     *
     * @return integer 
     */
    public function getTotMed()
    {
        return $this->totMed;
    }
}
