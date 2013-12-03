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
class HtmlCompressorFilter extends AbstractCompressorFilter
{
    private $preserveMultiSpaces;
    private $preserveLineBreaks;
    private $removeQuotes;
    private $simpleDoctype;
    private $removeStyleAttr;
    private $removeLinkAttr;
    private $removeScriptAttr;
    private $removeFormAttr;
    private $removeInputAttr;
    private $simpleBoolAttr;
    private $removeJsProtocol;
    private $removeHttpProtocol;
    private $removeHttpsProtocol;
    private $removeSurroundingSpaces;
    private $compressJs;
    private $compressCss;
    private $jsCompressor;

    # YUI Compressor options
    private $nomunge;
    private $preserveSemi;
    private $disableOptimizations;
    private $lineBreak;

    public function setPreserveMultiSpaces($preserveMultiSpaces)
    {
        $this->preserveMultiSpaces = $preserveMultiSpaces;

        return $this;
    }

    public function setPreserveLineBreaks($preserveLineBreaks)
    {
        $this->preserveLineBreaks = $preserveLineBreaks;

        return $this;
    }

    public function setRemoveQuotes($removeQuotes)
    {
        $this->removeQuotes = $removeQuotes;

        return $this;
    }

    public function setSimpleDoctype($simpleDoctype)
    {
        $this->simpleDoctype = $simpleDoctype;

        return $this;
    }

    public function setRemoveStyleAttr($removeStyleAttr)
    {
        $this->removeStyleAttr = $removeStyleAttr;

        return $this;
    }

    public function setRemoveLinkAttr($removeLinkAttr)
    {
        $this->removeLinkAttr = $removeLinkAttr;

        return $this;
    }

    public function setRemoveScriptAttr($removeScriptAttr)
    {
        $this->removeScriptAttr = $removeScriptAttr;

        return $this;
    }

    public function setRemoveFormAttr($removeFormAttr)
    {
        $this->removeFormAttr = $removeFormAttr;

        return $this;
    }

    public function setRemoveInputAttr($removeInputAttr)
    {
        $this->removeInputAttr = $removeInputAttr;

        return $this;
    }

    public function setSimpleBoolAttr($simpleBoolAttr)
    {
        $this->simpleBoolAttr = $simpleBoolAttr;

        return $this;
    }

    public function setRemoveJsProtocol($removeJsProtocol)
    {
        $this->removeJsProtocol = $removeJsProtocol;

        return $this;
    }

    public function setRemoveHttpProtocol($removeHttpProtocol)
    {
        $this->removeHttpProtocol = $removeHttpProtocol;

        return $this;
    }

    public function setRemoveHttpsProtocol($removeHttpsProtocol)
    {
        $this->removeHttpsProtocol = $removeHttpsProtocol;

        return $this;
    }

    public function setRemoveSurroundingSpaces($removeSurroundingSpaces)
    {
        $this->removeSurroundingSpaces = $removeSurroundingSpaces;

        return $this;
    }

    public function setCompressJs($compressJs)
    {
        $this->compressJs = $compressJs;

        return $this;
    }

    public function setCompressCss($compressCss)
    {
        $this->compressCss = $compressCss;

        return $this;
    }

    public function setJsCompressor($jsCompressor)
    {
        $this->jsCompressor = $jsCompressor;

        return $this;
    }

    public function setNomunge($nomunge)
    {
        $this->nomunge = $nomunge;

        return $this;
    }

    public function setPreserveSemi($preserveSemi)
    {
        $this->preserveSemi = $preserveSemi;

        return $this;
    }

    public function setDisableOptimizations($disableOptimizations)
    {
        $this->disableOptimizations = $disableOptimizations;

        return $this;
    }

    public function setLineBreak($lineBreak)
    {
        $this->lineBreak = $lineBreak;

        return $this;
    }

    public function filterDump(AssetInterface $asset)
    {
        $options = array();

        $this->preserveMultiSpaces and $options[] = '--preserve-multi-spaces';
        $this->preserveLineBreaks and $options[] = '--preserve-line-breaks';
        $this->removeQuotes and $options[] = '--remove-quotes';
        $this->simpleDoctype and $options[] = '--simple-doctype';
        $this->removeStyleAttr and $options[] = '--remove-style-attr';
        $this->removeLinkAttr and $options[] = '--remove-link-attr';
        $this->removeScriptAttr and $options[] = '--remove-script-attr';
        $this->removeFormAttr and $options[] = '--remove-form-attr';
        $this->removeInputAttr and $options[] = '--remove-input-attr';
        $this->simpleBoolAttr and $options[] = '--simple-bool-attr';
        $this->removeJsProtocol and $options[] = '--remove-js-protocol';
        $this->removeHttpProtocol and $options[] = '--remove-http-protocol';
        $this->removeHttpsProtocol and $options[] = '--remove-https-protocol';
        $this->removeSurroundingSpaces and $options[] = '--remove-surrounding-spaces' and $options[] = $this->removeSurroundingSpaces;
        $this->compressJs and $options[] = '--compress-js';
        $this->compressCss and $options[] = '--compress-css';
        $this->jsCompressor and $options[] = '--js-compressor' and $options[] = $this->jsCompressor;

        # YUI Compressor
        $this->nomunge and $options[] = '--nomunge';
        $this->preserveSemi and $options[] = '--preserve-semi';
        $this->disableOptimizations and $options[] = '--disable-optimizations';
        $this->lineBreak and $options[] = '--line-break' and $options[] = $this->lineBreak;

        $this->compress($asset, 'html', $options);
    }
}
