<?php
namespace app\widgets\HistoryList\helpers\models;

use app\models\History;
use yii\base\View;

interface EventRenderInterface
{

    public function render(View $view, History $history);

    public function getBody(History $history);

    public static function getEventTypes() : array;

}