<?php

namespace nex_otaku\user;

use dektrium\user\Module as BaseModule;
use Yii;
use yii\base\Theme;

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
    // Используем тему оформления AdminLTE.
    public $useAdminLTE = true;

    public function init()
    {
        $this->overrideViews();
        parent::init();
    }
    
    protected function overrideViews()
    {
        $theme = isset(Yii::$app->view->theme) ? Yii::$app->view->theme : new Theme();
        $pathMap = isset($theme->pathMap) ? $theme->pathMap : [];
        $pathMap = array_merge($pathMap, [
                    '@dektrium/user/views' => [
                        // Переопределяем
                        '@nex_otaku/user/views',
                        // Путь по умолчанию
                        '@dektrium/user/views',
                    ]
            ]);
        $theme->pathMap = $pathMap;
        Yii::$app->view->theme = $theme;
    }
}
