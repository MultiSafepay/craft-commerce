<?php declare(strict_types=1);


namespace multisafepay\multisafepay\controllers;

use Craft;
use craft\commerce\Plugin as Commerce;
use craft\web\Controller;
use multisafepay\multisafepay\MultiSafepay;
use yii\web\Response;

class SettingsController extends Controller
{
    /**
     * @return \yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionGeneralSettings(): Response
    {
        $this->requireCpRequest();

        $settings = MultiSafepay::getInstance()->getSettings();

        return $this->renderTemplate('multisafepay/settings', [
            'settings' => $settings,
            'orderStatuses' => $this->getOrderStatuses(),
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionOrderStatusSettings(): Response
    {
        $this->requireCpRequest();

        $settings = MultiSafepay::getInstance()->getSettings();

        return $this->renderTemplate('multisafepay/settings/order-status', [
            'settings' => $settings,
            'orderStatuses' => $this->getOrderStatuses(),
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws \craft\errors\MissingComponentException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionSaveSettings(): Response
    {
        $this->requirePostRequest();

        $params = Craft::$app->getRequest()->getBodyParams();
        $settingsParams = $params['settings'];

        $settings = MultiSafepay::getInstance()->getSettings();

        $settings->apiKey = $settingsParams['apiKey'] ?? $settings->apiKey;
        $settings->testMode = $settingsParams['testMode'] ?? $settings->testMode;
        $settings->statusShipped = $settingsParams['statusShipped'] ?? $settings->statusShipped;
        $settings->orderStatusInitialized = $settingsParams['orderStatusInitialized'] ?? $settings->orderStatusInitialized;
        $settings->orderStatusUncleared = $settingsParams['orderStatusUncleared'] ?? $settings->orderStatusUncleared;
        $settings->orderStatusReserved = $settingsParams['orderStatusReserved'] ?? $settings->orderStatusReserved;
        $settings->orderStatusVoid = $settingsParams['orderStatusVoid'] ?? $settings->orderStatusVoid;
        $settings->orderStatusDeclined = $settingsParams['orderStatusDeclined'] ?? $settings->orderStatusDeclined;
        $settings->orderStatusChargeback = $settingsParams['orderStatusChargeback'] ?? $settings->orderStatusChargeback;
        $settings->orderStatusRefunded = $settingsParams['orderStatusRefunded'] ?? $settings->orderStatusRefunded;
        $settings->orderStatusExpired = $settingsParams['orderStatusExpired'] ?? $settings->orderStatusExpired;
        $settings->orderStatusPartialRefunded = $settingsParams['orderStatusPartialRefunded'] ?? $settings->orderStatusPartialRefunded;
        $settings->orderStatusCompleted = $settingsParams['orderStatusCompleted'] ?? $settings->orderStatusCompleted;

        if (!$settings->validate()) {
            Craft::$app->getSession()->setError(Plugin::t('Couldn’t save settings.'));
            return $this->renderTemplate('multisafepay/settings', compact('settings'));
        }

        $pluginSettingsSaved = Craft::$app->getPlugins()->savePluginSettings(MultiSafepay::getInstance(), $settings->toArray());

        if (!$pluginSettingsSaved) {
            Craft::$app->getSession()->setError(MultiSafepay::t('Couldn’t save settings.'));
            return $this->renderTemplate('multisafepay/settings', compact('settings'));
        }

        Craft::$app->getSession()->setNotice('Settings saved');

        return $this->redirectToPostedUrl();
    }

    /**
     * @return array
     */
    protected function getOrderStatuses()
    {
        $orderStatuses = Commerce::getInstance()->getOrderStatuses()->getAllOrderStatuses();
        $orderStatusList = [];
        foreach ($orderStatuses as $orderStatus) {
            $orderStatusList[$orderStatus->id] = $orderStatus->name;
        }

        return $orderStatusList;
    }
}
