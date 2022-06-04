<?php


namespace app\widgets\HistoryList\helpers\models;


use app\models\Customer;
use app\models\Event;
use app\models\History;
use yii\base\View;

class ChangeTypeEventRender implements EventRenderInterface
{

    public function render(View $view, History $history)
    {
        echo $view->render('_item_statuses_change', [
            'model' => $history,
            'oldValue' => Customer::getTypeTextByType($history->getDetailOldValue('type')),
            'newValue' => Customer::getTypeTextByType($history->getDetailNewValue('type'))
        ]);
    }

    public function getBody(History $history)
    {
        return $history->event->eventText . " " .
            (Customer::getTypeTextByType($history->getDetailOldValue('type')) ?? "not set") . ' to ' .
            (Customer::getTypeTextByType($history->getDetailNewValue('type')) ?? "not set");
    }

    public static function getEventTypes(): array
    {
        return [
            Event::EVENT_CUSTOMER_CHANGE_TYPE,
        ];
    }
}