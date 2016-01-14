<?php

namespace voskobovich\setting\actions;

use voskobovich\setting\forms\IndexForm;
use voskobovich\base\helpers\HttpError;
use Yii;
use yii\base\Action;


/**
 * Class IndexAction
 * @package voskobovich\setting\actions
 */
class IndexAction extends Action
{
    /**
     * Menu Items
     * @var array
     */
    public $menuItems = [];

    /**
     * @var string
     */
    public $defaultSection = 'general';

    /**
     * View file
     * @var string
     */
    public $viewFile = '@vendor/voskobovich/yii2-setting-toolkit/src/views/index.php';

    /**
     * @var callable|null;
     */
    public $successCallback;

    /**
     * @var callable|null;
     */
    public $errorCallback;

    /**
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        $section = Yii::$app->request->get('section', $this->defaultSection);

        $model = new IndexForm();
        if (!$model->loadBySection($section)) {
            HttpError::the404('Setting section not found');
        }

        $params = Yii::$app->request->post();

        if ($params) {
            $model->load($params, $model->formName());

            if ($model->save()) {
                if ($this->successCallback) {
                    call_user_func($this->successCallback, $model);
                } else {
                    Yii::$app->session->setFlash('index:success');
                }
            } else {
                if ($this->errorCallback) {
                    call_user_func($this->errorCallback, $model);
                } else {
                    Yii::$app->session->setFlash('index:error');
                }
            }
        }

        $controller = $this->controller;

        return $controller->render($this->viewFile, [
            'model' => $model,
            'menuItems' => $this->menuItems
        ]);
    }
}