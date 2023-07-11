<?php

namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ChangePassword
{
    public string $oldPassword;
    public string $password;


    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public static function loadValidatorData(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint(
            'oldPassword',
            new SecurityAssert\UserPassword([
                'message' => ' Wrong value for your current password',
            ])
        );
    }
}
