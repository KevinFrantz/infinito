<?php

namespace Infinito\Attribut;

use Infinito\Entity\UserInterface;

/**
 * @author kevinfrantz
 */
interface UserAttributInterface
{
    /**
     * @var string
     */
    public const USER_ATTRIBUT_NAME = 'user';

    public function setUser(UserInterface $user): void;

    public function getUser(): UserInterface;

    /**
     * @return bool Returns if a user is set
     */
    public function hasUser(): bool;
}
