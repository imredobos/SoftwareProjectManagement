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
     * @inheritDoc
     */
    public function count()
    {
        $query = $this->em->createQuery("SELECT count(w) FROM AppBundle:Worklog w");
        return $query->getResult();
    }

    /**
     * @inheritDoc
     */
    public function delete($worklogId)
    {
        if ($this->exists($worklogId)) {
            $worklog = $this->find($worklogId);
            $this->em->remove($worklog);
            $this->em->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function exists($worklogId)
    {
        $project = $this->find($worklogId);
        return ($project) ? true : false;
    }

    /**
     * @inheritDoc
     */
    public function find($worklogId)
    {
        return $this->getRepo()->find($worklogId);
    }

    /**
     * @return EntityRepository
     */
    public function getRepo()
    {
        return $this->em->getRepository(Worklog::class);
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
    public function save($worklog)
    {
        $this->em->persist($worklog);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getWorklogForm($worklog)
    {
        // TODO: Implement getWorklogForm() method.
    }
}