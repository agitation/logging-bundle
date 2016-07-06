<?php

namespace Agit\LoggingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Agit\CommonBundle\Entity\GeneratedIdentityAwareTrait;
use Agit\UserBundle\Entity\User;

/**
 * @ORM\Entity
 */
class Logentry
{
    use GeneratedIdentityAwareTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Agit\UserBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime")
     * Assert\DateTime
     */
    protected $created;

    /**
     * @ORM\Column(type="smallint")
     * Assert\Range(min=0, max=7)
     */
    protected $level;

    /**
     * @ORM\ManyToOne(targetEntity="LogentryCategory")
     * Assert\Valid
     */
    protected $category;

    /**
     * @ORM\Column(type="text")
     * Assert\NotBlank
     */
    protected $message;

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Logentry
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Logentry
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Logentry
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Logentry
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set category
     *
     * @param LogentryCategory $category
     *
     * @return Logentry
     */
    public function setCategory(LogentryCategory $category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return LogentryCategory
     */
    public function getCategory()
    {
        return $this->category;
    }
}
