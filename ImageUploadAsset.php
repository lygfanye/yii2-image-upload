<?php
namespace troy\ImageUpload;

use yii\web\AssetBundle;
class ImageUploadAsset extends AssetBundle
{
    public $sourcePath = '@vendor/troy/yii2-image-upload/assets';
    public $js = [
        'ajaxUpload.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
