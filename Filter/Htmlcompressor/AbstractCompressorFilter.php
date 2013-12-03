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
use Assetic\Filter\BaseProcessFilter;

/**
 * @link https://code.google.com/p/htmlcompressor/
 * @author Francis Besset <francis.besset@gmail.com>
 */
abstract class AbstractCompressorFilter extends BaseProcessFilter
{
    private $jarPath;
    private $javaPath;

    private $charset;
    private $preserveComments;
    private $removeIntertagSpaces;

    public function __construct($jarPath, $javaPath = '/usr/bin/java')
    {
        $this->jarPath = $jarPath;
        $this->javaPath = $javaPath;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    public function setPreserveComments($preserveComments)
    {
        $this->preserveComments = $preserveComments;

        return $this;
    }

    public function setRemoveIntertagSpaces($removeIntertagSpaces)
    {
        $this->removeIntertagSpaces = $removeIntertagSpaces;

        return $this;
    }

    public function filterLoad(AssetInterface $asset)
    {
    }

    protected function compress(AssetInterface $asset, $type, $options = array())
    {
        $pb = $this->createProcessBuilder(array($this->javaPath));
        $pb->add('-jar')->add($this->jarPath);

        foreach ($options as $option) {
            $pb->add($option);
        }

        $this->charset and $pb->add('--charset')->add($this->charset);
        $this->preserveComments and $pb->add('--preserve-comments');
        $this->removeIntertagSpaces and $pb->add('--remove-intertag-spaces');

        // input and output files
        $tempDir = realpath(sys_get_temp_dir());
        $input = tempnam($tempDir, 'assetic_htmlcompressor');
        $output = tempnam($tempDir, 'assetic_htmlcompressor');
        file_put_contents($input, $asset->getContent());
        $pb->add('-o')->add($output)->add($input);

        $proc = $pb->getProcess();
        $code = $proc->run();
        unlink($input);

        if (0 !== $code || false !== strpos($proc->getOutput(), 'ERROR')) {
            if (file_exists($output)) {
                unlink($output);
            }

            throw FilterException::fromProcess($proc)->setInput($asset->getContent());
        }

        $asset->setContent(file_get_contents($output));
        unlink($output);
    }
}
