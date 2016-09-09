<?php

namespace GkhBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ElectronicTreatment
 *
 * @ORM\Table(name="electronic_treatment")
 * @ORM\Entity(repositoryClass="GkhBundle\Repository\ElectronicTreatmentRepository")
 */
class ElectronicTreatment
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
     * @ORM\Column(name="place", type="string", length=255)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="fio", type="string", length=255)
     */
    private $fio;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="string", length=255)
     */
    private $answer;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="doc", type="string", length=255, nullable=true)
     */
    private $doc;


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
     * Set place
     *
     * @param string $place
     * @return ElectronicTreatment
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set fio
     *
     * @param string $fio
     * @return ElectronicTreatment
     */
    public function setFio($fio)
    {
        $this->fio = $fio;

        return $this;
    }

    /**
     * Get fio
     *
     * @return string 
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return ElectronicTreatment
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
     * Set phone
     *
     * @param string $phone
     * @return ElectronicTreatment
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return ElectronicTreatment
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return ElectronicTreatment
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return ElectronicTreatment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set doc
     *
     * @param string $doc
     * @return ElectronicTreatment
     */
    public function setDoc($doc)
    {
        $this->doc = $doc;

        return $this;
    }

    /**
     * Get doc
     *
     * @return string 
     */
    public function getDoc()
    {
        return $this->doc;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'gkh/uploads';
    }

    /**
     * @ORM\PrePersist()
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getDoc()) {
            return;
        }
        /** @var UploadedFile $fPicture */
        $fPicture = $this->getDoc();
        $dirPath = $this->getUploadRootDir();
        $picture = $fPicture->getClientOriginalName();
        $ext = $fPicture->guessExtension();
        $name = substr($picture, 0, - strlen($ext));
        $i = 1;

        while(file_exists($dirPath . '/' .  $picture)) {
            $picture = $name . '-' . $i .'.'. $ext;
            $i++;
        }

        $fPicture->move($dirPath, $picture);
        $this->doc = $picture;

    }
}
