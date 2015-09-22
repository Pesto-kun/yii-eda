<?php
/**
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use \app\rbac\UserGroupRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = \Yii::$app->authManager;

        // Create roles
        $guest  = $authManager->createRole('guest');
        $admin  = $authManager->createRole('admin');
        $manager  = $authManager->createRole('manager');
        $restaurant = $authManager->createRole('restaurant');
        $delivery = $authManager->createRole('delivery');

        // Create simple, based on action{$NAME} permissions
        $index = $authManager->createPermission('index');
        $create = $authManager->createPermission('create');
        $view = $authManager->createPermission('view');
        $update = $authManager->createPermission('update');
        $delete = $authManager->createPermission('delete');

        //other permissions
        $manage = $authManager->createPermission('manage');
        $manageOrders = $authManager->createPermission('manageOrders');

        // Add permissions in Yii::$app->authManager
        $authManager->add($index);
        $authManager->add($create);
        $authManager->add($view);
        $authManager->add($update);
        $authManager->add($delete);
        $authManager->add($manage);
        $authManager->add($manageOrders);

        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);

        // Add rule "UserGroupRule" in roles
        $guest->ruleName  = $userGroupRule->name;
        $manager->ruleName  = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;
        $restaurant->ruleName  = $userGroupRule->name;
        $delivery->ruleName  = $userGroupRule->name;

        // Add roles in Yii::$app->authManager
        $authManager->add($guest);
        $authManager->add($manager);
        $authManager->add($admin);
        $authManager->add($restaurant);
        $authManager->add($delivery);

        // Add permission-per-role in Yii::$app->authManager
        // Guest
        $authManager->addChild($guest, $view);

        // Restaurant
        $authManager->addChild($restaurant, $guest);

        // Delivery
        $authManager->addChild($delivery, $guest);

        // manager
        $authManager->addChild($manager, $index);
        $authManager->addChild($manager, $create);
        $authManager->addChild($manager, $update);
        $authManager->addChild($manager, $manage);
        $authManager->addChild($manager, $guest);

        // Admin
        $authManager->addChild($admin, $delete);
        $authManager->addChild($admin, $manageOrders);
        $authManager->addChild($admin, $manager);
    }
}