<?php

namespace voskobovich\admin\setting\actions;

use voskobovich\admin\setting\forms\IndexForm;
use voskobovich\alert\helpers\AlertHelper;
use voskobovich\base\helpers\HttpError;
use Yii;
use yii\base\Action;


/**
 * Class IndexAction
 * @package givoskobovich\admin\setting\actions
 */
class IndexAction extends Action
{
    /**
     * @param string $section
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($section = 'general')
    {
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

        return $controller->render('index', [
            'model' => $model
        ]);
    }
}