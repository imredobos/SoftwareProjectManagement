<?php

namespace AppBundle\Service\interfaces;

use AppBundle\Entity\Worklog;
use Symfony\Component\Form\FormInterface;

interface IWorklogCrudService
{
    /**
     * @return integer
     */
    public function count();

    /**
     * @param $worklogId integer
     */
    public function delete($worklogId);

    /**
     * @param $worklogId integer
     */
    public function exists($worklogId);

    /**
     * @return Worklog[]
     */
    public function findAll();

    /**
     * @param $worklogId integer
     * @return Worklog
     */
    public function find($worklogId);

    /**
     * @param $worklog Worklog
     */
    public function save($worklog);

    /**
     * @param $worklog Worklog
     * @return FormInterface
     */
    public function getWorklogForm($worklog);
}