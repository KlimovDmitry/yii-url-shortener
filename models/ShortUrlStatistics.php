<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "short_url_statistics".
 *
 * @property int $id
 * @property string $url_short
 * @property string $created_at
 * @property string $geo_data
 * @property string $user_agent
 *
 * @property ShortUrl $urlShort
 */
class ShortUrlStatistics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'short_url_statistics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url_short', 'geo_data', 'user_agent'], 'required'],
            [['created_at'], 'safe'],
            [['geo_data'], 'string'],
            [['url_short'], 'string', 'max' => 8],
            [['user_agent'], 'string', 'max' => 255],
            [['url_short'], 'exist', 'skipOnError' => true, 'targetClass' => ShortUrl::className(), 'targetAttribute' => ['url_short' => 'url_short']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_short' => 'Url Short',
            'created_at' => 'Created At',
            'geo_data' => 'Geo Data',
            'user_agent' => 'User Agent',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUrlShort()
    {
        return $this->hasOne(ShortUrl::className(), ['url_short' => 'url_short']);
    }
}
