<?php


namespace app\widgets\HistoryList\helpers\models;


use app\models\Call;
use app\models\Event;
use app\models\History;
use yii\base\View;

class CallEventRender implements EventRenderInterface
{

    public function render(View $view, History $history)
    {
        /** @var Call $call */
        $call = $history->call;
        $answered = $call && $call->status == Call::STATUS_ANSWERED;

        return $view->render('_item_common', [
            'user' => $history->user,
            'content' => $call->comment ?? '',
            'body' => $this->getBody($history),
            'footerDatetime' => $history->ins_ts,
            'footer' => isset($call->applicant) ? "Called <span>{$call->applicant->name}</span>" : null,
            'iconClass' => $answered ? 'md-phone bg-green' : 'md-phone-missed bg-red',
            'iconIncome' => $answered && $call->direction == Call::DIRECTION_INCOMING
        ]);
    }

    public function getBody(History $history)
    {
        /** @var Call $call */
        $call = $history->call;
        return ($call ? $call->totalStatusText . ($call->getTotalDisposition(false) ? " <span class='text-grey'>" . $call->getTotalDisposition(false) . "</span>" : "") : '<i>Deleted</i> ');

    }

    public static function getEventTypes(): array
    {
        return [
            Event::EVENT_INCOMING_CALL,
            Event::EVENT_OUTGOING_CALL,
        ];
    }
}