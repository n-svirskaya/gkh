<?php
// src/GkhBundle/Entity/User.php

namespace GkhBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
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
     * @ORM\Column(name="private_number", type="string", length=255, unique=true)
     */
    private $privateNumber;

    /**
     * @ORM\OneToOne(targetEntity="PersonalAccount", mappedBy="user")
     */
    private $personalAccount;

    /**
     * @return string
     */
    public function getPrivateNumber()
    {
        return $this->privateNumber;
    }

    /**
     * @param string $privateNumber
     */
    public function setPrivateNumber($privateNumber)
    {
        $this->privateNumber = $privateNumber;
    }

    /**
     * @return mixed
     */
    public function getPersonalAccount()
    {
        return $this->personalAccount;
    }

    /**
     * @param mixed $personalAccount
     */
    public function setPersonalAccount($personalAccount)
    {
        $this->personalAccount = $personalAccount;
    }

}