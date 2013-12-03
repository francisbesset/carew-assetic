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

/**
 * @author Francis Besset <francis.besset@gmail.com>
 */
class HtmlListener extends AbstractListener
{
    public function __construct($finder, $filter)
    {
        parent::__construct($finder, $filter, 'html');
    }
}
