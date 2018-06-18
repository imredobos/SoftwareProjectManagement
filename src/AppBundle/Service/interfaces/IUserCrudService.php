<?php

namespace AppBundle\Service\interfaces;

use AppBundle\Entity\User;
use Symfony\Component\Form\FormInterface;

interface IUserCrudService
{
    /**
     * @return integer
     */
    public function count();

    /**
     * @param $userId integer
     */
    public function delete($userId);

    /**
     * @param $userId integer
     */
    public function exists($userId);

    /**
     * @return User[]
     */
    public function findAll();

    /**
     * @param $userId integer
     * @return User
     */
    public function find($userId);

    /**
     * @param $user User
     */
    public function save($user);

    /**
     * @param $user User
     * @return FormInterface
     */
    public function getUserForm($user);

    /**
     * @param $user User
     * @return FormInterface
     */
    public function getUserRegistrationForm($user);

    /**
     * @param $email string
     * @return User
     */
    public function findByEmail($email);
}