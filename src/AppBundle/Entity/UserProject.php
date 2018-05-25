<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018. 05. 22.
 * Time: 22:29
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users_projects")
 */
class UserProject
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $userproject_id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user_project")
     * @ORM\JoinColumn(name="userproject_user", referencedColumnName="user_id")
     */
    private $userproject_user;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="project_userproject")
     * @ORM\JoinColumn(name="userproject_project", referencedColumnName="project_id")
     */
    private $userproject_project;

    /**
     * Get userprojectId
     *
     * @return integer
     */
    public function getUserprojectId()
    {
        return $this->userproject_id;
    }

    /**
     * Get userprojectUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserprojectUser()
    {
        return $this->userproject_user;
    }

    /**
     * Set userprojectUser
     *
     * @param \AppBundle\Entity\User $userprojectUser
     *
     * @return UserProject
     */
    public function setUserprojectUser(User $userprojectUser = null)
    {
        $this->userproject_user = $userprojectUser;

        return $this;
    }

    /**
     * Get userprojectProject
     *
     * @return Project
     */
    public function getUserprojectProject()
    {
        return $this->userproject_project;
    }

    /**
     * Set userprojectProject
     *
     * @param Project $userprojectProject
     *
     * @return UserProject
     */
    public function setUserprojectProject(Project $userprojectProject = null)
    {
        $this->userproject_project = $userprojectProject;

        return $this;
    }
}
