<?php


namespace app\widgets\HistoryList\helpers\models;


use app\models\History;
use yii\base\View;

class DefaultEventRender implements EventRenderInterface
{

    public function render(View $view, History $history)
    {
        echo $view->render('_item_common', [
            'user' => $history->user,
            'body' => $this->getBody($history),
            'bodyDatetime' => $history->ins_ts,
            'iconClass' => 'fa-gear bg-purple-light'
        ]);
    }

    public function getBody(History $history)
    {
        return $history->event->eventText;
    }

    public static function getEventTypes(): array
    {
        return [
        ];
    }
}