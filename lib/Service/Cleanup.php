<?php

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Service;

use Agit\LoggingBundle\Entity\Logentry;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class Cleanup
{
    const TTL = 180;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function cleanup()
    {
        $date = (new DateTime())->sub(new DateInterval(sprintf("P%sD", self::TTL)));

        $this->entityManager->createQueryBuilder()
            ->delete("AgitLoggingBundle:Logentry", "logentry")
            ->where("logentry.created <= :date")
            ->setParameter("date", $date)
            ->getQuery()->execute();
    }
}
