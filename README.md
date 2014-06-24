ajaxImageUpload
===============
upload image via ajax

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist troy/yii2-image-upload ""
```

or add

```
"troy/yii2-image-upload": ""
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :


```html
<a id="imageUpload" href="javascript:;">上传图片</a>
```


```php
<?= \troy\ImageUpload\ImageUpload::widget(
    [
         'targetId' => 'imageUpload',//html dom id
         'config' =>[
             'action' =>Yii::$app->getUrlManager()->createUrl(['site/index'])
         ]
    ]
); ?>
```

You also can add some events for it such as onComplete function

```php

<?=
.....
use yii\web\JsExpression;
.....

\troy\ImageUpload\ImageUpload::widget(
    [
         'targetId' => 'imageUpload',//html dom id
         'config' =>[
             'action' =>Yii::$app->getUrlManager()->createUrl(['site/index']),
             'onComplete' => new JsExpression("function(fileName, responseJSON){ something todo...... }")
         ]
    ]
);

?>

```

if you want to the the UploadAction in this ext you can use :

```

 class SiteController extends Controller
  {
      public function actions()
      {
          return [
              'upload' => [
                  'class' => 'troy\ImageUpload\UploadAction',
                  'successCallback' => [$this, 'successCallback'],
                  'beforeStoreCallback' => [$this,'beforeStoreCallback']
              ],
          ]
      }
 
      public function successCallback($store,$file)
      {
      }
      public function beforeStoreCallback($file)
      {
      }
  }

```
