<?php

namespace nex_otaku\user;

use dektrium\user\Module as BaseModule;

/**
 * Общая конфигурация модуля "dektrium/yii2-user".
 *
 * @author Nex Otaku <nex@otaku.ru>
 */
class UserBaseModule extends BaseModule
{
    public $modelMap = [
                'User' => 'common\models\User',
                'Profile' => 'nex_otaku\user\models\Profile',
                'Account' => 'nex_otaku\user\models\Account',
                'LoginForm' => 'nex_otaku\user\models\LoginForm',
                'RegistrationForm' => 'nex_otaku\user\models\RegistrationForm',
                'SettingsForm' => 'nex_otaku\user\models\SettingsForm',
                'UserSearch' => 'nex_otaku\user\models\UserSearch',
            ];
    /** @var array Mailer configuration */
    public $mailer = [
        'sender' => 'no-reply@top100photo.ru',
    ];
    
    // Используем email в качестве имени пользователя.
    public $useEmailAsUsername = true;
    // Отключаем аватарки.
    public $enableGravatar = false;
    // Используемые поля профиля.
    public $profileFields = ['name', 'public_email', /*'gravatar_email', 'gravatar_id',*/ 'location', 'website', 'bio'];
    // Безопасное удаление.
    // TODO: встроить бихевиор для SoftDelete в стандартную модель модуля,
    // добавить соотв. поля в миграцию, убрать эту настройку 
    // и настроить бихевиор на работу через обычный "delete".
    public $enableSoftDelete = false;
}
