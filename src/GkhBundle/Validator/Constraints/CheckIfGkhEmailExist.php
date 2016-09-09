<?php

namespace GkhBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckIfGkhEmailExist extends Constraint
{
    public $message = 'Пользователь с таким e-mail уже существует';
}