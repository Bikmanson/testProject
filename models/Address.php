<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property int $id
 * @property int $post_index
 * @property string $country
 * @property string $city
 * @property string $street
 * @property int $house_number
 * @property int|null $office_number
 * @property int $customer_id
 *
 * @property Customer $customer
 */
class Address extends \yii\db\ActiveRecord
{
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
        return '{{%address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // customer_id - required field but it is not set to required rule because of composite form
        return [
            [['post_index', 'country', 'city', 'street', 'house_number'], 'required'],
            [['office_number', 'customer_id', 'created_at', 'updated_at'], 'integer'],
            [['house_number'], 'string', 'max' => 5],
            [['house_number'], 'houseNumberValidator'],
            [['country'], 'string', 'min' => 2, 'max' => 2],
            [['country'], 'countryValidator'],
            [['post_index'], 'string', 'min' => 5, 'max' => 5],
            [['post_index'], 'postIndexValidator'],
            [['city', 'street'], 'string', 'max' => 255],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    public function postIndexValidator($attribute)
    {
        $result = ctype_digit($this->$attribute);
        if (!$result) $this->addError($attribute, $this->getAttributeLabel($attribute)." может содержать только цыфры.");
        return $result;
    }

    public function countryValidator($attribute)
    {
        $this->$attribute = strtoupper($this->$attribute);

        $result = ctype_upper($this->$attribute);
        if (!$result) $this->addError($attribute, $this->getAttributeLabel($attribute)." может содержать только буквы.");
        return $result;
    }

    public function houseNumberValidator($attribute)
    {
        $result = ctype_alnum($this->$attribute);
        if (!$result) $this->addError($attribute, $this->getAttributeLabel($attribute)." может содержать только буквы и цыфры.");
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_index' => 'Почтовый индекс',
            'country' => 'Страна',
            'city' => 'Город',
            'street' => 'Улица',
            'house_number' => 'Номер дома',
            'office_number' => 'Номер офиса/квартиры',
            'customer_id' => 'Customer ID',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'id']);
    }
}
