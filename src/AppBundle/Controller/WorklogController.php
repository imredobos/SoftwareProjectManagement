<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018. 06. 04.
 * Time: 19:42
 */

namespace AppBundle\Controller;


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
     * @inheritDoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->worklogService = $container->get('app.worklogService');
    }

    /**
     * @Route("/workloglist", name="workloglist")
     */
    public function listAction(Request $request, $worklogId){

    }

    /**
     * @Route("/worklogshow/{worklogId}", name="worklogshow")
     */
    public function showAction(Request $request, $worklogId){

    }

    /**
     * @Route("worklogdel/{worklogId}", name="worklogdel")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delAction(Request $request, $ticketId){

    }

    /**
     * @Route("worklogedit/{worklogId}", name="worklogedit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, $worklogId=0){

    }
}