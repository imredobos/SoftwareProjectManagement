<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018. 05. 22.
 * Time: 22:27
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="worklogs")
 */
class Worklog
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $worklog_id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ticket", inversedBy="ticket_worklog")
     * @ORM\JoinColumn(name="worklog_ticket", referencedColumnName="ticket_id")
     */
    private $worklog_ticket;

    /**
     * @ORM\Column(type="integer")
     */
    private $worklog_time;

    /**
     * @ORM\Column(type="string")
     */
    private $worklog_comment;



    /**
     * Get worklogId
     *
     * @return integer
     */
    public function getWorklogId()
    {
        return $this->worklog_id;
    }

    /**
     * Set worklogTime
     *
     * @param integer $worklogTime
     *
     * @return Worklog
     */
    public function setWorklogTime($worklogTime)
    {
        $this->worklog_time = $worklogTime;

        return $this;
    }

    /**
     * Get worklogTime
     *
     * @return integer
     */
    public function getWorklogTime()
    {
        return $this->worklog_time;
    }

    /**
     * Set worklogComment
     *
     * @param string $worklogComment
     *
     * @return Worklog
     */
    public function setWorklogComment($worklogComment)
    {
        $this->worklog_comment = $worklogComment;

        return $this;
    }

    /**
     * Get worklogComment
     *
     * @return string
     */
    public function getWorklogComment()
    {
        return $this->worklog_comment;
    }

    /**
     * Set worklogTicket
     *
     * @param \AppBundle\Entity\Ticket $worklogTicket
     *
     * @return Worklog
     */
    public function setWorklogTicket(\AppBundle\Entity\Ticket $worklogTicket = null)
    {
        $this->worklog_ticket = $worklogTicket;

        return $this;
    }

    /**
     * Get worklogTicket
     *
     * @return \AppBundle\Entity\Ticket
     */
    public function getWorklogTicket()
    {
        return $this->worklog_ticket;
    }
}
