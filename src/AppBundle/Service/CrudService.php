<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

abstract class CrudService
{
    /** @var EntityManager */
    protected $em;
    /** @var  FormFactory */
    protected $formFactory;
    /** @var  Request */
    protected $request;

    /**
     * CrudService constructor.
     * @param $em EntityManager
     * @param $form FormFactory
     * @param $request Request
     */
    public function __construct($em, $form, $request)
    {
        $this->em = $em;
        $this->formFactory = $form;
        $this->request = $request;
    }

    /**
     * @return EntityRepository
     */
    public abstract function getRepo();
}