<?php

namespace AppBundle\Service\implementations;

use AppBundle\Entity\Project;
use AppBundle\Service\CrudService;
use AppBundle\Service\interfaces\IProjectCrudService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class ProjectCrudService extends CrudService implements IProjectCrudService
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
        $query = $this->em->createQuery("SELECT count(p) FROM AppBundle:Project p");
        return $query->getResult();
    }

    /**
     * @inheritDoc
     */
    public function delete($projectId)
    {
        if ($this->exists($projectId)) {
            $project = $this->find($projectId);
            $this->em->remove($project);
            $this->em->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function exists($projectId)
    {
        $project = $this->find($projectId);
        return ($project) ? true : false;
    }

    /**
     * @inheritDoc
     */
    public function find($projectId)
    {
        return $this->getRepo()->find($projectId);
    }

    /**
     * @return EntityRepository
     */
    public function getRepo()
    {
        return $this->em->getRepository(Project::class);
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
    public function save($project)
    {
        $this->em->persist($project);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getProjectForm($project)
    {
        // TODO: Implement getProjectForm() method.
    }


}