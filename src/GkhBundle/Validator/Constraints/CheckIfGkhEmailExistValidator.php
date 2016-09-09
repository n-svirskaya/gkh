<?php

namespace GkhBundle\Validator\Constraints;

use GkhBundle\Manager\UserManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckIfGkhEmailExistValidator extends ConstraintValidator
{
    /**
     * @var UserManager $userManager
     */
    protected $userManager;

    public function __construct($userManager)
    {
        $this->userManager = $userManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($this->userManager->checkIfUserWithEmailExists($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}