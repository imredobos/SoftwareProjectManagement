<?php

namespace AppBundle\Service\implementations;

use AppBundle\Entity\Project;
use AppBundle\Service\CrudService;
use AppBundle\Service\interfaces\IProjectCrudService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $project = $this->find($projectId);
        $this->em->remove($project);
        $this->em->flush();
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
    public function exists($projectId)
    {
        $project = $this->find($projectId);
        return ($project) ? true : false;
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
        $form = $this->formFactory->createBuilder(FormType::class, $project);
        $form->add("project_name", TextType::class);
        $form->add("project_enddate", DateType::class);
        $form->add("project_active", ChoiceType::class, [
            'choices' => array("YES" => true, "NO" => false)
        ]);
        $form->add("SAVE", SubmitType::class);
        return $form->getForm();
    }

    /**
     * @inheritDoc
     */
    public function findAllByUser($user)
    {
        $query = $this->em->createQuery("
            SELECT p from AppBundle:Project p 
            JOIN p.project_userproject u WHERE u.userproject_user = :userId
        ");
        $query->setParameter("userId", $user->getUserId());
        return $query->getResult();
    }


}