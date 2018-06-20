<?php

namespace AppBundle\Service\interfaces;

use AppBundle\Entity\Project;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\User;
use Symfony\Component\Form\FormInterface;

interface ITicketCrudService
{
    /**
     * @return integer
     */
    public function count();

    /**
     * @param $ticketId integer
     */
    public function delete($ticketId);

    /**
     * @param $ticketId integer
     */
    public function exists($ticketId);

    /**
     * @return Ticket[]
     */
    public function findAll();

    /**
     * @param $ticketId integer
     * @return Ticket
     */
    public function find($ticketId);

    /**
     * @param $ticket Ticket
     */
    public function save($ticket);

    /**
     * @param $ticket Ticket
     * @param $project Project[]
     * @return FormInterface
     */
    public function getTicketCreateForm($ticket, $project);

    /**
     * @param $ticket Ticket
     * @param $users User[]
     * @return FormInterface
     */
    public function getTicketEditForm($ticket, $users);

    /**
     * @param $users User[]
     * @return Ticket[]
     */
    public function getTicketsByUser($users);
}