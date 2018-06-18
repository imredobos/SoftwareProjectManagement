<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="projects")
 * @ORM\HasLifecycleCallbacks
 */
class Project
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $project_id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $project_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $project_startdate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $project_enddate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $project_active;

    /**
     * @ORM\OneToMany(targetEntity="UserProject", mappedBy="userproject_project")
     */
    private $project_userproject;

    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="ticket_project")
     */
    private $project_ticket;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->project_userproject = new ArrayCollection();
        $this->project_ticket = new ArrayCollection();
    }

    /**
     * Get projectId
     *
     * @return integer
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * Get projectName
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->project_name;
    }

    /**
     * Set projectName
     *
     * @param string $projectName
     *
     * @return Project
     */
    public function setProjectName($projectName)
    {
        $this->project_name = $projectName;

        return $this;
    }

    /**
     * Get projectStartdate
     *
     * @return \DateTime
     */
    public function getProjectStartdate()
    {
        return $this->project_startdate;
    }

    /**
     * Set projectStartdate
     *
     * @param \DateTime $projectStartdate
     *
     * @return Project
     */
    public function setProjectStartdate($projectStartdate)
    {
        $this->project_startdate = $projectStartdate;

        return $this;
    }

    /**
     * Get projectEnddate
     *
     * @return \DateTime
     */
    public function getProjectEnddate()
    {
        return $this->project_enddate;
    }

    /**
     * Set projectEnddate
     *
     * @param \DateTime $projectEnddate
     *
     * @return Project
     */
    public function setProjectEnddate($projectEnddate)
    {
        $this->project_enddate = $projectEnddate;

        return $this;
    }

    /**
     * Get projectActive
     *
     * @return boolean
     */
    public function getProjectActive()
    {
        return $this->project_active;
    }

    /**
     * Set projectActive
     *
     * @param boolean $projectActive
     *
     * @return Project
     */
    public function setProjectActive($projectActive)
    {
        $this->project_active = $projectActive;

        return $this;
    }

    /**
     * Add projectUserproject
     *
     * @param UserProject $projectUserproject
     *
     * @return Project
     */
    public function addProjectUserproject(UserProject $projectUserproject)
    {
        $this->project_userproject[] = $projectUserproject;

        return $this;
    }

    /**
     * Remove projectUserproject
     *
     * @param UserProject $projectUserproject
     */
    public function removeProjectUserproject(UserProject $projectUserproject)
    {
        $this->project_userproject->removeElement($projectUserproject);
    }

    /**
     * Get projectUserproject
     *
     * @return Collection
     */
    public function getProjectUserproject()
    {
        return $this->project_userproject;
    }

    /**
     * Add projectTicket
     *
     * @param Ticket $projectTicket
     *
     * @return Project
     */
    public function addProjectTicket(Ticket $projectTicket)
    {
        $this->project_ticket[] = $projectTicket;

        return $this;
    }

    /**
     * Remove projectTicket
     *
     * @param Ticket $projectTicket
     */
    public function removeProjectTicket(Ticket $projectTicket)
    {
        $this->project_ticket->removeElement($projectTicket);
    }

    /**
     * Get projectTicket
     *
     * @return Collection
     */
    public function getProjectTicket()
    {
        return $this->project_ticket;
    }

    /**
     * @ORM\PrePersist
     */
    public function updateTimestamp()
    {
        if ($this->project_startdate == null)
        {
            $this->project_startdate = new \DateTime();
        }
    }
}
