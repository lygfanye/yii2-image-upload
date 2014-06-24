<?php

namespace troy\ImageUpload;

use yii\base\Action;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use Yii;
use yii\helpers\Json;
use yii\web\JsonResponseFormatter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * UploadAction performs file upload via the ImageUpload widget.
 *
 * Usage:
 *
 * ~~~
 * class SiteController extends Controller
 * {
 *     public function actions()
 *     {
 *         return [
 *             'upload' => [
 *                 'class' => 'troy\ImageUpload\UploadAction',
 *                 'successCallback' => [$this, 'successCallback'],
 *                 'beforeStore' => [$this,'beforeStoreCallback']
 *             ],
 *         ]
 *     }
 *
 *     public function successCallback($file)
 *     {
 *     }
 *     public function beforeStoreCallback($file)
 *     {
 *     }
 * }
 * ~~~
 *
 *
 * @author troyFan <fan_ye@hotmail.com>
 * @since 2.0
 */
class UploadAction extends Action
{

    /**
     * store type for the upload file ,default use troy\ImageUpload\store\Local
     * @var string
     */
    public $store = 'troy\ImageUpload\store\Local';
    /**
     * @var callable PHP callback, which should be triggered in case of successful Upload.
     * This callback should accept[[StoreInterface]] and  [[UploadedFile]] instance as an argument.
     * For example:
     *
     * ~~~
     * public function onAuthSuccess($store,$file)
     * {
     *     // deal upload filed
     * }
     * ~~~
     *
     */
    public $successCallback;
    /**
     * @var callable PHP callback, which should be triggered in case of before Upload.
     * This callback should accept [[UploadedFile]] instance as an argument.
     * For example:
     *
     * ~~~
     * public function onBeforeStore($file)
     * {
     *     // deal upload filed ,such as check the limit for file
     * }
     * ~~~
     *
     */
    public $beforeStoreCallBack;
    /**
     * upload field name ,default `userfile`,you can set this in [[ImageUpload::config['name']]]
     * @var string
     */
    public $uploadName = 'userfile';

    /**
     * the type of the file that allow to upload,default no limit
     * @var string
     */
    public $allowedType = [];

    /**
     * Runs the action.
     */
    public function run()
    {
        $file = UploadedFile::getInstanceByName($this->uploadName);

        if($this->beforeStore($file)){
            $store = new $this->store;
            if($store->store($file)){
                $this->storeSuccess($store,$file);
            }
        }
    }

    /**
     * This method is invoked in case of successful upload via ImageStore Client.
     * @param StoreInterface $store client instance.
     * @throws InvalidConfigException on invalid success callback.
     * @return Response response instance.
     */
    protected function storeSuccess($store,$file)
    {
        if (!is_callable($this->successCallback)) {
            throw new InvalidConfigException('"' . get_class($this) . '::successCallback" should be a valid callback.');
        }
        $response = call_user_func($this->successCallback, $store,$file);
        if ($response instanceof Response) {
            return $response;
        }else{
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->response->content = Json::encode($store->getFileAttributes());
            return Yii::$app->response;
        }
    }

    /**
     * @param $file
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    protected  function beforeStore($file){
        if ( $this->beforeStoreCallBack && !is_callable($this->beforeStoreCallBack)) {
            throw new InvalidConfigException('"' . get_class($this) . '::beforeStoreCallBack" should be a valid callback.');
        }

        return $this->beforeStoreCallBack?call_user_func($this->successCallback,$file):true;
    }
}
