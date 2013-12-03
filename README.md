Assetic plugin for [Carew](http://github.com/carew/carew)
=============================================================

Installation
------------

Install it with composer:

```
composer require francisbesset/carew-assetic
```

Then configure `config.yml`

```
engine:
    extensions:
        - FrancisBesset\Carew\Assetic\AsseticExtension

assetic:
    java: /usr/bin/java
    yui_css:
        bin: /usr/local/Cellar/yuicompressor/2.4.8/libexec/yuicompressor-2.4.8.jar
        options:
            charset:   utf-8
            lineBreak: ~
    yui_js:
        bin: /usr/local/Cellar/yuicompressor/2.4.8/libexec/yuicompressor-2.4.8.jar
        options:
            charset:              utf-8
            lineBreak:            ~
            nomunge:              false
            preserveSemi:         false
            disableOptimizations: false
    jpegoptim:
        bin: /usr/local/bin/jpegoptim
        options:
            stripAll: true
            max:      100
    htmlcompressor_xml:
        bin: /usr/local/Cellar/htmlcompressor/1.5.3/libexec/htmlcompressor-1.5.3.jar
        options:
            preserveComments:     false
            removeIntertagSpaces: true
    htmlcompressor_html:
        bin: /usr/local/Cellar/htmlcompressor/1.5.3/libexec/htmlcompressor-1.5.3.jar
        options:
            preserveComments:        false
            preserveMultiSpaces:     false
            preserveLineBreaks:      false
            removeIntertagSpaces:    true
            removeQuotes:            true
            simpleDoctype:           true
            removeStyleAttr:         true
            removeLinkAttr:          true
            removeScriptAttr:        true
            removeFormAttr:          true
            removeInputAttr:         true
            simpleBoolAttr:          true
            removeJsProtocol:        true
            removeHttpProtocol:      true
            removeHttpsProtocol:     true
            removeSurroundingSpaces: all
            compressJs:              true
            compressCss:             true
            jsCompressor:            yui
    filters:
        css:  yui_css
        js:   yui_js
        jpeg: jpegoptim
        html: htmlcompressor_html
        xml:  htmlcompressor_xml
```
