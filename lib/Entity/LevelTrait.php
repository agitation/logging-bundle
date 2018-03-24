<?php
declare(strict_types=1);

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Entity;

use Psr\Log\LogLevel;

trait LevelTrait
{
    protected $availableLevels =
    [
        LogLevel::DEBUG => LevelInterface::LEVEL_DEBUG,     // debug messages
        LogLevel::INFO => LevelInterface::LEVEL_INFO,      // informational messages
        LogLevel::NOTICE => LevelInterface::LEVEL_NOTICE,    // normal but significant condition
        LogLevel::WARNING => LevelInterface::LEVEL_WARNING,   // warning conditions
        LogLevel::ERROR => LevelInterface::LEVEL_ERROR,     // error conditions
        LogLevel::CRITICAL => LevelInterface::LEVEL_CRITICAL,  // critical conditions
        LogLevel::ALERT => LevelInterface::LEVEL_ALERT,     // action must be taken immediately
        LogLevel::EMERGENCY => LevelInterface::LEVEL_EMERGENCY  // system is unusable
    ];
}
