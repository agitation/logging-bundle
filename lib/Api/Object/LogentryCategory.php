<?php

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
     * @Property\StringType
     */
    public $id;

    /**
     * @Property\StringType
     */
    public $name;
}
