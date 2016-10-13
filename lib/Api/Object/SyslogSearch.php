<?php

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Api\Object;

use Agit\ApiBundle\Annotation\Object\Object;
use Agit\ApiBundle\Annotation\Property;
use Agit\ApiBundle\Api\Object\SearchOrderTrait;
use Agit\ApiBundle\Api\Object\SearchPeriodTrait;
use Agit\ApiBundle\Api\Object\SearchPaginationTrait;
use Agit\ApiBundle\Api\Object\AbstractRequestObject;
use Agit\ApiBundle\Api\Object\SearchPaginationInterface;
use Agit\ApiBundle\Api\Object\SearchOrderInterface;
use Agit\ApiBundle\Annotation\Depends;
use Agit\IntlBundle\Tool\Translate;
use Agit\ValidationBundle\ValidationService;
use Agit\LoggingBundle\Entity\LevelTrait;

/**
 * @Object(namespace="syslog.v1")
 */
class SyslogSearch extends AbstractRequestObject implements SearchPaginationInterface, SearchOrderInterface
{
    use SearchPaginationTrait;
    use SearchPeriodTrait;

    /**
     * @Property\Name("Type")
     * @Property\StringType(allowedValues={"all", "important", "critical"})
     *
     * Type of messages to load:
     * - `all`: all messages, except debug
     * - `important`: messages with level `notice` or higher
     * - `critical`: messages with level `error` or higher
     */
    public $type = "all";

    /**
     * @Property\Name("Search term")
     * @Property\StringType(nullable=true)
     *
     * A string to seach within the message body.
     */
    public $term;
}
