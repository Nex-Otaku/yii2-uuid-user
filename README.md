User module with UUID support
=============================
This is a fork of Dektrium user extension, with UUID support.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nex-otaku/yii2-uuid-user "*"
```

or add

```
"nex-otaku/yii2-uuid-user": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \nexotaku\user\AutoloadExample::widget(); ?>```