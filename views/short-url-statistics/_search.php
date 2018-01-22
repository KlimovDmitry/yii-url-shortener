<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ShortUrlStatisticsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="short-url-statistics-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'url_short') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'geo_data') ?>

    <?= $form->field($model, 'user_agent') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
