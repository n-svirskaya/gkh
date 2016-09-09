<?php

namespace GkhBundle\Manager;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Util\TokenGenerator;
use Swift_Mailer as Mailer;
use GkhBundle\Entity\User;
use Swift_Message;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Session\Session;
use FOS\UserBundle\Model\UserManager as Manager;
use Symfony\Component\Routing\Router;

class UserManager
{
    /**
     * @var EntityManager $em
     */
    protected $em;

    /**
     * @var Session $session
     */
    protected $session;

    /**
     * @var Manager $fosUserManager
     */
    protected $fosUserManager;

    /**
     * @var Mailer $mailer
     */
    protected $mailer;

    /**
     * @var TwigEngine $templating
     */
    protected $templating;

    /**
     * @var Router $router;
     */
    protected $router;

    /**
     * @var TokenGenerator $tokenGenerator
     */
    protected $tokenGenerator;

    public function __construct($em, $session, $fosUserManager, $mailer, $templating, $router, $tokenGenerator)
    {
        $this->em = $em;
        $this->session = $session;
        $this->fosUserManager = $fosUserManager;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function checkIfUserWithEmailExists($email)
    {
         return is_object($this->em->getRepository('GkhBundle:User')->findOneBy(array('email' => $email)));
    }

    public function createNewUser()
    {
        /** @var User $user */
        $user = $this->fosUserManager->createUser();
        $data = array(
            'name' => $this->session->get('name'),
            'email' => $this->session->get('email'),
            'password' => $this->session->get('password'),
            'gkhNumber' => $this->session->get('gkhNumber'),
            'privateNumber' => $this->session->get('privateNumber'),
        );
        $user->setUsername($data['name']);
        $user->setEmail($data['email']);
        $user->setPlainPassword($data['password']);
        $user->setPrivateNumber($data['privateNumber']);
        $user->setConfirmationToken($this->tokenGenerator->generateToken());

        $this->fosUserManager->updateUser($user);
        $perAcc = $this->em->getRepository('GkhBundle:PersonalAccount')->findOneBy(array('number' => $data['gkhNumber']));
        $perAcc->setUser($user);
        $this->em->flush($perAcc);

        $this->notifyUser($user);
    }

    /**
     * @param User $user
     * @return mixed
     */
    private function notifyUser($user)
    {
        $message = Swift_Message::newInstance()
            ->setSubject('Регистрация')
            ->setFrom('gkh@info.by')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    '@User/Registration/registration_email.html.twig',
                    array(
                        'name' => $user->getUsername(),
                        'url' => $this->router->generate('fos_user_registration_confirm', array(
                            'token' => $user->getConfirmationToken()
                        ), Router::ABSOLUTE_URL),
                    )

                ),
                'text/html'
            )

        ;
        $this->mailer->send($message);
    }
}
