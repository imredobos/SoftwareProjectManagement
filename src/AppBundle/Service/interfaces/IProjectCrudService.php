<?php

namespace AppBundle\Service\interfaces;

use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use Symfony\Component\Form\FormInterface;

interface IProjectCrudService
{
    /**
     * @return integer
     */
    public function count();

    /**
     * @param $projectId integer
     */
    public function delete($projectId);

    /**
     * @param $projectId integer
     */
    public function exists($projectId);

    /**
     * @return Project[]
     */
    public function findAll();

    /**
     * @param $projectId integer
     * @return Project
     */
    public function find($projectId);

    /**
     * @param $project Project
     */
    public function save($project);

    /**
     * @param $project Project
     * @return FormInterface
     */
    public function getProjectForm($project);

    /**
     * @param $user User
     * @return Project[]
     */
    public function findAllByUser($user);
}