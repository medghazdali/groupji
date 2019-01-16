<?php

namespace GJI\GJIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MemberGroup
 *
 * @ORM\Table(name="MemberGroup")
 * @ORM\Entity(repositoryClass="GJI\GJIBundle\Repository\MemberGroupRepository")
 */
class MemberGroup
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
    *@ORM\ManyToOne(targetEntity="\User\UserBundle\Entity\User")
    *@ORM\JoinColumn(name="User_id",referencedColumnName="id")
    */
    private $User;


    /**
    *@ORM\ManyToOne(targetEntity="\GJI\GJIBundle\Entity\Groupe")
    *@ORM\JoinColumn(name="Groupe_id",referencedColumnName="id", onDelete="CASCADE")
    */
    private $Groupe;

    /**
     * @var string
     *
     * @ORM\Column(name="previlige", type="string", length=5)
     */
    private $previlige;

    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string", length=5)
     */
    private $active;




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
     * Set previlige
     *
     * @param string $previlige
     *
     * @return MemberGroup
     */
    public function setPrevilige($previlige)
    {
        $this->previlige = $previlige;

        return $this;
    }

    /**
     * Get previlige
     *
     * @return string
     */
    public function getPrevilige()
    {
        return $this->previlige;
    }

    /**
     * Set user
     *
     * @param \User\UserBundle\Entity\User $user
     *
     * @return MemberGroup
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
     * Set groupe
     *
     * @param \GJI\GJIBundle\Entity\Groupe $groupe
     *
     * @return MemberGroup
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
     * Set active
     *
     * @param string $active
     *
     * @return MemberGroup
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }
}
