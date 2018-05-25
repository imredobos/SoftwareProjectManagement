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
     * @return EntityRepository
     */
    public function getRepo()
    {
        return $this->em->getRepository(Ticket::class);
    }
}