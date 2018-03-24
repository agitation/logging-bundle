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

/**
 * @Object\Object(namespace="syslog.v1")
 */
class LogentryCategory extends AbstractResponseObject
{
    /**
     * @Property\Name("ID")
     * @Property\StringType
     */
    public $id;

    /**
     * @Property\Name("Name")
     * @Property\StringType
     */
    public $name;
}
