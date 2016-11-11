<?php

namespace MDQ\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CritEditU
 *
 * @ORM\Table(name="crit_edit_u")
 * @ORM\Entity(repositoryClass="MDQ\UserBundle\Repository\CritEditURepository")
 */
class CritEditU
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
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="compte", type="integer")
     */
    private $compte;

    /**
     * @var int
     *
     * @ORM\Column(name="sexe", type="integer")
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="departement", type="string", length=50)
     */
    private $departement;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var int
     *
     * @ORM\Column(name="last_login", type="integer")
     */
    private $lastLogin;
    
    /**
     * @var int
     *
     * @ORM\Column(name="role", type="integer")
     */
    private $role;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nbP", type="integer")
     */
    private $nbP;

    /**
     * @var string
     *
     * @ORM\Column(name="triUser", type="string", length=50)
     */
    private $triUser;

    /**
     * @var string
     *
     * @ORM\Column(name="triStats", type="string", length=50)
     */
    private $triStats;
    
    /**
     * @var string
     *
     * @ORM\Column(name="sens", type="string", length=50)
     */
    private $sens;

    /**
     * @var int
     *
     * @ORM\Column(name="nbdeU", type="integer")
     */
    private $nbdeU;

    /**
     * @var int
     *
     * @ORM\Column(name="nbmin", type="integer")
     */
    private $nbmin;


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
     * Set type
     *
     * @param integer $type
     * @return CritEditU
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set compte
     *
     * @param integer $compte
     * @return CritEditU
     */
    public function setCompte($compte)
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * Get compte
     *
     * @return integer 
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set sexe
     *
     * @param integer $sexe
     * @return CritEditU
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return integer 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set departement
     *
     * @param string $departement
     * @return CritEditU
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
     * Set age
     *
     * @param integer $age
     * @return CritEditU
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set lastLogin
     *
     * @param integer $lastLogin
     * @return CritEditU
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return integer 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set nbP
     *
     * @param integer $nbP
     * @return CritEditU
     */
    public function setNbP($nbP)
    {
        $this->nbP = $nbP;

        return $this;
    }

    /**
     * Get nbP
     *
     * @return integer 
     */
    public function getNbP()
    {
        return $this->nbP;
    }

    /**
     * Set triUser
     *
     * @param string $triUser
     * @return CritEditU
     */
    public function setTriUser($triUser)
    {
        $this->triUser = $triUser;

        return $this;
    }

    /**
     * Get triUser
     *
     * @return string 
     */
    public function getTriUser()
    {
        return $this->triUser;
    }

    /**
     * Set triStats
     *
     * @param string $triStats
     * @return CritEditU
     */
    public function setTriStats($triStats)
    {
        $this->triStats = $triStats;

        return $this;
    }

    /**
     * Get triStats
     *
     * @return string 
     */
    public function getTriStats()
    {
        return $this->triStats;
    }

    /**
     * Set nbdeU
     *
     * @param integer $nbdeU
     * @return CritEditU
     */
    public function setNbdeU($nbdeU)
    {
        $this->nbdeU = $nbdeU;

        return $this;
    }

    /**
     * Get nbdeU
     *
     * @return integer 
     */
    public function getNbdeU()
    {
        return $this->nbdeU;
    }

    /**
     * Set nbmin
     *
     * @param integer $nbmin
     * @return CritEditU
     */
    public function setNbmin($nbmin)
    {
        $this->nbmin = $nbmin;

        return $this;
    }

    /**
     * Get nbmin
     *
     * @return integer 
     */
    public function getNbmin()
    {
        return $this->nbmin;
    }

    /**
     * Set sens
     *
     * @param string $sens
     * @return CritEditU
     */
    public function setSens($sens)
    {
        $this->sens = $sens;

        return $this;
    }

    /**
     * Get sens
     *
     * @return string 
     */
    public function getSens()
    {
        return $this->sens;
    }

    /**
     * Set role
     *
     * @param integer $role
     * @return CritEditU
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return integer 
     */
    public function getRole()
    {
        return $this->role;
    }
}
