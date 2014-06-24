<?php
/**
 * Created by PhpStorm.
 * User: troyfan
 * Date: 14-6-24
 * Time: 下午4:40
 */

namespace troy\ImageUpload;

use yii\web\UploadedFile;

interface StoreInterface{

    public function store(UploadedFile $file);

    public function getFileAttributes();

}