<?php

namespace troy\ImageUpload;

use Yii;
use yii\helpers\Json;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * usage:
 * ```php
 *     \troy\ImageUpload\ImageUpload::widget([
 *         'targetId' => 'imageUpload',
 *         'config' =>[
 *             'action' =>Yii::$app->getUrlManager()->createUrl(['site/index'])
 *         ]
 *      ]
 * )
 *  ```
 *
 * @see http://valums.com/ajax-upload/
 *
 * @author troyfan <fan_ye@hotmail.com>
 * @since 2.0
 */
class ImageUpload extends \yii\base\Widget
{
    public $targetId = "#button";

    public $config = [];

    public $onSubmitFunction = '';

    /**
     * you can set the config['action'] or set this baseAuthUrl
     * if the config['action'] is empty we use the property baseAuthUrl
     * @var array
     */
    public $baseAuthUrl = ['site/upload'];

    public $allowedExtensions = "jpg|jpeg|gif|png|gif";

    public function run()
    {
        $this->dealConfig();
        $this->registerAssets();
    }

    /**
     * @throws InvalidConfigException if [[config]] is invalid
     */
    protected function dealConfig(){

        if(empty($this->config['action']) && !$this->baseAuthUrl)
            throw new InvalidConfigException ('route can not empty');
        if(empty($this->allowedExtensions))
            throw new InvalidConfigException('allowedExtensions cant not empty');

        $request = Yii::$app->getRequest();
        if($request->enableCsrfValidation){
            $this->config['data'][$request->csrfParam] = $request->getCsrfToken();
        }

        if(empty($this->config['action']) && $this->baseAuthUrl)
            $this->config['action'] = Url::toRoute($this->baseAuthUrl);

        $this->config['onSubmit']= new JsExpression('function (id, ext){if (!(ext && /^('.$this->allowedExtensions.')$/.test(ext))){alert("extensions must in '.$this->allowedExtensions.'"); return false;}'. 
            ($this->onSubmitFunction?' return  '.$this->onSubmitFunction:'')
            .'}');
    }

    protected function registerAssets(){
        $view = $this->getView();
        ImageUploadAsset::register($view);

        $config = Json::encode($this->config);
        $js = "new AjaxUpload('$this->targetId',$config)";
        $view->registerJs($js);
    }
}
