<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ShortUrl */
/* @var $form ActiveForm */

$this->title = $model->getId() && !$model->getErrors() ? 'Short URL successfully created' : 'Add new short URL';
$this->params['breadcrumbs'][] = 'Create shorl URL';
?>
<div class="short-url-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <a href="/short-url/links-list/">My short URLs</a> | <a href="/short-url-statistics/">My short URLs statistics</a>
    </p>

<?php if(!$model->getId() || $model->getErrors()): ?>
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'url_original') ?>
        <div class="form-group">
            <label class="control-label">TTL</label>
            <?= Html::dropDownList('ttl', null, [null => $model->getTtlOptions()]) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
<?php else: ?>
    <?= Html::textInput('url_short', $model->getShortUrl()) ?>
    <br />
    URL will expire at <?= $model->expire_at ?>
    <br />
<?php endif; ?>
</div><!-- short-url-index -->
