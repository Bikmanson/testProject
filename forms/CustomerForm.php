<?php


namespace app\forms;


use app\models\Address;
use app\models\Customer;
use elisdn\compositeForm\CompositeForm;
use Yii;

/**
 * Class CustomerForm
 * @package app\forms
 *
 * @property Customer $customer
 * @property Address[] $addresses
 */
class CustomerForm extends CompositeForm
{
    const SCENARIO_CREATE = 'create';

    const SCENARIO_UPDATE = 'update';

    public $password;
    public $passwordRepeat;
    public $customerModel;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();

        if (!$this->customerModel) {
            $this->scenario = self::SCENARIO_CREATE;
            $this->customer = new Customer();
            $this->addresses = [new Address()];
        } else {
            $this->scenario = self::SCENARIO_UPDATE;
            $this->customer = $this->customerModel;
            $this->addresses = $this->customerModel->addresses;
        }
    }

    public function rules()
    {
        return [
            [['password', 'passwordRepeat'], 'required', 'on' => self::SCENARIO_CREATE],
            [['passwordRepeat'], 'required', 'on' => self::SCENARIO_UPDATE, 'whenClient' => "
                return $('#password').val() != false;
            "], // todo: doesn't work - problem with scenarios!
            [['password', 'passwordRepeat'], 'string', 'min' => 6, 'max' => 255],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * @return array of internal forms like ['meta', 'values']
     */
    protected function internalForms()
    {
        return ['customer', 'addresses'];
    }

    public function load($data, $formName = null)
    {
        // to add new addresses for CompositeForm because of DynamicForm widget
        if (is_array($data['Address']) && !empty($data['Address'])) {
            $addresses = [];
            for ($i = 0; $i < count($data['Address']); $i++) {
                $addresses[] = new Address();
            }
            if (!empty($addresses)) $this->addresses = $addresses;
        }

        return parent::load($data, $formName);
    }

    public function save($validation = true)
    {
        if ($validation && !$this->validate()) return false;

        $transaction = Yii::$app->db->beginTransaction();
        $success = false;

        $this->customer->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $this->customer->first_name = ucfirst($this->_forms['customer']->first_name);
        $this->customer->last_name = ucfirst($this->_forms['customer']->last_name);
        if ($success = $this->customer->save() && !empty($this->addresses)) {
            foreach ($this->addresses as $address) {
                /** @var $address Address */
                if (!$success) break;
                $address->customer_id = $this->customer->id;
                $success = $address->save();
            }
        }

        $success ? $transaction->commit() : $transaction->rollBack();
        return $success;
    }

    public function attributeLabels()
    {
        $arr = [
            'passwordRepeat' => 'Повторите пароль'
        ];
        $arr['password'] = $this->scenario === self::SCENARIO_CREATE ? 'Пароль' : 'Изменить пароль';

        return $arr;
    }
}