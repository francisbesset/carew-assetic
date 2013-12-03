<?php

/*
 * This file is part of the Assetic plugin for carew.
 *
 * (c) Francis Besset <francis.besset@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FrancisBesset\Carew\Assetic\Filter\Htmlcompressor;

use Assetic\Asset\AssetInterface;
use Assetic\Exception\FilterException;

/**
 * @link https://code.google.com/p/htmlcompressor/
 * @author Francis Besset <francis.besset@gmail.com>
 */
class XmlCompressorFilter extends AbstractCompressorFilter
{
    public function filterDump(AssetInterface $asset)
    {
        $this->compress($asset, 'xml', array());
    }
}
