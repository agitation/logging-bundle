<?php
declare(strict_types=1);
/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Entity;

use Agit\BaseBundle\Entity\IdentityAwareTrait;
use Agit\IntlBundle\Tool\Translate;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class LogentryCategory
{
    use IdentityAwareTrait;

    /**
     * @ORM\Column(type="string",length=60)
     */
    protected $name;

    /**
     * @ORM\Id
     * @ORM\Column(type="string",length=30)
     */
    private $id;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return Translate::x('logging category', $this->name);
    }
}
