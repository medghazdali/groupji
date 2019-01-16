<?php

namespace User\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

 
    /**
     * @var string
     *
     * @ORM\Column(name="Fname", type="string", length=100)
     */
    private $Fname;

    /**
     * @var string
     *
     * @ORM\Column(name="Lname", type="string", length=100)
     */
    private $Lname;

    /**
     * @var string
     *
     * @ORM\Column(name="Country", type="string", length=100, nullable=true))
     */
    private $Country;

    /**
     * @var string
     *
     * @ORM\Column(name="Countrie", type="string", length=100, nullable=true))
     */
    private $Countrie;

    /**
     * @var string
     *
     * @ORM\Column(name="passReserve", type="string", length=50, nullable=true))
     */
    private $passReserve;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;


    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=100, nullable=true)
     */
    private $address;


    /**
     * @var string
     *
     * @ORM\Column(name="DateofbirthY", type="string", length=10, nullable=true)
     */
    private $DateofbirthY;


    /**
     * @var string
     *
     * @ORM\Column(name="DateofbirthM", type="string", length=10, nullable=true)
     */
    private $DateofbirthM;


    /**
     * @var string
     *
     * @ORM\Column(name="DateofbirthD", type="string", length=10, nullable=true)
     */
    private $DateofbirthD;    


    /**
     * @var string
     *
     * @ORM\Column(name="AnniversaryDateM", type="string", length=100, nullable=true)
     */
    private $AnniversaryDateM;

    /**
     * @var string
     *
     * @ORM\Column(name="AnniversaryDateD", type="string", length=100, nullable=true)
     */
    private $AnniversaryDateD;


    /**
     * @var string
     *
     * @ORM\Column(name="City", type="string", length=100, nullable=true)
     */
    private $City;




    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=200, nullable=true)
     */
    private $facebook;


    /**
     * @var string
     *
     * @ORM\Column(name="Twitter", type="string", length=200, nullable=true)
     */
    private $Twitter;


    /**
     * @var string
     *
     * @ORM\Column(name="Linkedin", type="string", length=200, nullable=true)
     */
    private $Linkedin;


    /**
     * @var string
     *
     * @ORM\Column(name="Google", type="string", length=200, nullable=true)
     */
    private $Google;


    /**
     * @var string
     *
     * @ORM\Column(name="Skype ", type="string", length=200, nullable=true)
     */
    private $Skype ;


    /**
     * @var string
     *
     * @ORM\Column(name="About", type="string", length=500, nullable=true)
     */
    private $About;




    /**
     * Set fname
     *
     * @param string $fname
     *
     * @return User
     */
    public function setFname($fname)
    {
        $this->Fname = $fname;

        return $this;
    }

    /**
     * Get fname
     *
     * @return string
     */
    public function getFname()
    {
        return $this->Fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     *
     * @return User
     */
    public function setLname($lname)
    {
        $this->Lname = $lname;

        return $this;
    }

    /**
     * Get lname
     *
     * @return string
     */
    public function getLname()
    {
        return $this->Lname;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->Country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->Country;
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
        return 'uploads/users/';
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
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set dateofbirth
     *
     * @param string $dateofbirth
     *
     * @return User
     */
    public function setDateofbirth($dateofbirth)
    {
        $this->Dateofbirth = $dateofbirth;

        return $this;
    }

    /**
     * Get dateofbirth
     *
     * @return string
     */
    public function getDateofbirth()
    {
        return $this->Dateofbirth;
    }

    /**
     * Set anniversaryDate
     *
     * @param string $anniversaryDate
     *
     * @return User
     */
    public function setAnniversaryDate($anniversaryDate)
    {
        $this->AnniversaryDate = $anniversaryDate;

        return $this;
    }

    /**
     * Get anniversaryDate
     *
     * @return string
     */
    public function getAnniversaryDate()
    {
        return $this->AnniversaryDate;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->City = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->Twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->Twitter;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     *
     * @return User
     */
    public function setLinkedin($linkedin)
    {
        $this->Linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->Linkedin;
    }

    /**
     * Set google
     *
     * @param string $google
     *
     * @return User
     */
    public function setGoogle($google)
    {
        $this->Google = $google;

        return $this;
    }

    /**
     * Get google
     *
     * @return string
     */
    public function getGoogle()
    {
        return $this->Google;
    }

    /**
     * Set skype
     *
     * @param string $skype
     *
     * @return User
     */
    public function setSkype($skype)
    {
        $this->Skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string
     */
    public function getSkype()
    {
        return $this->Skype;
    }

    /**
     * Set about
     *
     * @param string $about
     *
     * @return User
     */
    public function setAbout($about)
    {
        $this->About = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->About;
    }

    /**
     * Set dateofbirthY
     *
     * @param string $dateofbirthY
     *
     * @return User
     */
    public function setDateofbirthY($dateofbirthY)
    {
        $this->DateofbirthY = $dateofbirthY;

        return $this;
    }

    /**
     * Get dateofbirthY
     *
     * @return string
     */
    public function getDateofbirthY()
    {
        return $this->DateofbirthY;
    }

    /**
     * Set dateofbirthM
     *
     * @param string $dateofbirthM
     *
     * @return User
     */
    public function setDateofbirthM($dateofbirthM)
    {
        $this->DateofbirthM = $dateofbirthM;

        return $this;
    }

    /**
     * Get dateofbirthM
     *
     * @return string
     */
    public function getDateofbirthM()
    {
        return $this->DateofbirthM;
    }

    /**
     * Set dateofbirthD
     *
     * @param string $dateofbirthD
     *
     * @return User
     */
    public function setDateofbirthD($dateofbirthD)
    {
        $this->DateofbirthD = $dateofbirthD;

        return $this;
    }

    /**
     * Get dateofbirthD
     *
     * @return string
     */
    public function getDateofbirthD()
    {
        return $this->DateofbirthD;
    }

    /**
     * Set anniversaryDateM
     *
     * @param string $anniversaryDateM
     *
     * @return User
     */
    public function setAnniversaryDateM($anniversaryDateM)
    {
        $this->AnniversaryDateM = $anniversaryDateM;

        return $this;
    }

    /**
     * Get anniversaryDateM
     *
     * @return string
     */
    public function getAnniversaryDateM()
    {
        return $this->AnniversaryDateM;
    }

    /**
     * Set anniversaryDateD
     *
     * @param string $anniversaryDateD
     *
     * @return User
     */
    public function setAnniversaryDateD($anniversaryDateD)
    {
        $this->AnniversaryDateD = $anniversaryDateD;

        return $this;
    }

    /**
     * Get anniversaryDateD
     *
     * @return string
     */
    public function getAnniversaryDateD()
    {
        return $this->AnniversaryDateD;
    }

    /**
     * Set countrie
     *
     * @param string $countrie
     *
     * @return User
     */
    public function setCountrie($countrie)
    {
        $this->Countrie = $countrie;

        return $this;
    }

    /**
     * Get countrie
     *
     * @return string
     */
    public function getCountrie()
    {
        return $this->Countrie;
    }

    /**
     * Set passReserve
     *
     * @param string $passReserve
     *
     * @return User
     */
    public function setPassReserve($passReserve)
    {
        $this->passReserve = $passReserve;

        return $this;
    }

    /**
     * Get passReserve
     *
     * @return string
     */
    public function getPassReserve()
    {
        return $this->passReserve;
    }
}
