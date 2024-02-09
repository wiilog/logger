<?php

namespace App\Twig;

use App\Entity\Instance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Twig\Environment as TwigEnvironment;

class TwigGlobalSubscriber {

    #[Required]
    public TwigEnvironment $twig;

    #[Required]
    public EntityManagerInterface $entityManager;

    #[Required]
    public TokenStorageInterface $tokenStorage;

    #[Required]
    public KernelInterface $kernel;

    public function onKernelRequest(): void {
        if ($this->tokenStorage->getToken()?->getUser()) {
            $instanceRepository = $this->entityManager->getRepository(Instance::class);
            $this->twig->addGlobal("__instance_menu", $instanceRepository->findAll());
        }
    }
}