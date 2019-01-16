<?php

namespace GJI\GJIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * images
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="GJI\GJIBundle\Repository\imagesRepository")
 */
class images
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
     * @ORM\Column(name="image", type="string", length=100)
     */
    private $image;

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
     * Set image
     *
     * @param string $image
     *
     * @return images
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set poste
     *
     * @param \GJI\GJIBundle\Entity\Poste $poste
     *
     * @return images
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
