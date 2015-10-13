# yii2-htmlcompress

Compress HTML output into a single line

## Install

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

try

```
composer require "smilemd/yii2-htmlcompress:*"
```

or add

```
"smilemd/yii2-htmlcompress": "*"
```

to the require section of your `composer.json` file.

## Configure

```
return [
    // ...
    'components' => [
        // ...
        'view' => [
            'class' => '\smilemd\htmlcompress\View',
            'compress' => YII_ENV_DEV ? false : true,
            // ...
        ]
    ]
];
```

By default extension is disabled on DEV environment and enabled on PROD.

Enjoy ;)
