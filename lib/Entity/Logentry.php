<?php
declare(strict_types=1);

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Entity;

use Agit\BaseBundle\Entity\GeneratedIdentityAwareTrait;
use Agit\UserBundle\Entity\PrimaryUserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Logentry
{
    use GeneratedIdentityAwareTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Agit\UserBundle\Entity\PrimaryUserInterface")
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
     * @ORM\Column(type="string")
     * Assert\NotBlank
     */
    protected $category;

    /**
     * @ORM\Column(type="text")
     * Assert\NotBlank
     */
    protected $message;

    /**
     * Set created.
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
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set level.
     *
     * @param int $level
     *
     * @return Logentry
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level.
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set message.
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
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set user.
     *
     * @param PrimaryUserInterface $user
     *
     * @return Logentry
     */
    public function setUser(PrimaryUserInterface $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return PrimaryUserInterface|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set category.
     *
     * @param string $category
     *
     * @return Logentry
     */
    public function setCategory(string $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
}
