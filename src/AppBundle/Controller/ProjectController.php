<?php

namespace AppBundle\Controller;

use AppBundle\Service\interfaces\IProjectCrudService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_USER')")
 */
class ProjectController extends Controller
{
    /**
     * @var IProjectCrudService
     */
    private $projectService;

    /**
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->projectService = $container->get('app.projectService');
    }


    /**
     * @Route("/project", name="projectlist")
     */
    public function listAction(Request $request){

    }

    /**
     * @Route("/project/{projectId}, name="projectshow")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction(Request $request, $projectId){

    }

    /**
     * @Route("projectdel/{projectId}", name="projectdel")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delAction(Request $request, $projectId){

    }

    /**
     * @Route("projectedit/{projectId}", name="projectedit")
     */
    public function editAction(Request $request, $projectId=0){

    }
}