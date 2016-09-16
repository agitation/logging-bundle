<?php

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Entity;

use Agit\BaseBundle\Entity\IdentityAwareTrait;
use Doctrine\ORM\Mapping as ORM;

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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return Translate::x("logging category", $this->name);
    }
}
