<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

        $bmw = new Brand();
        $bmw->setBrandName("BMW");
        $this->em->persist($bmw);

        $audi = new Brand();
        $audi->setBrandName("AUDI");
        $this->em->persist($audi);

        $citroen = new Brand();
        $citroen->setBrandName("CITROEN");
        $this->em->persist($citroen);
        $this->em->flush();
        //echo "\nBRANDS OK. QUERIES: ".count($stackLogger->queries);

        $car = new Car();
        $car->setCarBrand($bmw);
        $car->setCarModel("116i");
        $car->setCarVisible(true);
        $car->setCarPrice(12345);
        $this->em->persist($car);
        $this->em->flush();
        //echo "\nCAR OK. QUERIES: ".count($stackLogger->queries);
        //echo "\n\n";

        $oneCar = $this->em->getRepository(Car::class)->
            findOneBy(['car_model'=>"116i"]);
        $oneCar->setCarPrice(22222);
        $this->em->persist($oneCar);
        $this->em->flush();
        //echo "\nMOD OK. QUERIES: ".count($stackLogger->queries);
        //echo "\nPRICE IS: ".
          $this->em->getRepository(Car::class)->find(1)->getCarPrice();
        //echo "\n\n";

        //echo "NUMBER OF CARS FOR BMW\n";
        //echo $bmw->getBrandCars()->count()."\n"; // PROXY CLASSES
        //echo $this->em->getRepository(Brand::class)->find(1)->getBrandCars()->count()."\n";
        $this->em->clear();
        //echo $this->em->getRepository(Brand::class)->find(1)->getBrandCars()->count()."\n";
        $audi = $this->em->getRepository(Brand::class)->find(2);
        $this->em->remove($audi);
        $this->em->flush();
        //echo "\nDEL OK. QUERIES: ".count($stackLogger->queries);
// CRUD = Create, Read, Update, Delete
// TODO: CRUD SERVICE
// Fat services, Skinny controllers
        /*
\xampp\php\php bin/console doctrine:schema:drop --force --full-database
\xampp\php\php bin/console doctrine:database:create
\xampp\php\php bin/console doctrine:schema:update --force
\xampp\php\php bin/console doctrine:fixtures:load --no-interaction -vvv
         */
    }

}