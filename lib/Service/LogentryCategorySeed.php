<?php
declare(strict_types=1);

/*
 * @package    agitation/logging-bundle
 * @link       http://github.com/agitation/logging-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LoggingBundle\Service;

use Agit\IntlBundle\Tool\Translate;
use Agit\SeedBundle\Event\SeedEvent;

class LogentryCategorySeed
{
    public function registerSeed(SeedEvent $event)
    {
        $event->addSeedEntry(
            'AgitLoggingBundle:LogentryCategory',
            ['id' => 'agit.internal', 'name' => Translate::noopX('logging category', 'Internal')]
        );
    }
}
