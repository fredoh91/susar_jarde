<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoginSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        $lastUserEmail = $event->getPassport()->getUser()->getEmail();
        if ($lastUserEmail !== '') {
            $user = $this->em->getRepository(User::class)->findByMail($lastUserEmail);
            dump($user);
            $user->setDateDerniereConnexion(new \DateTime());
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
        ];
    }
}
