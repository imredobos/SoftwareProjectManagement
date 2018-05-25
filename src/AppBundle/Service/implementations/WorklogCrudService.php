<?php

namespace AppBundle\Service\implementations;

use AppBundle\Entity\Worklog;
use AppBundle\Service\CrudService;
use AppBundle\Service\interfaces\IWorklogCrudService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class WorklogCrudService extends CrudService implements IWorklogCrudService
{
    /**
     * CarCrudService constructor.
     * @param $em EntityManager
     * @param $form FormFactory
     * @param $request Request
     */
    public function __construct(EntityManager $em, FormFactory $form, Request $request)
    {
        parent::__construct($em, $form, $request);
    }

    /**
     * @return EntityRepository
     */
    public function getRepo()
    {
        return $this->em->getRepository(Worklog::class);
    }
}