<?php

namespace AppBundle\Service\implementations;

use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use AppBundle\Entity\UserProject;
use AppBundle\Service\CrudService;
use AppBundle\Service\interfaces\IUserProjectCrudService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @inheritDoc
     */
    public function findUsersByProject($project)
    {
        /**
         * $ups UserProject
         */
        $query = $this->em->createQuery("
            SELECT u 
            FROM AppBundle:UserProject u
            WHERE u.userproject_project = :id
            ");
        $query->setParameter("id", $project->getProjectId());
        $list = $query->getResult();
        $users = array();
        foreach ($list as $item){
            /**
             * @var $item UserProject
             */
            array_push($users,$item->getUserprojectUser());
        }
        return $users;
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
    public function getUserProjectForm($userproject, $users)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $userproject);

        $form->add("userproject_user", EntityType::class, array(
            'class'=>User::class,
            'choices'=>$users,
            'choice_label' => function($user, $key, $value) {
                /**
                 * @var $user User
                 */
                return strtoupper($user->getUsername());
            }
        ));
        $form->add("Save", SubmitType::class);
        return $form->getForm();
    }

    /**
     * @inheritDoc
     */
    public function deleteByUser($userId)
    {
        /**
         * @var $items UserProject[]
         */
        $items = $this->getRepo()->findBy(["userproject_user"=>$userId]);
        /**
         * @var $val UserProject
         */
        foreach ($items as $val){
            $this->em->remove($val);
        }
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function deleteByProject($projectId)
    {
        /**
         * @var $items UserProject[]
         */
        $items = $this->getRepo()->findBy(["userproject_project"=>$projectId]);
        /**
         * @var $val UserProject
         */
        foreach ($items as $val){
            $this->em->remove($val);
        }
        $this->em->flush();
    }


}