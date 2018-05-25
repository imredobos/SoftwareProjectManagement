<?php

namespace AppBundle\Service\implementations;

use AppBundle\Entity\UserProject;
use AppBundle\Service\CrudService;
use AppBundle\Service\interfaces\IUserProjectCrudService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class UserProjectCrudService extends CrudService implements IUserProjectCrudService
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
        return $this->em->getRepository(UserProject::class);
    }
}