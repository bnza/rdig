<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(
     *     type="string",
     *     options={"default": "ROLE_USER"}
     * )
     */
    private $roles = 'ROLE_USER';

    /**
     * Many Users have Many Sites.
     * @ORM\ManyToMany(targetEntity="Site", inversedBy="users")
     * @ORM\JoinTable(name="users_allowed_sites")
     */
    private $sites;

    /**
     * @return ArrayCollection
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @param Site $site
     */
    public function addSite(Site $site): void
    {
        $site->addUser($this); // synchronously updating inverse side
        $this->sites[] = $site;
    }

    public function removeSite(Site $site): void
    {
        $site->removeUser($this); // synchronously updating inverse side
        $this->sites->removeElement($site);
    }

    public function __construct() {
        $this->sites = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return explode(',', $this->roles);
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = implode(',', $roles);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->roles,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->roles
            ) = unserialize($serialized);
    }
}
