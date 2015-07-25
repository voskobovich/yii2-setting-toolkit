<?php

use vova07\imperavi\Widget;

/**
 * @var \yii\web\View $this
 * @var \voskobovich\admin\setting\models\Setting $settingModel
 * @var \voskobovich\admin\setting\forms\IndexForm $indexForm
 * @var \yii\widgets\ActiveForm $form
 */
?>

<?php foreach ($indexForm->getSettings() as $key => $settingModel) : ?>
    <?php $field = $form->field($indexForm, $key); ?>

    <?php if ($settingModel->type == $settingModel::TYPE_TEXT_AREA): ?>
        <?php $field = $field->textarea(['rows' => 8]); ?>
    <?php elseif ($settingModel->type == $settingModel::TYPE_EDITOR): ?>
        <?php $field = $field->widget(Widget::className(), [
            'settings' => [
                'lang' => 'en',
                'minHeight' => 200,
                'plugins' => [
                    'fontcolor',
                    'fontfamily',
                    'fontsize',
                    'clips',
                    'fullscreen',
                    'counter',
                    'imagemanager',
                    'table',
                    'video',
                    'textexpander',
                ]
            ]
        ]); ?>
    <?php elseif ($settingModel->type == $settingModel::TYPE_SELECT_BOX): ?>
        <?php $field = $field->dropDownList($settingModel->getVariants()); ?>
    <?php elseif ($settingModel->type == $settingModel::TYPE_SELECT_BOX_MULTIPLE): ?>
        <?php $field = $field
            ->dropDownList($settingModel->getVariants(), ['multiple' => true]); ?>
    <?php elseif ($settingModel->type == $settingModel::TYPE_CHECK_BOX): ?>
        <?php $field = $field->checkbox(); ?>
    <?php elseif ($settingModel->type == $settingModel::TYPE_RADIO): ?>
        <?php $field = $field->radio(); ?>
    <?php elseif ($settingModel->type == $settingModel::TYPE_RADIO_LIST): ?>
        <?php $field = $field->radioList($settingModel->getVariants()); ?>
    <?php endif; ?>

    <?= $field->hint($settingModel->hint); ?>
<?php endforeach; ?>