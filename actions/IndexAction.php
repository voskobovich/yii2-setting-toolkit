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
     * @var string
     */
    public $defaultSection = 'general';

    /**
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        $section = Yii::$app->request->get('section', $this->defaultSection);

        $indexForm = new IndexForm();
        if (!$indexForm->loadBySection($section)) {
            HttpError::the404('Setting section not found');
        }

        $params = Yii::$app->request->post();

        if ($params) {
            $indexForm->load($params, $indexForm->formName());

            if ($indexForm->save()) {
                AlertHelper::success(Yii::t('backend', 'Saved successfully!'));
            } else {
                AlertHelper::error(Yii::t('backend', 'Error saving!'));
            }
        }

        $controller = $this->controller;

        return $controller->render('index', [
            'indexForm' => $indexForm
        ]);
    }
}