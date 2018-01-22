<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShortUrlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My URLs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="short-url-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <a href="/short-url/">Create short URL</a> | <a href="/short-url-statistics/">My short URLs statistics</a>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'url_short:ntext',
            'url_original:url',
            'created_at',
            'expire_at',
        ],
    ]); ?>
</div>
