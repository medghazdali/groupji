<?php

namespace GJI\GJIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Groupe_User
 *
 * @ORM\Table(name="Groupe_User")
 * @ORM\Entity(repositoryClass="GJI\GJIBundle\Repository\Groupe_UserRepository")
 */
class Groupe_User
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
    *@ORM\ManyToOne(targetEntity="\GJI\GJIBundle\Entity\Groupe")
    *@ORM\JoinColumn(name="Groupe_id",referencedColumnName="id", onDelete="CASCADE")
    */
    private $Groupe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
    *@ORM\ManyToOne(targetEntity="\User\UserBundle\Entity\User")
    *@ORM\JoinColumn(name="User_id",referencedColumnName="id")
    */
    private $User;

    /**
    *@ORM\ManyToOne(targetEntity="\User\UserBundle\Entity\User")
    *@ORM\JoinColumn(name="UserP_id",referencedColumnName="id")
    */
    private $UserP;




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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Groupe_User
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set groupe
     *
     * @param \GJI\GJIBundle\Entity\Groupe $groupe
     *
     * @return Groupe_User
     */
    public function setGroupe(\GJI\GJIBundle\Entity\Groupe $groupe = null)
    {
        $this->Groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \GJI\GJIBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->Groupe;
    }

    /**
     * Set user
     *
     * @param \User\UserBundle\Entity\User $user
     *
     * @return Groupe_User
     */
    public function setUser(\User\UserBundle\Entity\User $user = null)
    {
        $this->User = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * Set userP
     *
     * @param \User\UserBundle\Entity\User $userP
     *
     * @return Groupe_User
     */
    public function setUserP(\User\UserBundle\Entity\User $userP = null)
    {
        $this->UserP = $userP;

        return $this;
    }

    /**
     * Get userP
     *
     * @return \User\UserBundle\Entity\User
     */
    public function getUserP()
    {
        return $this->UserP;
    }
}
