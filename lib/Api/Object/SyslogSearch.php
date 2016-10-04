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
 * @Depends({"@agit.validation"})
 */
class SyslogSearch extends AbstractRequestObject implements SearchPaginationInterface, SearchOrderInterface
{
    use SearchPaginationTrait;
    use SearchPeriodTrait;
    use LevelTrait;

    private $validator;

    public function __construct(ValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @Property\ArrayType(nullable=true)
     *
     * Levels filter.
     */
    public $levels;

    /**
     * @Property\StringType(nullable=true)
     *
     * A string to seach within the message body.
     */
    public $term;

    public function validate()
    {
        parent::validate();

        if (!is_null($this->levels))
            $this->validator->validateField(Translate::t("Log levels"), "multiSelection", $this->levels, $this->availableLevels);
    }
}
