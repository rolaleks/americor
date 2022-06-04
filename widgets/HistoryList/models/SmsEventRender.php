<?php


namespace app\widgets\HistoryList\helpers\models;


use app\models\Event;
use app\models\History;
use app\models\Sms;
use app\widgets\HistoryList\helpers\HistoryListHelper;
use Yii;
use yii\base\View;

class SmsEventRender implements EventRenderInterface
{

    public function render(View $view, History $history)
    {
        echo $view->render('_item_common', [
            'user' => $history->user,
            'body' => $this->getBody($history),
            'footer' => $history->sms->direction == Sms::DIRECTION_INCOMING ?
                Yii::t('app', 'Incoming message from {number}', [
                    'number' => $history->sms->phone_from ?? ''
                ]) : Yii::t('app', 'Sent message to {number}', [
                    'number' => $history->sms->phone_to ?? ''
                ]),
            'iconIncome' => $history->sms->direction == Sms::DIRECTION_INCOMING,
            'footerDatetime' => $history->ins_ts,
            'iconClass' => 'icon-$history bg-dark-blue'
        ]);
    }

    public function getBody(History $history)
    {
        return $history->sms->message ? $history->sms->message : '';
    }

    public static function getEventTypes(): array
    {
        return [
            Event::EVENT_INCOMING_SMS,
            Event::EVENT_OUTGOING_SMS,
        ];
    }
}