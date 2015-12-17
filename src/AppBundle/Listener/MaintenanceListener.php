<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class MaintenanceListener {

    private $actif;
    private $templatingService;

    function __construct($actif, $templatingService) {
        $this->actif = $actif;
        $this->templatingService = $templatingService;
    }

    private function modeMaintenance(Response $response) {
        $content = $this->templatingService->render('::maintenance.html.twig');
        $response->setContent($content);
        return $response;
    }

    public function onKernelResponse(FilterResponseEvent $event) {
        // teste si requete prinipale ( et non de controleur inclus )
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        if ($this->actif) {
            $response = $this->modeMaintenance($event->getResponse());
            $event->setResponse($response);
        }
        return;
    }

}
