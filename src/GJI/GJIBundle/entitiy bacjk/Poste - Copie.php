<?php

namespace GJI\GJIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Poste
 *
 * @ORM\Table(name="Poste")
 * @ORM\Entity(repositoryClass="GJI\GJIBundle\Repository\PosteRepository")
 */
class Poste
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;


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
    *@ORM\ManyToOne(targetEntity="\GJI\GJIBundle\Entity\Groupe")
    *@ORM\JoinColumn(name="Groupe_id",referencedColumnName="id", onDelete="CASCADE")
    */
    private $Groupe;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;


    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @var int
     *
     * @ORM\Column(name="NbrComments", type="integer", nullable=true)
     */
    private $NbrComments;


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
     * Set title
     *
     * @param string $title
     *
     * @return Group
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Group
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set cat
     *
     * @param \GJI\GJIBundle\Entity\Cat $cat
     *
     * @return Group
     */
    public function setCat(\GJI\GJIBundle\Entity\Cat $cat = null)
    {
        $this->Cat = $cat;

        return $this;
    }

    /**
     * Get cat
     *
     * @return \GJI\GJIBundle\Entity\Cat
     */
    public function getCat()
    {
        return $this->Cat;
    }



    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents/Poste';
    }

     /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }


    /**
     * Set path
     *
     * @param string $path
     *
     * @return Group
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set user
     *
     * @param \User\UserBundle\Entity\User $user
     *
     * @return Group
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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Group
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
     * @return Poste
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
     * Set nbrComments
     *
     * @param integer $nbrComments
     *
     * @return Poste
     */
    public function setNbrComments($nbrComments)
    {
        $this->NbrComments = $nbrComments;

        return $this;
    }

    /**
     * Get nbrComments
     *
     * @return integer
     */
    public function getNbrComments()
    {
        return $this->NbrComments;
    }
}
