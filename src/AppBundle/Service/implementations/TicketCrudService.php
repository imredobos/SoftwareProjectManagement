<?php

namespace AppBundle\Service\implementations;

use AppBundle\Entity\Project;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\User;
use AppBundle\Entity\Util\Priority;
use AppBundle\Entity\Util\Status;
use AppBundle\Entity\Worklog;
use AppBundle\Service\CrudService;
use AppBundle\Service\interfaces\ITicketCrudService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $ticket = $this->find($ticketId);
        /**
         * @var $worklogs Worklog[]
         */
        $worklogs = $ticket->getTicketWorklog();
        foreach ($worklogs as $worklog){
            $this->em->remove($worklog);
        }
        $this->em->flush();
        $this->em->remove($ticket);
        $this->em->flush();
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

    public function getTicketsByUser($user){
        $query = $this->em->createQuery("
            SELECT t FROM AppBundle:Ticket t
            WHERE t.ticket_assignee = :assignee
        ");
        $query->setParameter("assignee", $user);
        return $query->getResult();
    }

    /**
     * @inheritDoc
     */
    public function getTicketCreateForm($ticket, $projects)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $ticket);
        $form->add("ticket_name", TextType::class);
        $form->add("ticket_description", TextType::class);
        $form->add("ticket_enddate", DateType::class);
        $form->add("ticket_status", ChoiceType::class, array(
            'choices' => array(
                'New' => Status::$STATUS_NEW,
                'Estimated' => Status::$STATUS_ESTIMATED,
                'In Progress'=>Status::$STATUS_INPROGRESS,
                'Testing' => Status::$STATUS_TEST,
                'Done' =>Status::$STATUS_DONE
            )
        ));
        $form->add("ticket_priority", ChoiceType::class, array(
            'choices' => array(
                'Low' => Priority::$PRIORITY_LOW,
                'Medium' => Priority::$PRIORITY_MEDIUM,
                'High'=>Priority::$PRIORITY_HIGH
            )
        ));
        $form->add("ticket_project", EntityType::class, array(
            'class'=>Project::class,
            'choices'=>$projects,
            'choice_label' => function($project, $key, $value) {
                /**
                 * @var $project Project
                 */
                return strtoupper($project->getProjectName());
            }
        ));
        $form->add("ticket_estimatedtime", IntegerType::class);
        $form->add("Save", SubmitType::class);
        return $form->getForm();
    }

    /**
     * very bad
     * @param $ticket Ticket
     * @param $user User
     */
    private function getUsersForProjectByTicket($ticket, $user){
        $project = $ticket->getTicketProject();
    }

}