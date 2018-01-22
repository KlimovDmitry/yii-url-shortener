<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShortUrlStatisticsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My URLs statistics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="short-url-statistics-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <a href="/short-url/">Create short URL</a> | <a href="/short-url/links-list/">My short URLs</a>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'url_short:ntext',
            'created_at',
            'geo_data:ntext',
            'user_agent',
        ],
    ]); ?>
</div>
