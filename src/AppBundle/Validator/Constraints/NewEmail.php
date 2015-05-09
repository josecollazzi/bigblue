<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NewEmail extends Constraint
{
    public $message = 'The email "%string%" already exist.';

    public function validatedBy()
    {
        return 'validator_email_new';
    }
} 