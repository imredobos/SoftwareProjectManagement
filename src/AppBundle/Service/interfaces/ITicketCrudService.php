<?php

namespace AppBundle\Service\interfaces;

use AppBundle\Entity\Ticket;
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
     * @return FormInterface
     */
    public function getTicketForm($ticket);
}