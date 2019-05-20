<?php

namespace mtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comptable
 *
 * @ORM\Table(name="comptable", indexes={@ORM\Index(name="idType", columns={"idType"})})
 * @ORM\Entity
 */
class Comptable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idComptable", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcomptable;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=20, nullable=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=50, nullable=true)
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=15, nullable=false)
     */
    private $nom;

    /**
     * @var \Type
     *
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idType", referencedColumnName="idtype")
     * })
     */
    private $idtype;



    /**
     * Get idcomptable
     *
     * @return integer
     */
    public function getIdcomptable()
    {
        return $this->idcomptable;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return Comptable
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set mdp
     *
     * @param string $mdp
     *
     * @return Comptable
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get mdp
     *
     * @return string
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Comptable
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
     * Set idtype
     *
     * @param \mtBundle\Entity\Type $idtype
     *
     * @return Comptable
     */
    public function setIdtype(\mtBundle\Entity\Type $idtype = null)
    {
        $this->idtype = $idtype;

        return $this;
    }

    /**
     * Get idtype
     *
     * @return \mtBundle\Entity\Type
     */
    public function getIdtype()
    {
        return $this->idtype;
    }
}
