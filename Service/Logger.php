<?php

namespace Agit\LoggingBundle\Service;

use DateTime;
use Exception;
use Agit\BaseBundle\Exception\InternalErrorException;
use Agit\IntlBundle\Service\LocaleService;
use Agit\LoggingBundle\Entity\Logentry;
use Agit\UserBundle\Service\UserService;
use Doctrine\ORM\EntityManager;
use Agit\UserBundle\Entity\User;
use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;

class Logger
{
    private $entityManager;

    private $logger;

    private $userService;

    private $levels =
    [
        LogLevel::DEBUG => 7,       // debug-level messages
        LogLevel::INFO => 6,        // informational messages
        LogLevel::NOTICE => 5,      // normal but significant condition
        LogLevel::WARNING => 4,     // warning conditions
        LogLevel::ERROR => 3,       // error conditions
        LogLevel::CRITICAL => 2,    // critical conditions
        LogLevel::ALERT => 1,       // action must be taken immediately
        LogLevel::EMERGENCY => 0    // system is unusable
    ];

    public function __construct(EntityManager $entityManager, LoggerInterface $logger, UserService $userService)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->userService = $userService;
    }

    public function log($level, $category, $message, $user = null)
    {
        try
        {
            if (is_string($level) && isset($this->levels[$level]))
                $level = $this->levels[$level];

            if (!in_array($level, $this->levels))
                throw new InternalErrorException(sprintf("Invalid log level: %s", $level));

            if ($level <= LogLevel::ERROR)
                $this->logger->log($level, $message);

            if ($user === true)
                $user = $this->userService->getCurrentUser();
            elseif ($user !== null && !($user instanceof User))
                throw new InternalErrorException("The user variable must be either `NULL`, `true` or an instance of `Agit\UserBundle\Entity\User`.");


            $logentry = new Logentry();
            $logentry->setCreated(new DateTime());
            $logentry->setLevel($level);
            $logentry->setCategory($this->entityManager->getReference("AgitLoggingBundle:LogentryCategory", $category));
            $logentry->setMessage($message);
            $logentry->setUser($user);
            $this->entityManager->persist($logentry);
            $this->entityManager->flush();
        }
        catch (Exception $e)
        {
            $this->logger->critical("Failed to add a log message: " . $e->getMessage());
            throw $e;
        }
    }
}
