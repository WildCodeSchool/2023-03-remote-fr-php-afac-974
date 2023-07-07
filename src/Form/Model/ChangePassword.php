<?php

namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ChangePassword
{
    protected $oldPassword;
    protected $password;


    Public function getOldPassword()
    {
        return $this->oldPassword;
    }

    Public function getPassword()
    {
        return $this->password;
    }

    Public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    Public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public static function loadValidatorData(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint(
            'oldPassword',
            new SecurityAssert\UserPassword([
                'message' => 'Wrong value for your current password',
            ])
        );
    }
}
