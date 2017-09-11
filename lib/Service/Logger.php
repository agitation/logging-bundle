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
     * @param PrimaryUserInterface|null $user     the user who caused this action
     */
    public function log($level, $category, $message, $user = null)
    {
        try
        {
            if (! is_string($level) || ! isset($this->availableLevels[$level]))
            {
                throw new InternalErrorException(sprintf('Invalid log level: %s', $level));
            }

            $levelKey = $this->availableLevels[$level];

            if ($user === true)
            {
                $user = $this->userService->getCurrentUser();
            }
            elseif ($user !== null && ! ($user instanceof PrimaryUserInterface))
            {
                throw new InternalErrorException("The user variable must be either `NULL`, `true` or an instance of `Agit\UserBundle\Entity\PrimaryUserInterface`.");
            }

            $logentry = new Logentry();
            $logentry->setCreated(new DateTime());
            $logentry->setLevel($levelKey);
            $logentry->setCategory($this->entityManager->getReference('AgitLoggingBundle:LogentryCategory', $category));
            $logentry->setMessage($message);
            $logentry->setUser($user);
            $this->entityManager->persist($logentry);
            $this->entityManager->flush();
        }
        catch (Exception $e)
        {
            $this->fallbackLogger->critical(sprintf('Failed to add a log message: %s. Original log entry was: %s', $e->getMessage(), $message));

            throw $e;
        }
    }
}
