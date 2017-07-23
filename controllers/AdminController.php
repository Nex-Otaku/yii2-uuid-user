<?php

namespace nex_otaku\user\controllers;

use dektrium\user\controllers\AdminController as BaseAdminController;
use dektrium\user\Module;
use dektrium\user\models\User;
//use nex_otaku\user_group\Module as GroupModule;
//use yii\helpers\Url;

/**
 * AdminController allows you to administrate users.
 *
 * @property Module $module
 */
class AdminController extends BaseAdminController
{
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($id == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'You can not remove your own account'));
        } else {
            $model = $this->findModel($id);
            $event = $this->getUserEvent($model);
            $this->trigger(self::EVENT_BEFORE_DELETE, $event);
            $model->delete();
            $this->trigger(self::EVENT_AFTER_DELETE, $event);
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been deleted'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var User $user */
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
        ]);
        $event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        $this->trigger(self::EVENT_BEFORE_CREATE, $event);
        $loaded = $user->load(\Yii::$app->request->post());
        if ($loaded) {
            $user->username = $user->email;
            if ($user->create()) {
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been created'));
                $this->trigger(self::EVENT_AFTER_CREATE, $event);
                return $this->redirect(['update', 'id' => $user->id]);
            }
        }

        return $this->render('create', [
            'user' => $user,
        ]);
    }
    
//    /**
//     * Редактирование группы пользователя.
//     *
//     * @param int $id
//     *
//     * @return mixed
//     */
//    public function actionUpdateGroup($id)
//    {
//        // TODO вынести в отдельный плагин, 
//        // который будет находиться в модуле yii2-user-group
//        // и цепляться к этому контроллеру автоматически.
//        
//        $groupModule = $this->getGroupModule();
//        if (empty($groupModule)) {
//            return $this->redirect(['index']);
//        }
//        Url::remember('', 'actions-redirect');
//        $user    = $this->findModel($id);
//        $group = $groupModule->storage->getGroupByUserId($id);
//
//        if (empty($group)) {
//            $group = $groupModule->storage->makeNewGroupForUserWithId($id);
//        }
//
//        $this->performAjaxValidation($group);
//
//        if ($group->load(\Yii::$app->request->post()) && $group->save()) {
//            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Group details have been updated'));
//            return $this->refresh();
//        }
//
//        return $this->render('_group', [
//            'user'    => $user,
//            'group' => $group,
//            'groupList' => $groupModule->group->groupsForDropDown,
//        ]);
//    }
//    
//    private function getGroupModule()
//    {
//        // Так как модуль в целях разработки подключен напрямую,
//        // а не через расширение, отключаем временно этот код.
//        //if (!isset(Yii::$app->extensions['nex-otaku/yii2-user-group'])) {
//        //    return false;
//        //}
//        return GroupModule::getOverloadedInstance();
//    }
}
