<?php

namespace voskobovich\admin\setting\actions;

use voskobovich\admin\setting\forms\IndexForm;
use voskobovich\alert\helpers\AlertHelper;
use voskobovich\base\helpers\HttpError;
use Yii;
use yii\base\Action;


/**
 * Class IndexAction
 * @package voskobovich\admin\setting\actions
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
    public $viewFile = '@vendor/voskobovich/yii2-admin-setting-toolkit/views/index.php';

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
                AlertHelper::success(Yii::t('backend', 'Saved successfully!'));
            } else {
                AlertHelper::error(Yii::t('backend', 'Error saving!'));
            }
        }

        $controller = $this->controller;

        return $controller->render($this->viewFile, [
            'model' => $model,
            'menuItems' => $this->menuItems
        ]);
    }
}