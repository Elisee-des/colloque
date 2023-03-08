<?php

namespace App\EventSubscriber;

use App\Entity\HistoriqueConnexion;
use App\Repository\HistoriqueConnexionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    private HistoriqueConnexionRepository $historiqueConnexion;
    private RequestStack $request;

    public function __construct(HistoriqueConnexionRepository $historiqueConnexionRepository, RequestStack $requestStack)
    {
        $this->historiqueConnexion = $historiqueConnexionRepository;
        $this->request = $requestStack;
    }

    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        /**
         * @var User
         */

        $user = $event->getAuthenticationToken()->getUser();
        // $url = $this->request->getCurrentRequest()->server->get('PATH_INFO');
        $ip = $this->request->getCurrentRequest()->getClientIp();

        $historique = new HistoriqueConnexion();

        $historique->setNom($user->getNom())
            ->setEmail($user->getEmail())
            // ->setUrl($url)
            ->setIp($ip)
            ->setDateConnxion(new DateTime())
            ;
                
            $this->historiqueConnexion->save($historique, true);
        // $em->persist($historique);
        // $em->flush();

    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
