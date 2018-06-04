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
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */

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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user_project = new ArrayCollection();
    }

    public function serialize()
    {
        return serialize(array(
            $this->user_id,
            $this->getUsername(),
            $this->getPassword()
        ));
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getUserEmail();
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
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->getUserPass();
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
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $newId,
            $newUname,
            $newPass
            ) = unserialize($serialized);

        $this->user_id = $newId;
        $this->user_email = $newUname;
        $this->user_pass = $newPass;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array("ROLE_" . $this->getUserGroup());
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
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
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
     * Get userRegistered
     *
     * @return \DateTime
     */
    public function getUserRegistered()
    {
        return $this->user_registered;
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
     * Add userProject
     *
     * @param \AppBundle\Entity\UserProject $userProject
     *
     * @return User
     */
    public function addUserProject(UserProject $userProject)
    {
        $this->user_project[] = $userProject;

        return $this;
    }

    /**
     * Remove userProject
     *
     * @param UserProject $userProject
     */
    public function removeUserProject(UserProject $userProject)
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
     * Get userTicket
     *
     * @return Ticket
     */
    public function getUserTicket()
    {
        return $this->user_ticket;
    }

    /**
     * Set userTicket
     *
     * @param Ticket $userTicket
     *
     * @return User
     */
    public function setUserTicket(Ticket $userTicket = null)
    {
        $this->user_ticket = $userTicket;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamp()
    {
        if ($this->user_registered == null)
        {
            $this->user_registered = new \DateTime();
        }
    }
}
