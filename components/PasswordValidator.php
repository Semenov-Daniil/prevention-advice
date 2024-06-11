<?php

namespace app\components;

use yii\validators\Validator;

class PasswordValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Пароль должен содерать одну ЗАГЛАВНУЮ букву, одну СТРОЧНУЮ букву, одну ЦИФРУ, и быть не меньше 6 символов!';
    }

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (!preg_match('/^(?=.*[A-ZА-ЯЁ])(?=.*[a-zа-яё])(?=.*[0-9])[A-ZА-ЯЁa-zа-яё0-9]{6,}$/u', $value)) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
        if (!/^(?=.*[A-ZА-ЯЁ])(?=.*[a-zа-яё])(?=.*[0-9])[A-ZА-ЯЁa-zа-яё0-9]{6,}$/u.test(value)) {
            messages.push($message);
        }
        JS;
    }
}