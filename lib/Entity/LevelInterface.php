<?php
declare(strict_types=1);

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Entity;

interface LevelInterface
{
    const LEVEL_DEBUG = 7;  // debug-level messages
    const LEVEL_INFO = 6;  // informational messages
    const LEVEL_NOTICE = 5;  // normal but significant condition
    const LEVEL_WARNING = 4;  // warning conditions
    const LEVEL_ERROR = 3;  // error conditions
    const LEVEL_CRITICAL = 2;  // critical conditions
    const LEVEL_ALERT = 1;  // action must be taken immediately
    const LEVEL_EMERGENCY = 0;  // system is unusable
}
