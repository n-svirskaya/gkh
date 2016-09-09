<?php

namespace GkhBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckIfGkhNumberExist extends Constraint
{
    public $message = 'error_gkh_number';
}