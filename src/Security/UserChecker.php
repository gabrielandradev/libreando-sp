<?php

namespace App\Security;

use App\Entity\Usuario as AppUsuario;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUsuario) {
            return;
        }

        if (!$user->esUsuarioActivo()) {
            throw new CustomUserMessageAccountStatusException('Tu cuenta no se encuentra activa actualmente.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUsuario) {
            return;
        }
    }
}