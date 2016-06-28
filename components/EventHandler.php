<?php
/**
 * EventHandler class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\logModule\components;


use bariew\logModule\models\Log;
use yii\base\Event;

/**
 * Description.
 *
 * Usage:
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class EventHandler
{
    public static function common(Event $event)
    {
        return Log::create($event)->save(false);
    }
}