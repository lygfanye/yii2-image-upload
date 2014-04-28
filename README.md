ajaxImageUpload
===============
upload image via ajax

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist troy/yii2-image-upload "*"
```

or add

```
"troy/yii2-image-upload": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \troy\ImageUpload\ImageUpload::widget(
    [
         'targetId' => 'imageUpload',//html dom id
         'config' =>[
             'action' =>Yii::$app->getUrlManager()->createUrl(['site/index'])
         ]
    ]
); ?>```