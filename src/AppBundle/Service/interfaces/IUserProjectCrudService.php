<?php

namespace AppBundle\Service\interfaces;

use AppBundle\Entity\Project;
use AppBundle\Entity\User;
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
     * @param $userId integer
     */
    public function deleteByUser($userId);

    /**
     * @param $projectId integer
     */
    public function deleteByProject($projectId);

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
     * @param $project Project
     * @return User[]
     */
    public function findUsersByProject($project);

    /**
     * @param $userproject UserProject
     * @param $users User
     * @return FormInterface
     */
    public function getUserProjectForm($userproject, $users);
}