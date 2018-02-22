<?php
declare(strict_types=1);
/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Service;

use Agit\BaseBundle\Exception\InternalErrorException;
use Agit\LoggingBundle\Entity\LevelInterface;
use Agit\LoggingBundle\Entity\LevelTrait;
use Agit\LoggingBundle\Entity\Logentry;
use Agit\UserBundle\Entity\PrimaryUserInterface;
use Agit\UserBundle\Service\UserService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Tixys\CoreBundle\Entity\User;

class Logger implements LevelInterface
{
    use LevelTrait;

    private $entityManager;

    private $fallbackLogger;

    private $userService;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $fallbackLogger, UserService $userService)
    {
        $this->entityManager = $entityManager;
        $this->fallbackLogger = $fallbackLogger;
        $this->userService = $userService;
    }

    /**
     * @param string                    $level    a string provided through a PSR LogLevel constant
     * @param string                    $category the ID of a registered log category
     * @param string                    $message  the actual log message
     */
    public function addEntry($level, $category, $message)
    {
        try
        {
            if (! is_string($level) || ! isset($this->availableLevels[$level]))
            {
                throw new InternalErrorException(sprintf('Invalid log level: %s', $level));
            }

            $logentry = new Logentry();
            $logentry->setCreated(new DateTime());
            $logentry->setLevel($this->availableLevels[$level]);
            $logentry->setCategory($this->entityManager->getReference('AgitLoggingBundle:LogentryCategory', $category));
            $logentry->setMessage($message);
            $logentry->setUser($this->userService->getCurrentUser() ?: null);
            $this->entityManager->persist($logentry);
        }
        catch (Exception $e)
        {
            $this->fallbackLogger->critical(sprintf('Failed to add a log message: %s. Original log entry was: %s', $e->getMessage(), $message));
            throw $e;
        }
    }

    /**
     * @param string                    $level    a string provided through a PSR LogLevel constant
     * @param string                    $category the ID of a registered log category
     * @param string                    $message  the actual log message
     */
    public function log($level, $category, $message)
    {
        try
        {
            $this->addEntry($level, $category, $message);
            $this->entityManager->flush();
        }
        catch (Exception $e)
        {
            $this->fallbackLogger->critical(sprintf('Failed to add a log message: %s. Original log entry was: %s', $e->getMessage(), $message));
            throw $e;
        }
    }
}
