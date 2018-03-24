<?php
declare(strict_types=1);

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Api\Object;

use Agit\ApiBundle\Annotation\Object;
use Agit\ApiBundle\Annotation\Property;
use Agit\ApiBundle\Api\Object\AbstractResponseObject;
use Agit\ApiBundle\Api\Object\IdTrait;
use Agit\ApiBundle\Api\Object\NameTrait;

/**
 * @Object\Object(namespace="syslog.v1")
 */
class User extends AbstractResponseObject
{
    use IdTrait;
    use NameTrait;

    /**
     * @Property\Name("E-mail")
     * @Property\StringType
     */
    public $email;
}
