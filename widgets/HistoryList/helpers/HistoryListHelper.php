<?php

namespace app\widgets\HistoryList\helpers;

use app\models\Event;
use app\widgets\HistoryList\helpers\models\CallEventRender;
use app\widgets\HistoryList\helpers\models\ChangeTypeEventRender;
use app\widgets\HistoryList\helpers\models\CustomerChangeQualityEventRender;
use app\widgets\HistoryList\helpers\models\DefaultEventRender;
use app\widgets\HistoryList\helpers\models\EventRenderInterface;
use app\widgets\HistoryList\helpers\models\FaxEventRender;
use app\widgets\HistoryList\helpers\models\SmsEventRender;
use app\widgets\HistoryList\helpers\models\TaskEventRender;

class HistoryListHelper
{
    private static $_eventRenders = [];

    /**
     * @return EventRenderInterface[]
     */
    public static function renders()
    {
        return [
            CallEventRender::class,
            ChangeTypeEventRender::class,
            CustomerChangeQualityEventRender::class,
            FaxEventRender::class,
            SmsEventRender::class,
            TaskEventRender::class,
        ];
    }

    /**
     * @param Event $event
     * @return EventRenderInterface
     */
    public static function getRender(Event $event)
    {
        if (!isset(self::$_eventRenders[$event->event])) {
            foreach (self::renders() as $render) {
                if (in_array($event->event, $render::getEventTypes())) {
                    self::$_eventRenders[$event->event] = new $render();
                }
            }
            if (!isset(self::$_eventRenders[$event->event])) {
                self::$_eventRenders[$event->event] = new DefaultEventRender();
            }
        }

        return self::$_eventRenders[$event->event];
    }
}