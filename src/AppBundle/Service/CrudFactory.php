<?php

namespace AppBundle\Service;

use AppBundle\Service\implementations\ProjectCrudService;
use AppBundle\Service\implementations\TicketCrudService;
use AppBundle\Service\implementations\UserCrudService;
use AppBundle\Service\implementations\UserProjectCrudService;
use AppBundle\Service\implementations\WorklogCrudService;
use AppBundle\Service\interfaces\IProjectCrudService;
use AppBundle\Service\interfaces\ITicketCrudService;
use AppBundle\Service\interfaces\IUserCrudService;
use AppBundle\Service\interfaces\IUserProjectCrudService;
use AppBundle\Service\interfaces\IWorklogCrudService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CrudFactory
{
    /** @var EntityManager */
    private $em;
    /** @var  FormFactory */
    private $formFactory;
    /** @var  Request */
    private $request;

    /**
     * CrudFactory constructor.
     * @param $em EntityManager
     * @param $form FormFactory
     * @param $requestStack RequestStack
     */
    public function __construct($em, $form, $requestStack)
    {
        $this->em = $em;
        $this->formFactory = $form;
        $this->request = $requestStack->getCurrentRequest();
        // Request::createFromGlobals()
    }

    /**
     * @return IProjectCrudService
     */
    public function getProjectService()
    {
        return new ProjectCrudService($this->em, $this->formFactory, $this->request);
    }

    /**
     * @return ITicketCrudService
     */
    public function getTicketService()
    {
        return new TicketCrudService($this->em, $this->formFactory, $this->request);
    }

    /**
     * @return IUserCrudService
     */
    public function getUserService()
    {
        return new UserCrudService($this->em, $this->formFactory, $this->request);
    }

    /**
     * @return IUserProjectCrudService
     */
    public function getUserProjectService()
    {
        return new UserProjectCrudService($this->em, $this->formFactory, $this->request);
    }

    /**
     * @return IWorklogCrudService
     */
    public function getWorklogService()
    {
        return new WorklogCrudService($this->em, $this->formFactory, $this->request);
    }
}