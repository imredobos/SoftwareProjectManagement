<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\UserProject;
use AppBundle\Service\interfaces\IProjectCrudService;
use AppBundle\Service\interfaces\ITicketCrudService;
use AppBundle\Service\interfaces\IUserCrudService;
use AppBundle\Service\interfaces\IUserProjectCrudService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ProjectController extends Controller
{
    /**
     * @var IProjectCrudService
     */
    private $projectService;

    /**
     * @var IUserCrudService
     */
    private $userService;

    /**
     * @var IUserProjectCrudService
     */
    private $userprojectService;

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
        $this->projectService = $container->get('app.projectService');
        $this->userService = $container->get('app.userService');
        $this->userprojectService = $container->get('app.userprojectService');
        $this->ticketService = $container->get('app.ticketService');
    }

    /**
     * @Route("/projectlist", name="projectlist")
     */
    public function listAction(Request $request)
    {
        $projects = $this->projectService->findAll();
        $twigParams = array();
        $twigParams["projects"] = $projects;
        return $this->render('project/projectlist.html.twig', $twigParams);
    }

    /**
     * @Route("/userprojectlist", name="userprojectlist")
     */
    public function userProjectlistAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $projects = $this->projectService->findAllByUser($user);
        $twigParams = array();
        $twigParams["projects"] = $projects;
        return $this->render('project/projectlist.html.twig', $twigParams);
    }

    /**
     * @Route("/projectshow/{projectId}", name="projectshow")
     */
    public function showAction(Request $request, $projectId)
    {
        $project = $this->projectService->find($projectId);
//        $session = new Session();
//        $session->start();
//        $session->set('project', $project);
        $twigParams = array();
        $twigParams["project"] = $project;
        $twigParams["tickets"] = $project->getProjectTicket();
        return $this->render('project/project.html.twig', $twigParams);
    }

    /**
     * @Route("projectdel/{projectId}", name="projectdel")
     */
    public function delAction(Request $request, $projectId)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            throw $this->createAccessDeniedException();
        }

        $project = $this->projectService->find($projectId);
        if ($project){
            $this->userprojectService->deleteByProject($project);
            $tickets = $project->getProjectTicket();
            foreach ($tickets as $ticket) {
                $this->ticketService->delete($ticket);
            }

            $this->projectService->delete($projectId);
            $this->addFlash('notice', "Project deleted");
            return $this->redirectToRoute('projectlist');
        } else{
            $this->addFlash('notice', "Project not found");
            return $this->redirectToRoute('projectlist');
        }
    }

    /**
     * @Route("projectedit/{projectId}", name="projectedit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, $projectId=0)
    {
        $project = $this->projectService->find($projectId);
        $form = $this->projectService->getProjectForm($project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->projectService->save($project);
            $this->addFlash('notice', 'Project edited');
            return $this->redirectToRoute('projectlist');
        }
        return $this->render('project/projectedit.html.twig', ["form"=>$form->createView()]);
    }

    /**
     * @Route("projectnew", name="projectnew")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createAction(Request $request){
        $project = new Project();
        $form = $this->projectService->getProjectForm($project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->projectService->save($project);
            $this->addFlash('notice', 'Project created');
            return $this->redirectToRoute('projectlist');
        }
        return $this->render('project/projectedit.html.twig',
            ["form"=>$form->createView()]);
    }
}