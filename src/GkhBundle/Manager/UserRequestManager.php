<?php

namespace GkhBundle\Manager;

use Doctrine\ORM\EntityManager;
use GkhBundle\Entity\UserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserRequestManager
{
    /**
     * @var EntityManager $em
     */
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function writeEmailRequest($email)
    {
        $userRequest = new UserRequest;
        $userRequest->setEmail($email);

        $this->em->persist($userRequest);
        $this->em->flush();

        return $userRequest->getId();
    }
}
