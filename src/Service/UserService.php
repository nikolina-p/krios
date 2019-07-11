<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class UserService
{
    private $userRepository;

    private $passwordEncoder;

    private $security;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        Security $security)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->security = $security;
    }

    public function persist(User $user): void
    {
        $this->userRepository->persist($user);
    }

    public function saveChanges(User $user): void
    {
        $user->setPassword($this->encodePassword($user));
        $this->userRepository->saveChanges();
    }

    public function encodePassword(User $user) : string
    {
        return $this->passwordEncoder->encodePassword($user, $user->getPassword());
    }

    public function changePassword(string $newPassword): void
    {
        /** @var \App\Entity\User $user */
        $user = $this->security->getUser();
        $user->setPassword($newPassword);
        $this->saveChanges($user);
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    public function findById(int $id): object
    {
        return $this->userRepository->findOneBy(array('id' => $id));
    }

    public function newUser(User $user): void
    {
        $user->setPassword($this->encodePassword($user));
        $this->userRepository->persist($user);
    }

    public function deleteUser(User $user)
    {
        $this->userRepository->delete($user);
    }
}
