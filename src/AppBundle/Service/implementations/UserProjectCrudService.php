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
     * @inheritDoc
     */
    public function count()
    {
        $query = $this->em->createQuery("SELECT count(up) FROM AppBundle:UserProject up");
        return $query->getResult();
    }

    /**
     * @inheritDoc
     */
    public function delete($userprojectId)
    {
        if ($this->exists($userprojectId)) {
            $userproject = $this->find($userprojectId);
            $this->em->remove($userproject);
            $this->em->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function exists($userprojectId)
    {
        $userproject = $this->find($userprojectId);
        return ($userproject) ? true : false;
    }

    /**
     * @inheritDoc
     */
    public function find($userprojectId)
    {
        return $this->getRepo()->find($userprojectId);
    }

    /**
     * @return EntityRepository
     */
    public function getRepo()
    {
        return $this->em->getRepository(UserProject::class);
    }

    /**
     * @inheritDoc
     */
    public function findAll()
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function save($userproject)
    {
        $this->em->persist($userproject);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getUserProjectForm($userproject)
    {
        // TODO: Implement getUserProjectForm() method.
    }
}