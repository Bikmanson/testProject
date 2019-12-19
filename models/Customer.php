<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property string $login
 * @property string $password_hash
 * @property string $first_name
 * @property string $last_name
 * @property int $sex
 * @property int $created_at
 * @property string $email
 *
 * @property Address[] $addresses
 * @property array $sexMap
 */
class Customer extends \yii\db\ActiveRecord
{
    const SEX_MAN = 1;
    const SEX_WOMAN = 2;
    const SEX_UNDEFINED = 3;

    public function behaviors()
    {
        return ArrayHelper::merge([
            'class' => TimestampBehavior::className()
        ], parent::behaviors());
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // password_hash - required field but it is not set to required rule because of composite form
        // created_at - is required but not set here because of timestamp behavior
        return [
            [['login', 'first_name', 'last_name', 'sex', 'email'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['sex'], 'in', 'range' => array_keys($this->getSexMap())],
            [['password_hash', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['login'], 'string', 'min' => 4, 'max' => 255],
            [['email'], 'email'],
            [['login'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    public function getSexMap()
    {
        return [
            self::SEX_MAN => 'Мужской',
            self::SEX_WOMAN => 'Женский',
            self::SEX_UNDEFINED => 'Неопределено'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password_hash' => 'Password Hash',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'sex' => 'Пол',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['id' => 'id']);
    }
}
