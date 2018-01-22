<?php

namespace app\controllers;

use Yii;
use app\models\ShortUrlStatistics;
use app\models\ShortUrlStatisticsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ShortUrlStatisticsController extends Controller
{
    /**
     * Lists all ShortUrlStatistics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShortUrlStatisticsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the ShortUrlStatistics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShortUrlStatistics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShortUrlStatistics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
