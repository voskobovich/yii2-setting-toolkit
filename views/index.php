<?php

use yii\bootstrap\ActiveForm;
use voskobovich\alert\widgets\Alert;
use yii\widgets\Menu;


/**
 * @var \yii\web\View $this
 * @var \voskobovich\admin\setting\forms\IndexForm $model
 * @var array[] $menuItems
 */

$this->title = Yii::t('backend', 'Settings');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Alert::widget(); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="nav-tabs-custom">
            <?= Menu::widget([
                'options' => ['class' => 'nav nav-tabs'],
                'items' => $menuItems,
            ]) ?>
            <div class="tab-content">
                <div class="tab-pane active">
                    <?php $form = ActiveForm::begin([
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'horizontalCssClasses' => [
                                'offset' => 'col-sm-offset-3',
                                'label' => 'col-sm-2',
                                'wrapper' => 'col-sm-7',
                                'error' => '',
                                'hint' => 'col-sm-3',
                            ],
                        ],
                    ]); ?>

                    <?= $this->render('_fields.php', [
                        'form' => $form,
                        'model' => $model
                    ]); ?>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">
                                <?= Yii::t('general', 'Update') ?>
                            </button>
                        </div>
                    </div>

                    <?php $form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>