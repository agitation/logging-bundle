<?php
declare(strict_types=1);
/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Api\Object;

use Agit\ApiBundle\Annotation\Depends;
use Agit\ApiBundle\Annotation\Object;
use Agit\ApiBundle\Annotation\Property;
use Agit\ApiBundle\Api\Object\AbstractResponseObject;
use Agit\ApiBundle\Api\Object\IdTrait;
use Agit\LoggingBundle\Entity\LevelTrait;
use Agit\SettingBundle\Service\SettingService;
use DateTimeZone;

/**
 * @Object\Object(namespace="syslog.v1")
 * @Depends({"@agit.setting"})
 */
class Logentry extends AbstractResponseObject
{
    use IdTrait;
    use LevelTrait;

    /**
     * @Property\Name("Time")
     * @Property\ObjectType(class="admin.v1/DateTime")
     */
    public $created;

    /**
     * @Property\Name("Category")
     * @Property\ObjectType(class="LogentryCategory")
     */
    public $category;

    /**
     * @Property\Name("User")
     * @Property\ObjectType(class="User")
     */
    public $user;

    /**
     * @Property\Name("Level", context="log level")
     * @Property\StringType
     */
    public $level;

    /**
     * @Property\Name("Message", context="log message")
     * @Property\StringType
     */
    public $message;

    private $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function fill($logentry)
    {
        parent::fill($logentry);

        $availableLevels = array_flip($this->availableLevels);
        $this->level = $availableLevels[$logentry->getLevel()];

        $timezone = $this->settingService->getValueOf('agit.timezone');
        $created = clone $logentry->getCreated();
        $created->setTimezone(new DateTimeZone($timezone));
        $this->created = $this->createObject('common.v1/DateTime', $created);
    }
}
