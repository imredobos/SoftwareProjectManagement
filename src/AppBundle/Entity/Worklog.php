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
     * Get worklogId
     *
     * @return integer
     */
    public function getWorklogId()
    {
        return $this->worklog_id;
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
