<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Car;
use AppBundle\Entity\Project;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\User;
use AppBundle\Entity\UserProject;
use AppBundle\Entity\Util\Priority;
use AppBundle\Entity\Util\Role;
use AppBundle\Entity\Util\STATUS;
use AppBundle\Entity\Worklog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Util;;

class DataLoader extends Fixture implements  FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;
    /** @var EntityManager */
    private $em;
    /** @var string */
    private $environment;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $kernel = $this->container->get('kernel');
        if ($kernel) $this->environment=$kernel->getEnvironment();
    }

    public function load(ObjectManager $manager)
    {
        $this->em = $manager;

        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);
        $stackLogger = new DebugStack();
        $echoLogger = new EchoSQLLogger();
        $this->em->getConnection()->getConfiguration()->setSQLLogger($stackLogger);

        $this->createUsers();
        $this->createProjects();
        $this->createTickets();
        $this->createUserProjects();
        $this->createWorklog();
    }

    private function createUsers(){
        $user1 = new User();
        $user1->setUserEmail("user1@nik.com");
        $user1->setUserPass("$2y$12$6MpOS7vXC9j0vZzBYi74cONrNdjK9XSQPtkxGzpmzRSEMl0me2QI2");
        $user1->setUserRegistered(new \DateTime());
        $user1->setUserGroup(Role::$ROLE_ADMIN);
        $this->em->persist($user1);
        $this->em->flush();

        $user2 = new User();
        $user2->setUserEmail("user2@nik.com");
        $user2->setUserPass("$2y$12$6MpOS7vXC9j0vZzBYi74cONrNdjK9XSQPtkxGzpmzRSEMl0me2QI2");
        $user2->setUserRegistered(new \DateTime());
        $user2->setUserGroup(Role::$ROLE_USER);
        $this->em->persist($user2);
        $this->em->flush();

        $user3 = new User();
        $user3->setUserEmail("user3@nik.com");
        $user3->setUserPass("$2y$12$6MpOS7vXC9j0vZzBYi74cONrNdjK9XSQPtkxGzpmzRSEMl0me2QI2");
        $user3->setUserRegistered(new \DateTime());
        $user3->setUserGroup(Role::$ROLE_USER);
        $this->em->persist($user3);
        $this->em->flush();
    }

    private function createProjects(){
        $project1 = new Project();
        $project1->setProjectName("Facebook");
        $date1 = new \DateTime();
        $date1->add(new \DateInterval('P10D'));
        $project1->setProjectStartdate($date1);
        $date1->add(new \DateInterval('P20D'));
        $project1->setProjectEnddate($date1);
        $project1->setProjectActive(true);
        $this->em->persist($project1);
        $this->em->flush();

        $project2 = new Project();
        $project2->setProjectName("Google Mail");
        $date2 = new \DateTime();
        $date2->sub(new \DateInterval('P30D'));
        $project2->setProjectStartdate($date2);
        $date2->sub(new \DateInterval('P10D'));
        $project2->setProjectEnddate($date2);
        $project2->setProjectActive(false);
        $this->em->persist($project2);
        $this->em->flush();

        $project2 = new Project();
        $project2->setProjectName("Apple Maps");
        $date2 = new \DateTime();
        $date2->sub(new \DateInterval('P30D'));
        $project2->setProjectStartdate($date2);
        $date2->sub(new \DateInterval('P10D'));
        $project2->setProjectEnddate($date2);
        $project2->setProjectActive(false);
        $this->em->persist($project2);
        $this->em->flush();
    }

    private function createTickets(){
        $ticket1 = new Ticket();
        $user1 = $this->em->getRepository(User::class)->findOneBy(['user_email'=>"user1@nik.com"]);
        $ticket1->setTicketAssignee($user1);
        $project1 = $this->em->getRepository(Project::class)->findOneBy(['project_name'=>'Facebook']);
        $ticket1->setTicketProject($project1);
        $ticket1->setTicketName("New design");
        $ticket1->setTicketDescription("Create new design with various colour");
        $date1 = new \DateTime();
        $date1->sub(new \DateInterval('P2D'));
        $ticket1->setTicketStartdate($date1);
        $ticket1->setTicketStatus(Status::$STATUS_NEW);
        $ticket1->setTicketPriority(Priority::$PRIORITY_MEDIUM);
        $ticket1->setTicketEstimatedtime(70);
        $this->em->persist($ticket1);
        $this->em->flush();

        $ticket2 = new Ticket();
        $user2 = $this->em->getRepository(User::class)->findOneBy(['user_email'=>"user2@nik.com"]);
        $ticket2->setTicketAssignee($user2);
        $project2 = $this->em->getRepository(Project::class)->findOneBy(['project_name'=>'Google Mail']);
        $ticket2->setTicketProject($project2);
        $ticket2->setTicketName("REST API");
        $ticket2->setTicketDescription("Create a REST API to handle clients' requests");
        $date2 = new \DateTime();
        $date2->sub(new \DateInterval('P80D'));
        $ticket2->setTicketStartdate($date2);
        $date2->sub(new \DateInterval('P10D'));
        $ticket2->setTicketEnddate($date2);
        $ticket2->setTicketStatus(Status::$STATUS_DONE);
        $ticket2->setTicketPriority(Priority::$PRIORITY_HIGH);
        $ticket2->setTicketEstimatedtime(110);
        $this->em->persist($ticket2);
        $this->em->flush();

        $ticket3 = new Ticket();
        $user3 = $this->em->getRepository(User::class)->findOneBy(['user_email'=>"user3@nik.com"]);
        $ticket3->setTicketAssignee($user3);
        $project3 = $this->em->getRepository(Project::class)->findOneBy(['project_name'=>'Apple Maps']);
        $ticket3->setTicketProject($project3);
        $ticket3->setTicketName("Code it all again");
        $ticket3->setTicketDescription("It is shit, start from zero");
        $date3 = new \DateTime();
        $date3->sub(new \DateInterval('P60D'));
        $ticket3->setTicketStartdate($date3);
        $ticket3->setTicketStatus(Status::$STATUS_INPROGRESS);
        $ticket3->setTicketPriority(Priority::$PRIORITY_LOW);
        $ticket3->setTicketEstimatedtime(800);
        $this->em->persist($ticket3);
        $this->em->flush();
    }

    private function createUserProjects(){
        $userproject1 = new UserProject();
        $project1 = $this->em->getRepository(Project::class)->findOneBy(['project_name'=>'Apple Maps']);
        $userproject1->setUserprojectProject($project1);
        $user1 = $this->em->getRepository(User::class)->findOneBy(['user_email'=>"user1@nik.com"]);
        $userproject1->setUserprojectUser($user1);
        $this->em->persist($userproject1);
        $this->em->flush();

        $userproject2 = new UserProject();
        $project2 = $this->em->getRepository(Project::class)->findOneBy(['project_name'=>'Google Mail']);
        $userproject2->setUserprojectProject($project2);
        $user2 = $this->em->getRepository(User::class)->findOneBy(['user_email'=>"user1@nik.com"]);
        $userproject2->setUserprojectUser($user2);
        $this->em->persist($userproject2);
        $this->em->flush();

        $userproject3 = new UserProject();
        $project3 = $this->em->getRepository(Project::class)->findOneBy(['project_name'=>'Facebook']);
        $userproject3->setUserprojectProject($project3);
        $user3 = $this->em->getRepository(User::class)->findOneBy(['user_email'=>"user1@nik.com"]);
        $userproject3->setUserprojectUser($user3);
        $this->em->persist($userproject3);
        $this->em->flush();

        $userproject4 = new UserProject();
        $project4 = $this->em->getRepository(Project::class)->findOneBy(['project_name'=>'Google Mail']);
        $userproject4->setUserprojectProject($project4);
        $user4 = $this->em->getRepository(User::class)->findOneBy(['user_email'=>"user2@nik.com"]);
        $userproject4->setUserprojectUser($user4);
        $this->em->persist($userproject4);
        $this->em->flush();

        $userproject5 = new UserProject();
        $project5 = $this->em->getRepository(Project::class)->findOneBy(['project_name'=>'Facebook']);
        $userproject5->setUserprojectProject($project5);
        $user5 = $this->em->getRepository(User::class)->findOneBy(['user_email'=>"user3@nik.com"]);
        $userproject5->setUserprojectUser($user5);
        $this->em->persist($userproject5);
        $this->em->flush();
    }

    private function createWorklog(){
        $worklog1 = new Worklog();
        $ticket1=$this->em->getRepository(Ticket::class)->findOneBy(['ticket_name'=>'Code it all again']);
        $worklog1->setWorklogTicket($ticket1);
        $worklog1->setWorklogComment("Project skeleton");
        $worklog1->setWorklogTime(10);
        $this->em->persist($worklog1);
        $this->em->flush();

        $worklog2 = new Worklog();
        $ticket2=$this->em->getRepository(Ticket::class)->findOneBy(['ticket_name'=>'REST API']);
        $worklog2->setWorklogTicket($ticket2);
        $worklog2->setWorklogComment("Create routes");
        $worklog2->setWorklogTime(25);
        $this->em->persist($worklog2);
        $this->em->flush();

        $worklog3 = new Worklog();
        $ticket3=$this->em->getRepository(Ticket::class)->findOneBy(['ticket_name'=>'New design']);
        $worklog3->setWorklogTicket($ticket3);
        $worklog3->setWorklogComment("Learning about responsive design");
        $worklog3->setWorklogTime(5);
        $this->em->persist($worklog3);
        $this->em->flush();
    }

}