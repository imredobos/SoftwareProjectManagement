<?php

namespace AppBundle\Service\interfaces;

use AppBundle\Entity\UserProject;
use Symfony\Component\Form\FormInterface;

interface IUserProjectCrudService
{
    /**
     * @return integer
     */
    public function count();

    /**
     * @param $userprojectId integer
     */
    public function delete($userprojectId);

    /**
     * @param $userprojectId integer
     */
    public function exists($userprojectId);

    /**
     * @return UserProject[]
     */
    public function findAll();

    /**
     * @param $userprojectId integer
     * @return UserProject
     */
    public function find($userprojectId);

    /**
     * @param $userproject UserProject
     */
    public function save($userproject);

    /**
     * @param $userproject UserProject
     * @return FormInterface
     */
    public function getUserProjectForm($userproject);
}