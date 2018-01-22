<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ShortUrl;

/**
 * ShortUrlSearch represents the model behind the search form of `app\models\ShortUrl`.
 */
class ShortUrlSearch extends ShortUrl
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url_short', 'url_original', 'created_at', 'expire_at'], 'safe'],
            [['user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ShortUrl::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => yii::$app->user->id,
            'created_at' => $this->created_at,
            'expire_at' => $this->expire_at,
        ]);

        $query->andFilterWhere(['like', 'url_short', $this->url_short])
            ->andFilterWhere(['like', 'url_original', $this->url_original]);

        return $dataProvider;
    }
}
