<p align="center">
    <a href="https://www.smarty.net/" target="_blank">
        <img src="https://www.smarty.net/images/logo.png" height="74px">
    </a>
    <h1 align="center">Smarty Extension for Yii 2</h1>
    <br>
</p>

This extension provides a `ViewRender` that would allow you to use [Smarty](http://www.smarty.net/) view template engine
with [Yii framework 2.0](http://www.yiiframework.com).

For license information check the [LICENSE](LICENSE.md)-file.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-smarty/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-smarty)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-smarty/downloads.png)](https://packagist.org/packages/yiisoft/yii2-smarty)
[![Build Status](https://travis-ci.org/yiisoft/yii2-smarty.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-smarty)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisoft/yii2-smarty
```

or add

```json
"yiisoft/yii2-smarty": "~2.0.0"
```

to the require section of your composer.json.

Note that the smarty composer package is distributed using subversion so you may need to install subversion.

Usage
-----

To use this extension, simply add the following code in your application configuration:

```php
return [
    //....
    'components' => [
        'view' => [
            'renderers' => [
                'tpl' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    //'cachePath' => '@runtime/Smarty/cache',
                ],
            ],
        ],
    ],
];
```
