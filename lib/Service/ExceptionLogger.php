<?php

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Service;

use Agit\IntlBundle\Tool\Translate;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionLogger
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function logException(GetResponseForExceptionEvent $event)
    {
        $e = $event->getException();

        $message = sprintf(
            Translate::t("Exception `%s` in file %s at line %s."),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );

        $this->logger->log(LogLevel::ALERT, "agit.internal", $message, true);
    }
}
