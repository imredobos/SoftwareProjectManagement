<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ticket;
use AppBundle\Service\interfaces\IProjectCrudService;
use AppBundle\Service\interfaces\ITicketCrudService;
use AppBundle\Service\interfaces\IUserProjectCrudService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class TicketController extends Controller
{
    /**
     * @var ITicketCrudService
     */
    private $ticketService;

    /**
     * @var IProjectCrudService
     */
    private $projectService;

    /**
     * @var IUserProjectCrudService
     */
    private $upService;

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->ticketService = $container->get('app.ticketService');
        $this->projectService = $container->get('app.projectService');
        $this->upService = $container->get('app.userprojectService');
    }

    /**
     * @Route("/ticketlist", name="ticketlist")
     */
    public function listAction(Request $request)
    {
        $tickets = $this->ticketService->findAll();
        $twigParams = array();
        $twigParams["tickets"] = $tickets;
        return $this->render('issue/ticketlist.html.twig', $twigParams);
    }

    /**
     * @Route("/ticketlist/user", name="ticketlistuser")
     */
    public function ticketListUserAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $tickets = $this->ticketService->getTicketsByUser($user);
        $twigParams = array("tickets" => $tickets);
        return $this->render('issue/ticketlist.html.twig', $twigParams);
    }

    /**
     * @Route("/ticketlist/project", name="ticketlistuserproject")
     */
    public function ticketListUserProjectAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $project = $this->projectService->findAllByUser($user);
        $tickets = array();
        foreach ($project as $oneproject) {
            foreach ($oneproject->getProjectTicket() as $oneticket)
                array_push($tickets, $oneticket);
        }
        $twigParams = array("tickets" => $tickets);
        return $this->render('issue/ticketlist.html.twig', $twigParams);
    }

    /**
     * @Route("/ticketshow/{ticketId}", name="ticketshow")
     */
    public function showAction(Request $request, $ticketId)
    {
        $ticket = $this->ticketService->find($ticketId);
        $twigParams = array();
        $twigParams["ticket"] = $ticket;
        $twigParams["worklogs"] = $ticket->getTicketWorklog();
        $twigParams["username"] = $ticket->getTicketAssignee();
        return $this->render('issue/ticket.html.twig', $twigParams);
    }

    /**
     * @Route("ticketdel/{ticketId}", name="ticketdel")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delAction(Request $request, $ticketId)
    {
        /**
         * @var $ticket Ticket
         */
        $ticket = $this->ticketService->find($ticketId);
        $project = $ticket->getTicketProject();
        if ($ticket) {
            $this->ticketService->delete($ticket);

            $this->addFlash('notice', "Ticket deleted");
            return $this->redirectToRoute('projectshow', ['projectId'=>$project->getProjectId()]);
        } else {
            $this->addFlash('notice', "Ticket not found");
            return $this->redirectToRoute('projectlist');
        }
    }

    /**
     * @Route("ticketedit/{ticketId}", name="ticketedit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, $ticketId)
    {
        /**
         * @var $ticket Ticket
         */
        $ticket = $this->ticketService->find($ticketId);
        $project = $ticket->getTicketProject();
        $up = $project->getProjectUserproject();
        $users = $this->upService->findUsersByProject($project);
        $form = $this->ticketService->getTicketEditForm($ticket, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->ticketService->save($ticket);
            $this->addFlash('notice', 'Ticket edited');
            return $this->redirectToRoute('ticketshow', array('ticketId'=>$ticket->getTicketId()));
        }
        return $this->render('issue/ticketedit.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("ticketcreate/{projectId}", name="ticketcreate")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request, $projectId = 0)
    {
        if ($projectId) {
            $project = $this->projectService->find($projectId);
        } else {
            $project = $this->projectService->findAll();
        }
        $ticket = new Ticket();
        $form = $this->ticketService->getTicketCreateForm($ticket, array($project));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->ticketService->save($ticket);
            $this->addFlash('notice', 'Ticket created');
            return $this->redirectToRoute('ticketlist');
        }
        return $this->render('issue/ticketedit.html.twig',
            ["form" => $form->createView()]);
    }
}