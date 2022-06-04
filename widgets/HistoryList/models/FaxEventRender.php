<?php


namespace app\widgets\HistoryList\helpers\models;


use app\models\Event;
use app\models\History;
use app\widgets\HistoryList\helpers\HistoryListHelper;
use Yii;
use yii\base\View;
use yii\helpers\Html;

class FaxEventRender extends DefaultEventRender
{

    public function render(View $view, History $history)
    {
        $fax = $history->fax;

        echo $view->render('_item_common', [
            'user' => $history->user,
            'body' => $this->getBody($history) .
                ' - ' .
                (isset($fax->document) ? Html::a(
                    Yii::t('app', 'view document'),
                    $fax->document->getViewUrl(),
                    [
                        'target' => '_blank',
                        'data-pjax' => 0
                    ]
                ) : ''),
            'footer' => Yii::t('app', '{type} was sent to {group}', [
                'type' => $fax ? $fax->getTypeText() : 'Fax',
                'group' => isset($fax->creditorGroup) ? Html::a($fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
            ]),
            'footerDatetime' => $history->ins_ts,
            'iconClass' => 'fa-fax bg-green'
        ]);
    }

    public static function getEventTypes(): array
    {
        return [
            Event::EVENT_OUTGOING_FAX,
            Event::EVENT_INCOMING_FAX,
        ];
    }

}