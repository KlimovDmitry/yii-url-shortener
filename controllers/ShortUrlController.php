<?php

namespace app\controllers;

use yii;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\filters\AccessControl;
use \app\models\ShortUrl;
use \app\models\ShortUrlSearch;
use \app\models\ShortUrlStatistics;

class ShortUrlController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Display short URL creation form.
     */
    public function actionIndex()
    {
        $request = yii::$app->request;
        
        if($request->isPost)
        {
            $data = $request->post();
            $ttl = (int)ArrayHelper::getValue($data, 'ttl');
            $url_original = ArrayHelper::getValue($data, 'ShortUrl.url_original');
            
            $model = ShortUrl::generateUnique($url_original, $ttl);
        }
        else
        {
            $model = new ShortUrl;
        }
        
        return $this->render('index', ['model' => $model]);
    }
    
    /**
     * Redirects from short URL to original URL.
     */
    public function actionGo()
    {
        $request = yii::$app->request;
        $id = $request->get('id');
        
        $model = ShortUrl::findIdentity($id);
        if(is_null($model))
        {
            throw new HttpException(404, 'The requested Item could not be found.'); 
        }
        
        $this->logFollowing($id);
        
        yii::$app->response->redirect($model->url_original);
    }
    
    /**
     * Lists all ShortUrl models.
     * @return mixed
     */
    public function actionLinksList()
    {
        $searchModel = new ShortUrlSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('links-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Finds the ShortUrl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ShortUrl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShortUrl::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * @return bool
     */
    protected function logFollowing($url_short)
    {
        $model = new ShortUrlStatistics;
        
        $browser = new \browser\Browser;
        $user_agent = $browser->getBrowser() . ' ' . $browser->getVersion() . ', ' . $browser->getPlatform();
        
        $model->url_short = $url_short;
        $model->created_at = date('Y-m-d H:i:s');
        $model->user_agent = $user_agent;
        $model->geo_data = 'n/a';
        
        $model->save();
        
        return empty($model->getErrors());
    }
}
