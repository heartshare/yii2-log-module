<?php
/**
 * Error class file.
 * @copyright (c) 2015, Bariev Pavel
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
 
namespace bariew\logModule\models;

use bariew\abstractModule\models\AbstractModel;
use Yii;
use yii\db\ActiveRecord;
use yii\log\Logger;

/**
 * This is the model class for table "log_error".
 *
 * @property integer $id
 * @property integer $level
 * @property string $category
 * @property integer $log_time
 * @property string $prefix
 * @property string $message
 * @property boolean $active Whether error is fixed.
 */
class Error extends AbstractModel
{
    /**
     * @var string data of application request log.
     * It is being written to db in the same moment as exception log.
     */
    public $request;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'log_time'], 'integer'],
            [['category', 'prefix'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       =>  Yii::t('modules/log', 'Id'),
            'level'    =>  Yii::t('modules/log', 'Level'),
            'category' =>  Yii::t('modules/log', 'Category'),
            'log_time' =>  Yii::t('modules/log', 'Log Time'),
            'prefix'   =>  Yii::t('modules/log', 'Prefix'),
            'message'  =>  Yii::t('modules/log', 'Message'),
        ];
    }


    public function levelList()
    {
        return [
            Logger::LEVEL_ERROR         => 'ERROR',
            Logger::LEVEL_WARNING       => 'WARNING',
            Logger::LEVEL_INFO          => 'INFO',
            Logger::LEVEL_TRACE         => 'TRACE',
            Logger::LEVEL_PROFILE       => 'PROFILE',
            Logger::LEVEL_PROFILE_BEGIN => 'PROFILE_BEGIN',
            Logger::LEVEL_PROFILE_END   => 'PROFILE_END',
        ];
    }

    public function getLevelName()
    {
        return static::levelList()[$this->level];
    }

    /**
     * @return \static
     */
    public function getErrorQuery()
    {
        return static::find()->where([
            'id'        => $this->id + 1,
            'category'  => 'application'
        ])->one();
    }

    public function getAppMessage()
    {
        if (!$model = $this->getErrorQuery()) {
            return "";
        }
        $message =  preg_replace([
            '/(\$\_\w+)\s\=\s/',
            '/\[/',
            '/\]/',
            '/\=>/',
            '/([\}\d\]\'])\s+\'/', // inserting comma
            '/\'/',
            '/\"\s(\d+\s\:)/',
            '/(\d+)\s\:/',
        ], [
            ', "$1" : ',
            '{',
            '}',
            ':',
            '$1, \'',
            '"',
            '", $1',
            '"$1" :',
        ], $model->message);
        $message = '{' . preg_replace('/^,/', '', $message) . "}";
        $data = json_decode($message, true);
        if (json_last_error()) {
            return $model->message;
        }
        unset($data['$_COOKIE']);
        unset($data['$_SESSION']);
        return var_export($data, true);
    }

    public function getUrl($string = null)
    {
        $string = ($string === null) ? @$this->getErrorQuery()->message : $string;
        $prefix = preg_match('/.*\'HTTPS\' => \'(.*)\'.*/', $string, $prefix)
            ? empty($prefix[1]) ? 'http://' : 'https://' : '';
        $serverName = preg_match('/.*\'HTTP_HOST\' => \'(.*)\'.*/', $string, $serverName)
            ? $serverName[1] : '';
        $requestUri = preg_match('/.*\'REQUEST_URI\' => \'(.*)\'.*/', $string, $matches)
            ? $matches[1] : '';
        return $prefix . $serverName . $requestUri;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        if ($model = $this->getErrorQuery()) {
            $model->delete();
        }
    }
}
