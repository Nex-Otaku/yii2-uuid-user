<?php

namespace nex_otaku\user;

use Yii;

/**
 * Конфигурация модуля "dektrium/yii2-user" для бэкенда.
 *
 * @author Nex Otaku <nex@otaku.ru>
 */
class UserBackendModule extends UserBaseModule
{
    public $adminPermission = 'administrator';
    public $urlRules = [
                // Профиль
                [
                    'class' => 'nex_otaku\uuid\classes\UuidUrlRule',
                    'pattern' => '<id:@uuid@>',
                    'route' => 'profile/show',
                ],
                // Вход настроен по маршруту "sign-in" в бэкенде.
                // Поэтому здесь остался только "logout".
                'logout'                => 'security/logout',
                '<action:(register|resend)>'             => 'registration/<action>',
                [
                    'class' => 'nex_otaku\uuid\classes\UuidUrlRule',
                    'pattern' => 'confirm/<id:@uuid@>/<code:[A-Za-z0-9_-]+>',
                    'route' => 'registration/confirm',
                ],
                'forgot'                                 => 'recovery/request',
                [
                    'class' => 'nex_otaku\uuid\classes\UuidUrlRule',
                    'pattern' => 'recover/<id:@uuid@>/<code:[A-Za-z0-9_-]+>',
                    'route' => 'recovery/reset',
                ],
                'settings/<action:\w+>'                  => 'settings/<action>'
            ];
    
    public $controllerMap = [
        'admin'    => 'nex_otaku\user\controllers\AdminController',
        'settings'    => 'nex_otaku\user\controllers\SettingsController',
        'registration' => 'nex_otaku\user\controllers\RegistrationController',
        'security' => 'nex_otaku\user\controllers\SecurityController',
        'recovery' => 'dektrium\user\controllers\RecoveryController',
        'profile' => 'dektrium\user\controllers\ProfileController',
    ];
    
    public function init()
    {
        parent::init();
        
        // В теме оформления AdminLTE есть два основных шаблона.
        // Один для гостей, другой для залогиненных пользователей.
        // Выбираем подходящий шаблон.
        if ($this->useAdminLTE) {
            Yii::$app->on('beforeRequest', function ($event) {
                Yii::$app->layout = Yii::$app->user->isGuest ? 
                    '@app/views/layouts/main-login' :
                    '@app/views/layouts/main';
            });
        }
    }
}
