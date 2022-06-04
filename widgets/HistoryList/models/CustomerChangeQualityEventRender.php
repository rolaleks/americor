<?php


namespace app\widgets\HistoryList\helpers\models;


use app\models\Customer;
use app\models\Event;
use app\models\History;
use yii\base\View;

class CustomerChangeQualityEventRender implements EventRenderInterface
{

    public function render(View $view, History $history)
    {
        echo $view->render('_item_statuses_change', [
            'model' => $history,
            'oldValue' => Customer::getQualityTextByQuality($history->getDetailOldValue('quality')),
            'newValue' => Customer::getQualityTextByQuality($history->getDetailNewValue('quality')),
        ]);
    }

    public function getBody(History $history)
    {
        return $history->event->eventText . " " . (Customer::getQualityTextByQuality($history->getDetailOldValue('quality')) ?? "not set") . ' to ' .
            (Customer::getQualityTextByQuality($history->getDetailNewValue('quality')) ?? "not set");
    }

    public static function getEventTypes(): array
    {
        return [
            Event::EVENT_CUSTOMER_CHANGE_QUALITY,
        ];
    }
}