<?php

namespace AppBundle\Controller;

use AppBundle\Service\interfaces\IProjectCrudService;
use AppBundle\Service\interfaces\ITicketCrudService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//@Security("has_role('ROLE_USER')")
/**
 *
 */
class DefaultController extends Controller
{
    /**
     * @var IProjectCrudService
     */
    private $projectService;

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
        $this->projectService=$container->get('app.projectService');
        $this->ticketService=$container->get('app.ticketService');
    }


    /**
     * @Route("/", name="dashboard")
     */
    public function dashboardAction(Request $request)
    {
        $projects = $this->projectService->findAll();
        $twigParams = array("projects"=>$projects);
        return $this->render('dashboard.html.twig', $twigParams);
    }
}
