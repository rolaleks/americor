<?php


namespace app\widgets\HistoryList\helpers\models;


use app\models\Event;
use app\models\History;
use yii\base\View;

class TaskEventRender implements EventRenderInterface
{

    public function render(View $view, History $history)
    {
        $task = $history->task;

        echo $view->render('_item_common', [
            'user' => $history->user,
            'body' => $this->getBody($history),
            'iconClass' => 'fa-check-square bg-yellow',
            'footerDatetime' => $history->ins_ts,
            'footer' => isset($task->customerCreditor->name) ? "Creditor: " . $task->customerCreditor->name : ''
        ]);
    }

    public function getBody(History $history)
    {
        $task = $history->task;
        return $history->event->eventText . ": " . ($task->title ?? '');
    }

    public static function getEventTypes(): array
    {
        return [
            Event::EVENT_CREATED_TASK,
            Event::EVENT_COMPLETED_TASK,
            Event::EVENT_UPDATED_TASK,
        ];
    }
}