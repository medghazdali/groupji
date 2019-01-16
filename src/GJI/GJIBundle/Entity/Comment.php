<?php

namespace GJI\GJIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Comment
 *
 * @ORM\Table(name="Comment")
 * @ORM\Entity(repositoryClass="GJI\GJIBundle\Repository\CommentRepository")
 */
class Comment
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
     * @var string
     *
     * @ORM\Column(name="Comment", type="string", length=500)
     */
    private $Comment;


    /**
    *@ORM\ManyToOne(targetEntity="\GJI\GJIBundle\Entity\Poste")
    *@ORM\JoinColumn(name="Poste_id",referencedColumnName="id", onDelete="CASCADE")
    */
    private $Poste;



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
     * @return Comment
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->Comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->Comment;
    }

    /**
     * Set user
     *
     * @param \User\UserBundle\Entity\User $user
     *
     * @return Comment
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
     * Set poste
     *
     * @param \GJI\GJIBundle\Entity\Poste $poste
     *
     * @return Comment
     */
    public function setPoste(\GJI\GJIBundle\Entity\Poste $poste = null)
    {
        $this->Poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return \GJI\GJIBundle\Entity\Poste
     */
    public function getPoste()
    {
        return $this->Poste;
    }
}
