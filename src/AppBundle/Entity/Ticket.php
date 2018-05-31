<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018. 05. 22.
 * Time: 22:26
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="tickets")
 */
class Ticket
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ticket_id;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $ticket_name;

    /**
     * @ORM\Column(type="string")
     */
    private $ticket_description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ticket_startdate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ticket_enddate;

    /**
     * @ORM\Column(type="string")
     */
    private $ticket_status;

    /**
     * @ORM\Column(type="string")
     */
    private $ticket_priority;

    /**
     * @ORM\OneToOne(targetEntity="User", mappedBy="user_ticket")
     */
    private $ticket_assignee;

    /**
     * @ORM\Column(type="integer")
     */
    private $ticket_estimatedtime;

    /**
     * @ORM\Column(type="integer")
     */
    private $ticket_loggedtime;

    /**
     * @ORM\OneToMany(targetEntity="Worklog", mappedBy="worklog_ticket")
     */
    private $ticket_worklog;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="project_ticket")
     * @ORM\JoinColumn(name="ticket_project", referencedColumnName="project_id")
     */
    private $ticket_project;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ticket_worklog = new ArrayCollection();
    }

    /**
     * Get ticketId
     *
     * @return integer
     */
    public function getTicketId()
    {
        return $this->ticket_id;
    }

    /**
     * Get ticketName
     *
     * @return string
     */
    public function getTicketName()
    {
        return $this->ticket_name;
    }

    /**
     * Set ticketName
     *
     * @param string $ticketName
     *
     * @return Ticket
     */
    public function setTicketName($ticketName)
    {
        $this->ticket_name = $ticketName;

        return $this;
    }

    /**
     * Get ticketDescription
     *
     * @return string
     */
    public function getTicketDescription()
    {
        return $this->ticket_description;
    }

    /**
     * Set ticketDescription
     *
     * @param string $ticketDescription
     *
     * @return Ticket
     */
    public function setTicketDescription($ticketDescription)
    {
        $this->ticket_description = $ticketDescription;

        return $this;
    }

    /**
     * Get ticketStartdate
     *
     * @return \DateTime
     */
    public function getTicketStartdate()
    {
        return $this->ticket_startdate;
    }

    /**
     * Set ticketStartdate
     *
     * @param \DateTime $ticketStartdate
     *
     * @return Ticket
     */
    public function setTicketStartdate($ticketStartdate)
    {
        $this->ticket_startdate = $ticketStartdate;

        return $this;
    }

    /**
     * Get ticketEnddate
     *
     * @return \DateTime
     */
    public function getTicketEnddate()
    {
        return $this->ticket_enddate;
    }

    /**
     * Set ticketEnddate
     *
     * @param \DateTime $ticketEnddate
     *
     * @return Ticket
     */
    public function setTicketEnddate($ticketEnddate)
    {
        $this->ticket_enddate = $ticketEnddate;

        return $this;
    }

    /**
     * Get ticketStatus
     *
     * @return string
     */
    public function getTicketStatus()
    {
        return $this->ticket_status;
    }

    /**
     * Set ticketStatus
     *
     * @param string $ticketStatus
     *
     * @return Ticket
     */
    public function setTicketStatus($ticketStatus)
    {
        $this->ticket_status = $ticketStatus;

        return $this;
    }

    /**
     * Get ticketPriority
     *
     * @return string
     */
    public function getTicketPriority()
    {
        return $this->ticket_priority;
    }

    /**
     * Set ticketPriority
     *
     * @param string $ticketPriority
     *
     * @return Ticket
     */
    public function setTicketPriority($ticketPriority)
    {
        $this->ticket_priority = $ticketPriority;

        return $this;
    }

    /**
     * Get ticketEstimatedtime
     *
     * @return \DateTime
     */
    public function getTicketEstimatedtime()
    {
        return $this->ticket_estimatedtime;
    }

    /**
     * Set ticketEstimatedtime
     *
     * @param \DateTime $ticketEstimatedtime
     *
     * @return Ticket
     */
    public function setTicketEstimatedtime($ticketEstimatedtime)
    {
        $this->ticket_estimatedtime = $ticketEstimatedtime;

        return $this;
    }

    /**
     * Get ticketLoggedtime
     *
     * @return \DateTime
     */
    public function getTicketLoggedtime()
    {
        return $this->ticket_loggedtime;
    }

    /**
     * Set ticketLoggedtime
     *
     * @param \DateTime $ticketLoggedtime
     *
     * @return Ticket
     */
    public function setTicketLoggedtime($ticketLoggedtime)
    {
        $this->ticket_loggedtime = $ticketLoggedtime;

        return $this;
    }

    /**
     * Get ticketAssignee
     *
     * @return \AppBundle\Entity\User
     */
    public function getTicketAssignee()
    {
        return $this->ticket_assignee;
    }

    /**
     * Set ticketAssignee
     *
     * @param \AppBundle\Entity\User $ticketAssignee
     *
     * @return Ticket
     */
    public function setTicketAssignee(User $ticketAssignee = null)
    {
        $this->ticket_assignee = $ticketAssignee;

        return $this;
    }

    /**
     * Add ticketWorklog
     *
     * @param Worklog $ticketWorklog
     *
     * @return Ticket
     */
    public function addTicketWorklog(Worklog $ticketWorklog)
    {
        $this->ticket_worklog[] = $ticketWorklog;

        return $this;
    }

    /**
     * Remove ticketWorklog
     *
     * @param Worklog $ticketWorklog
     */
    public function removeTicketWorklog(Worklog $ticketWorklog)
    {
        $this->ticket_worklog->removeElement($ticketWorklog);
    }

    /**
     * Get ticketWorklog
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTicketWorklog()
    {
        return $this->ticket_worklog;
    }

    /**
     * Get ticketProject
     *
     * @return \AppBundle\Entity\Project
     */
    public function getTicketProject()
    {
        return $this->ticket_project;
    }

    /**
     * Set ticketProject
     *
     * @param \AppBundle\Entity\Project $ticketProject
     *
     * @return Ticket
     */
    public function setTicketProject(Project $ticketProject = null)
    {
        $this->ticket_project = $ticketProject;

        return $this;
    }
}
