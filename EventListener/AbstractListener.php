<?php

/*
 * This file is part of the Assetic plugin for carew.
 *
 * (c) Francis Besset <francis.besset@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FrancisBesset\Carew\Assetic\EventListener;

use Assetic\Asset\FileAsset;
use Assetic\Filter\FilterInterface;
use Carew\Event\CarewEvent;
use Carew\Event\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Finder\Finder;

/**
 * @author Francis Besset <francis.besset@gmail.com>
 */
abstract class AbstractListener implements EventSubscriberInterface
{
    private $finder;

    private $filter;

    public function __construct(Finder $finder, $filter, $extensionFile)
    {
        $this->finder = $finder->name('*.'.$extensionFile);
        $this->filter = $filter;
    }

    public function onTerminate(CarewEvent $carewEvent)
    {
        foreach ($this->finder->in($carewEvent->getArgument('webDir')) as $file) {
            $asset = new FileAsset($file->getPathname(), array($this->getFilter()));
            file_put_contents($file->getPathname(), $asset->dump());
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::TERMINATE => array(array('onTerminate', -512)),
        );
    }

    private function getFilter()
    {
        if ($this->filter instanceof \Closure) {
            $filter = $this->filter;
            $this->filter = $filter();
        }

        return $this->filter;
    }
}
