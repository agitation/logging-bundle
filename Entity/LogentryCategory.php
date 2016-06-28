<?php

namespace Agit\LoggingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Agit\CommonBundle\Entity\IdentityAwareTrait;
use Agit\UserBundle\Entity\User;
/**
 * @ORM\Entity
 */
class LogentryCategory
{
    use IdentityAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="string",length=30)
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=60)
     */
    protected $name;

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return Translate::x($this->name, "logging category");
    }
}
