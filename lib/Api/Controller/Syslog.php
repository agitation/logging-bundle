<?php

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Api\Controller;

use DateTime;
use DateTimeZone;
use Agit\ApiBundle\Annotation\Controller\Controller;
use Agit\ApiBundle\Annotation\Endpoint;
use Agit\ApiBundle\Api\Controller\AbstractController;
use Agit\ApiBundle\Api\Object\RequestObjectInterface;
use Agit\ApiBundle\Annotation\Depends;
use Agit\LoggingBundle\Api\Object\SyslogSearch;
use Agit\LoggingBundle\Entity\LevelTrait;
use Agit\LoggingBundle\Entity\LevelInterface;
use Agit\SettingBundle\Service\SettingService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Controller(namespace="syslog.v1")
 * @Depends({"@doctrine.orm.entity_manager", "@agit.setting"})
 */
class Syslog extends AbstractController
{
    use LevelTrait;

    private $entityManager;

    private $settingService;

    public function __construct(EntityManagerInterface $entityManager, SettingService $settingService)
    {
        $this->entityManager = $entityManager;
        $this->settingService = $settingService;
    }

    /**
     * @Endpoint\Endpoint(request="SyslogSearch",response="Logentry[]")
     * @Endpoint\Security(capability="entity.logentry.read")
     */
    public function search(SyslogSearch $search)
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select("logentry")->from("AgitLoggingBundle:Logentry", "logentry")
            ->setFirstResult($search->get("offset"))
            ->setMaxResults($search->get("limit"))
            ->orderBy("logentry.created", "desc");

        if ($term = $search->get("term")) {
            $qb->andWhere("logentry.message LIKE :term");
            $qb->setParameter("term", "%$term%");
        }

        $localTimezone = new DateTimeZone($this->settingService->getValueOf("agit.timezone"));
        $utcTimezone = new DateTimeZone("UTC");

        if ($period = $search->get("period"))
        {
            $from = new DateTime($period->get("from")->__toString() . " 00:00:00", $localTimezone);
            $until = new DateTime($period->get("until")->__toString() . " 23:59:59", $localTimezone);
            $from->setTimezone($utcTimezone);
            $until->setTimezone($utcTimezone);

            $qb->andWhere($qb->expr()->between("logentry.created", ":from", ":until"));
            $qb->setParameter("from", $from);
            $qb->setParameter("until", $until);
        }

        $type = $search->get("type");

        if ($type === "error")
            $maxLevel = LevelInterface::LEVEL_ERROR;
        elseif ($type === "important")
            $maxLevel = LevelInterface::LEVEL_NOTICE;
        else
            $maxLevel = LevelInterface::LEVEL_INFO;

        $qb->andWhere("logentry.level <= ?1");
        $qb->setParameter(1, $maxLevel);

        $result = [];

        foreach ($qb->getQuery()->getResult() as $logentry)
            $result[] = $this->createObject("Logentry", $logentry);

        return $result;
    }
}
