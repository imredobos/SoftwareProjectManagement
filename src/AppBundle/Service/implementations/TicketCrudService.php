<?php

namespace AppBundle\Service\implementations;

use AppBundle\Entity\Ticket;
use AppBundle\Service\CrudService;
use AppBundle\Service\interfaces\ITicketCrudService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class TicketCrudService extends CrudService implements ITicketCrudService
{
    /**
     * CarCrudService constructor.
     * @param $em EntityManager
     * @param $form FormFactory
     * @param $request Request
     */
    public function __construct(EntityManager $em, FormFactory $form, Request $request)
    {
        parent::__construct($em, $form, $request);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        $query = $this->em->createQuery("SELECT count(t) FROM AppBundle:Ticket t");
        return $query->getResult();
    }

    /**
     * @inheritDoc
     */
    public function delete($ticketId)
    {
        if ($this->exists($ticketId)) {
            $ticket = $this->find($ticketId);
            $this->em->remove($ticket);
            $this->em->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function exists($ticketId)
    {
        $ticket = $this->find($ticketId);
        return ($ticket) ? true : false;
    }

    /**
     * @inheritDoc
     */
    public function find($ticketId)
    {
        return $this->getRepo()->find($ticketId);
    }

    /**
     * @return EntityRepository
     */
    public function getRepo()
    {
        return $this->em->getRepository(Ticket::class);
    }

    /**
     * @inheritDoc
     */
    public function findAll()
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @inheritDoc
     */
    public function save($ticket)
    {
        $this->em->persist($ticket);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getTicketForm($ticket)
    {
        // TODO: Implement getTicketForm() method.
    }


}