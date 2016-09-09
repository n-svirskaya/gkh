<?php

namespace GkhBundle\Validator\Constraints;

use GkhBundle\Manager\PersonalAccountManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckIfGkhNumberExistValidator extends ConstraintValidator
{
    /**
     * @var PersonalAccountManager $personalAccountManager
     */
    protected $personalAccountManager;

    public function __construct($personalAccountManager)
    {
        $this->personalAccountManager = $personalAccountManager;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$this->personalAccountManager->checkIfGkhNumberExists($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}