<?php

namespace app\models;

use Yii;
use yii\base\UserException;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "short_url".
 *
 * @property int $id
 * @property string $url_short
 * @property string $url_original
 * @property int $user_id
 * @property string $created_at
 * @property string $expire_at
 *
 * @property User $user
 * @property ShortUrlStatistics[] $shortUrlStatistics
 */
class ShortUrl extends \yii\db\ActiveRecord
{
    const URI_LENGTH = 8;
    const TTL_DEFAULT = 86400 * 7;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'short_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url_original', 'user_id'], 'required'],
            [['url_original'], 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https',]],
            [['user_id'], 'integer'],
            [['created_at', 'expire_at'], 'safe'],
            [['url_short'], 'string', 'max' => 8],
            [['url_short'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'url_original' => 'Url Original',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'expire_at' => 'Expire At',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($url_short)
    {
        return static::findOne(['url_short' => $url_short,]);
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    /**
     * @return string
     */
    public function getShortUrl()
    {
        if(!$this->getId())
        {
            return null;
        }
        
        $url_manager = yii::$app->urlManager;
        
        return $url_manager->createAbsoluteUrl('su/' . $this->url_short);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShortUrlStatistics()
    {
        return $this->hasMany(ShortUrlStatistics::className(), ['url_short' => 'url_short']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getByUserId($user_id)
    {
        return static::find(['user_id' => $user_id,])->all();
    }
    
    /**
     * @return mixed
     */
    public function getTtlOptions()
    {
        return [
            86400 => 'day',
            86400 * 7 => 'week',
            86400 * 30 => 'month',
            86400 * 90 => '3 months',
        ];
    }
    
    /**
     * @return \app\models\ShortUrl
     */
    public static function generateUnique($url_original, $ttl)
    {
        $model = new self;
        $ttl = (int)$ttl ?: self::TTL_DEFAULT;
        
        $model->user_id = yii::$app->user->id;
        $model->url_original = $url_original;
        $model->created_at = date('Y-m-d H:i:s');
        $model->expire_at = date('Y-m-d H:i:s', (time() + $ttl));
        $model->save();
        
        $model->url_short = \helpers\Base62::decToBase62($model->getId());
        $model->save();
        
        return $model;
    }
}
