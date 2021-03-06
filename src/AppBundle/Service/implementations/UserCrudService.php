<?php

namespace AppBundle\Service\implementations;

use AppBundle\Entity\User;
use AppBundle\Service\CrudService;
use AppBundle\Service\interfaces\IUserCrudService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class UserCrudService extends CrudService implements IUserCrudService
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
        $query = $this->em->createQuery("SELECT count(u) FROM AppBundle:User u");
        return $query->getResult();
    }

    /**
     * @inheritDoc
     */
    public function delete($userId)
    {
        if ($this->exists($userId)) {
            $user = $this->find($userId);
            $this->em->remove($user);
            $this->em->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function exists($userId)
    {
        $user = $this->find($userId);
        return ($user) ? true : false;
    }

    /**
     * @inheritDoc
     */
    public function find($userId)
    {
        return $this->getRepo()->find($userId);
    }

    /**
     * @return EntityRepository
     */
    public function getRepo()
    {
        return $this->em->getRepository(User::class);
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
    public function save($user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function getUserForm($user)
    {
        // TODO
    }

    /**
     * @inheritDoc
     */
    public function getUserRegistrationForm($user)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $user);
//        $form->add('user_email', TextType::class);
        $form->add('user_email', EmailType::class);
        $form->add('plainPassword', RepeatedType::class, [
           'type' => PasswordType::class,
           'first_options' => [
               'label' => 'Password',
           ],
            'second_options' => [
                'label' => 'Repeated Password'
            ]
        ]);
        $form->add('register', SubmitType::class);
        return $form->getForm();
    }

    /**
     * @inheritDoc
     */
    public function findByEmail($email)
    {
        return $this->getRepo()->findOneBy(["user_mail"=>$email]);
    }


}