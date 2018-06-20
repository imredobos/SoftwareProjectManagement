<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018. 06. 04.
 * Time: 19:42
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\Worklog;
use AppBundle\Service\interfaces\ITicketCrudService;
use AppBundle\Service\interfaces\IWorklogCrudService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class WorklogController extends Controller
{
    /**
     * @var IWorklogCrudService
     */
    private $worklogService;

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
        $this->worklogService = $container->get('app.worklogService');
        $this->ticketService = $container->get('app.ticketService');
    }

    /**
     * @Route("/workloglist", name="workloglist")
     */
    public function listAction(Request $request, $worklogId)
    {

    }

    /**
     * @Route("/worklogshow/{worklogId}", name="worklogshow")
     */
    public function showAction(Request $request, $worklogId)
    {
        $worklog = $this->worklogService->find($worklogId);
        $twigParams = array();
        $twigParams["worklog"] = $worklog;
        return $this->render('worklog/worklog.html.twig', $twigParams);
    }

    /**
     * @Route("worklogdel/{worklogId}", name="worklogdel")
     * @Security("has_role('ROLE_USER')")
     */
    public function delAction(Request $request, $worklogId)
    {
        $worklog = $this->worklogService->find($worklogId);
        $ticket = $worklog->getWorklogTicket();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') &&
            !($user->getUserId() != $ticket->getTicketAssignee()->getUserId())) {
            throw $this->createAccessDeniedException();
        }
        if ($worklog) {
            $this->worklogService->delete($worklog);
            $this->addFlash('notice', "Worklog deleted");
            return $this->redirectToRoute('ticketshow', ['ticketId' => $ticket->getTicketId()]);
        } else {
            $this->addFlash('notice', "Worklog not found");
            return $this->redirectToRoute('ticketshow', $ticket->getTicketId());
        }
    }

    /**
     * @Route("worklogedit/{worklogId}", name="worklogedit")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, $worklogId)
    {
        $worklog = $this->worklogService->find($worklogId);
        $ticket = $worklog->getWorklogTicket();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') &&
            !($user->getUserId() != $ticket->getTicketAssignee()->getUserId())) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->worklogService->getWorklogForm($worklog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $worklog->setWorklogTicket($ticket);
            $this->worklogService->save($worklog);
            $this->addFlash('notice', 'Worklog edited');
            return $this->redirectToRoute('worklogshow', ['worklogId' => $worklog->getWorklogId()]);
        }
        return $this->render('worklog/worklogedit.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("worklogcreate/{ticketId}", name="worklogcreate")
     * @Security("has_role('ROLE_USER')")
     */
    public function createAction(Request $request, $ticketId)
    {

        $ticket = $this->ticketService->find($ticketId);
        /**
         * @var $user User
         */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') &&
            !($user->getUserId() != $ticket->getTicketAssignee()->getUserId())) {
            throw $this->createAccessDeniedException();
        }

        $worklog = new Worklog();
        $form = $this->worklogService->getWorklogForm($worklog);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $worklog->setWorklogTicket($ticket);
            $this->worklogService->save($worklog);
            $this->addFlash('notice', 'Worklog created');
            return $this->redirectToRoute('ticketshow', ['ticketId'=>$ticketId]);
        }
        return $this->render('worklog/worklogedit.html.twig',
            ["form" => $form->createView()]);
    }
}