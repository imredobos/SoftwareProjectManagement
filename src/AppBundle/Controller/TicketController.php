<?php

namespace AppBundle\Controller;

use AppBundle\Service\interfaces\ITicketCrudService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_USER')")
 */
class TicketController extends Controller
{
    /**
     * @var ITicketCrudService
     */
    private $ticketService;

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->ticketService = $container->get('app.ticketService');
    }

    /**
     * @Route("/ticket/{ticketId}, name="ticketshow")
     */
    public function showAction(Request $request, $ticketId){

    }

    /**
     * @Route("ticketdel/{ticketId}", name="ticketdel")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delAction(Request $request, $ticketId){

    }

    /**
     * @Route("projectedit/{ticketId}", name="ticketedit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, $ticketId=0){

    }

}