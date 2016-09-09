<?php

namespace GkhBundle\Manager;

use Doctrine\ORM\EntityManager;

class PersonalAccountManager
{
    /**
     * @var EntityManager $em
     */
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function checkIfGkhNumberExists($number)
    {
        return is_object($this->em->getRepository('GkhBundle:PersonalAccount')->findOneBy(array('number' => $number)));
    }
}
