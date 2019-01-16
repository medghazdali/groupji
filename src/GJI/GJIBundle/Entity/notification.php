<?php

namespace GJI\GJIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="GJI\GJIBundle\Repository\notificationRepository")
 */
class notification
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
     * @var int
     *
     * @ORM\Column(name="idPostOrGroupOrComment", type="integer")
     */
    private $idPostOrGroupOrComment;


    /**
    *@ORM\ManyToOne(targetEntity="\GJI\GJIBundle\Entity\Groupe")
    *@ORM\JoinColumn(name="Groupe_id",referencedColumnName="id", onDelete="CASCADE")
    */
    private $Groupe;
    
    /**
     * @var int
     *
     * @ORM\Column(name="isread", type="integer")
     */
    private $isread;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;


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
     * @return notification
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
     * Set idPostOrGroup
     *
     * @param integer $idPostOrGroup
     *
     * @return notification
     */
    public function setIdPostOrGroup($idPostOrGroup)
    {
        $this->idPostOrGroup = $idPostOrGroup;

        return $this;
    }

    /**
     * Get idPostOrGroup
     *
     * @return integer
     */
    public function getIdPostOrGroup()
    {
        return $this->idPostOrGroup;
    }

    /**
     * Set isread
     *
     * @param integer $isread
     *
     * @return notification
     */
    public function setIsread($isread)
    {
        $this->isread = $isread;

        return $this;
    }

    /**
     * Get isread
     *
     * @return integer
     */
    public function getIsread()
    {
        return $this->isread;
    }

    /**
     * Set user
     *
     * @param \User\UserBundle\Entity\User $user
     *
     * @return notification
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
     * @return notification
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

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return notification
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
     * Set idPostOrGroupOrComment
     *
     * @param integer $idPostOrGroupOrComment
     *
     * @return notification
     */
    public function setIdPostOrGroupOrComment($idPostOrGroupOrComment)
    {
        $this->idPostOrGroupOrComment = $idPostOrGroupOrComment;

        return $this;
    }

    /**
     * Get idPostOrGroupOrComment
     *
     * @return integer
     */
    public function getIdPostOrGroupOrComment()
    {
        return $this->idPostOrGroupOrComment;
    }

    /**
     * Set groupe
     *
     * @param \GJI\GJIBundle\Entity\Groupe $groupe
     *
     * @return notification
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
}
