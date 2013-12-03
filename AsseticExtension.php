<?php

/*
 * This file is part of the Assetic plugin for carew.
 *
 * (c) Francis Besset <francis.besset@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace FrancisBesset\Carew\Assetic;

use Assetic\Filter as AsseticFilter;
use Assetic\Filter\FilterInterface;
use Carew\Carew;
use Carew\ExtensionInterface;
use FrancisBesset\Carew\Assetic\EventListener;
use FrancisBesset\Carew\Assetic\Filter as FrancisBessetFilter;

/**
 * @author Francis Besset <francis.besset@gmail.com>
 */
class AsseticExtension implements ExtensionInterface
{
    private $fixBinPath;
    private $filterOptions;

    public function register(Carew $carew)
    {
        $container = $carew->getContainer();
        $baseDir = $container['base_dir'];
        $config = $container['config']['assetic'];

        $this->filterOptions = function (FilterInterface $filter, array $options) {
            foreach ($options as $option => $value) {
                $method = 'set'.ucfirst($option);
                $filter->$method($value);
            }
        };

        $this->fixBinPath = function ($binPath) use ($baseDir) {
            if ('/' === $binPath{0}) {
                return $binPath;
            }

            return $baseDir.'/'.$binPath;
        };

        $listeners = array();
        if (isset($config['filters']['css'])) {
            $listeners[] = new EventListener\CssListener($container['finder'], $this->getCssFilter($config));
        }

        if (isset($config['filters']['js'])) {
            $listeners[] = new EventListener\JsListener($container['finder'], $this->getJsFilter($config));
        }

        if (isset($config['filters']['jpeg'])) {
            $listeners[] = new EventListener\JpegListener($container['finder'], $this->getJpegFilter($config));
        }

        if (isset($config['filters']['html'])) {
            $listeners[] = new EventListener\HtmlListener($container['finder'], $this->getHtmlFilter($config));
        }

        if (isset($config['filters']['xml'])) {
            $listeners[] = new EventListener\XmlListener($container['finder'], $this->getXmlFilter($config));
        }

        $eventDispatcher = $carew->getEventDispatcher();
        foreach ($listeners as $listener) {
            $eventDispatcher->addSubscriber($listener);
        }
    }

    private function getCssFilter(array $config)
    {
        $fixBinPath = $this->fixBinPath;
        $filterOptions = $this->filterOptions;

        return function () use ($config, $fixBinPath, $filterOptions) {
            switch ($config['filters']['css']) {
                case 'yui_css':
                    $filterConfig = $config['yui_css'];
                    $isArray = is_array($filterConfig);
                    $filter = new AsseticFilter\Yui\CssCompressorFilter(
                        $fixBinPath($isArray ? $filterConfig['bin'] : $filterConfig),
                        empty($config['java']) ? '/usr/bin/java' : $config['java']
                    );
                    break;

                default:
                    throw new \InvalidArgumentException(sprintf('The "%s" filter does not exists.', $config['filters']['css']));
            }

            $isArray and $filterOptions($filter, $filterConfig['options']);

            return $filter;
        };
    }

    private function getJsFilter(array $config)
    {
        $fixBinPath = $this->fixBinPath;
        $filterOptions = $this->filterOptions;

        return function () use ($config, $fixBinPath, $filterOptions) {
            switch ($config['filters']['js']) {
                case 'yui_js':
                    $filterConfig = $config['yui_js'];
                    $isArray = is_array($filterConfig);

                    $filter = new AsseticFilter\Yui\JsCompressorFilter(
                        $fixBinPath($isArray ? $filterConfig['bin'] : $filterConfig),
                        empty($config['java']) ? '/usr/bin/java' : $config['java']
                    );
                    break;

                default:
                    throw new \InvalidArgumentException(sprintf('The "%s" filter does not exists.', $config['filters']['js']));
            }

            $isArray and $filterOptions($filter, $filterConfig['options']);

            return $filter;
        };
    }

    private function getJpegFilter(array $config)
    {
        $fixBinPath = $this->fixBinPath;
        $filterOptions = $this->filterOptions;

        return function () use ($config, $fixBinPath, $filterOptions) {
            switch ($config['filters']['jpeg']) {
                case 'jpegoptim':
                    $filterConfig = $config['jpegoptim'];
                    $isArray = is_array($filterConfig);

                    $filter = new AsseticFilter\JpegoptimFilter($fixBinPath($isArray ? $filterConfig['bin'] : $filterConfig));
                    break;

                default:
                    throw new \InvalidArgumentException(sprintf('The "%s" filter does not exists.', $config['filters']['jpeg']));
            }

            $isArray and $filterOptions($filter, $filterConfig['options']);

            return $filter;
        };
    }

    private function getHtmlFilter(array $config)
    {
        $fixBinPath = $this->fixBinPath;
        $filterOptions = $this->filterOptions;

        return function () use ($config, $fixBinPath, $filterOptions) {
            switch ($config['filters']['html']) {
                case 'htmlcompressor_html':
                    $filterConfig = $config['htmlcompressor_html'];
                    $isArray = is_array($filterConfig);

                    $filter = new FrancisBessetFilter\Htmlcompressor\HtmlCompressorFilter(
                        $fixBinPath($isArray ? $filterConfig['bin'] : $filterConfig),
                        empty($config['java']) ? '/usr/bin/java' : $config['java']
                    );
                    if ($isArray) {
                        if (isset($filterConfig['options']['jsCompressor']) && 'yui' === $filterConfig['options']['jsCompressor'] && isset($config['yui_js']['options'])) {
                            $filterConfig['options'] = array_merge($config['yui_js']['options'], $filterConfig['options']);
                        }
                    }
                    break;

                default:
                    throw new \InvalidArgumentException(sprintf('The "%s" filter does not exists.', $config['filters']['jpeg']));
            }

            $isArray and $filterOptions($filter, $filterConfig['options']);

            return $filter;
        };
    }

    private function getXmlFilter(array $config)
    {
        $fixBinPath = $this->fixBinPath;
        $filterOptions = $this->filterOptions;

        return function () use ($config, $fixBinPath, $filterOptions) {
            switch ($config['filters']['xml']) {
                case 'htmlcompressor_xml':
                    $filterConfig = $config['htmlcompressor_xml'];
                    $isArray = is_array($filterConfig);

                    $filter = new FrancisBessetFilter\Htmlcompressor\XmlCompressorFilter(
                        $fixBinPath($isArray ? $filterConfig['bin'] : $filterConfig),
                        empty($config['java']) ? '/usr/bin/java' : $config['java']
                    );
                    break;

                default:
                    throw new \InvalidArgumentException(sprintf('The "%s" filter does not exists.', $config['filters']['jpeg']));
            }

            $isArray and $filterOptions($filter, $filterConfig['options']);

            return $filter;
        };
    }
}
