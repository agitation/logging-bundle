<?php

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

class Logger implements LevelInterface
{
    use LevelTrait;

    private $entityManager;

    private $logger;

    private $userService;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, UserService $userService)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->userService = $userService;
    }

    public function log($level, $category, $message, $user = null)
    {
        try {
            if (is_string($level) && isset($this->availableLevels[$level])) {
                $level = $this->availableLevels[$level];
            }

            if (! in_array($level, $this->availableLevels)) {
                throw new InternalErrorException(sprintf("Invalid log level: %s", $level));
            }

            if ($level <= LevelInterface::LEVEL_ERROR) {
                $this->logger->log($level, $message);
            }

            if ($user === true) {
                $user = $this->userService->getCurrentUser();
            } elseif ($user !== null && ! ($user instanceof PrimaryUserInterface)) {
                throw new InternalErrorException("The user variable must be either `NULL`, `true` or an instance of `Agit\UserBundle\Entity\PrimaryUserInterface`.");
            }

            $logentry = new Logentry();
            $logentry->setCreated(new DateTime());
            $logentry->setLevel($level);
            $logentry->setCategory($this->entityManager->getReference("AgitLoggingBundle:LogentryCategory", $category));
            $logentry->setMessage($message);
            $logentry->setUser($user);
            $this->entityManager->persist($logentry);
            $this->entityManager->flush();
        } catch (Exception $e) {
            $this->logger->critical("Failed to add a log message: " . $e->getMessage());
            throw $e;
        }
    }
}
