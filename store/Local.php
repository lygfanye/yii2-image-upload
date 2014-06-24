<?php
/**
 * Created by PhpStorm.
 * User: troyfan
 * Date: 14-6-24
 * Time: 下午4:45
 */
namespace troy\ImageUpload\store;

use troy\ImageUpload\StoreInterface;
use yii\web\UploadedFile;

class Local implements StoreInterface
{
    /**
     * this property must contain two keys with store and url
     * store for the user to store the path to db,the url for the user to display callback
     * @var array
     */
    protected $fileAttributes=[];

    public function store(UploadedFile $file){
        $storePath = \Yii::getAlias('@app/data');
        if($file->saveAs($storePath.'/'.$file->name,true)){
            $this->fileAttributes['store'] = 'data/'.$file->name;
            $this->fileAttributes['url'] = \Yii::$app->urlManager->hostInfo.'/'.$this->fileAttributes['store'];
            return true;
        }
        return false;
    }

    public function getFileAttributes(){
        return $this->fileAttributes;
    }

}