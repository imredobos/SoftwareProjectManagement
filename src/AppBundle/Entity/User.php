<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018. 05. 22.
 * Time: 22:28
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PropertyInfo\Tests\Extractor\ReflectionExtractorTest;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=190, nullable=false, unique=true, options={"comment":"Email address"} )
     */
    private $user_email;

    /**
     * @ORM\Column(type="string", length=200, nullable=false, options={"comment":"User password"} )
     */
    private $user_pass;

    /**
     * @ORM\Column(type="datetime", length=100, nullable=false, options={"comment":"Registration date"} )
     */
    private $user_registered;

    /**
     * @ORM\Column(type="string", length=100, nullable=false, options={"comment":"Root rank"} )
     */
    private $user_group;

    /**
     * @ORM\OneToMany(targetEntity="UserProject", mappedBy="userproject_user")
     */
    private $user_project;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="ticket_assignee")
     */
    private $user_ticket;

    private $plainPassword;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user_project = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize(array(
            $this->user_id,
            $this->getUsername(),
            $this->getPassword()
        ));
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        list (
            $newId,
            $newUname,
            $newPass
            ) = unserialize($serialized);

        $this->user_id=$newId;
        $this->user_email=$newUname;
        $this->user_pass=$newPass;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array("ROLE_".$this->getUserGroup());
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->getUserPass();
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->getUserEmail();
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        $this->setUserPass("");
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return User
     */
    public function setUserEmail($userEmail)
    {
        $this->user_email = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Set userPass
     *
     * @param string $userPass
     *
     * @return User
     */
    public function setUserPass($userPass)
    {
        $this->user_pass = $userPass;

        return $this;
    }

    /**
     * Get userPass
     *
     * @return string
     */
    public function getUserPass()
    {
        return $this->user_pass;
    }

    /**
     * Set userRegistered
     *
     * @param \DateTime $userRegistered
     *
     * @return User
     */
    public function setUserRegistered($userRegistered)
    {
        $this->user_registered = $userRegistered;

        return $this;
    }

    /**
     * Get userRegistered
     *
     * @return \DateTime
     */
    public function getUserRegistered()
    {
        return $this->user_registered;
    }

    /**
     * Set userGroup
     *
     * @param string $userGroup
     *
     * @return User
     */
    public function setUserGroup($userGroup)
    {
        $this->user_group = $userGroup;

        return $this;
    }

    /**
     * Get userGroup
     *
     * @return string
     */
    public function getUserGroup()
    {
        return $this->user_group;
    }

    /**
     * Add userProject
     *
     * @param \AppBundle\Entity\UserProject $userProject
     *
     * @return User
     */
    public function addUserProject(\AppBundle\Entity\UserProject $userProject)
    {
        $this->user_project[] = $userProject;

        return $this;
    }

    /**
     * Remove userProject
     *
     * @param \AppBundle\Entity\UserProject $userProject
     */
    public function removeUserProject(\AppBundle\Entity\UserProject $userProject)
    {
        $this->user_project->removeElement($userProject);
    }

    /**
     * Get userProject
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserProject()
    {
        return $this->user_project;
    }

    /**
     * Add userTicket
     *
     * @param \AppBundle\Entity\Ticket $userTicket
     *
     * @return User
     */
    public function addUserTicket(\AppBundle\Entity\Ticket $userTicket)
    {
        $this->user_ticket[] = $userTicket;

        return $this;
    }

    /**
     * Remove userTicket
     *
     * @param \AppBundle\Entity\Ticket $userTicket
     */
    public function removeUserTicket(\AppBundle\Entity\Ticket $userTicket)
    {
        $this->user_ticket->removeElement($userTicket);
    }

    /**
     * Get userTicket
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserTicket()
    {
        return $this->user_ticket;
    }

    /**
    * @ORM\PrePersist
    */
    public function updateTimestamp()
    {
        if ($this->user_registered == null)
        {
            $this->user_registered = new \DateTime();
        }
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }
}
