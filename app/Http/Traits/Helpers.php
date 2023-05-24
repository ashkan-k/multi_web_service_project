<?php


namespace App\Http\Traits;


use App\Jobs\SendSmsJob;
use App\Models\NotificationMessage;

trait Helpers
{
    public function check_myself_queryset($object, $guard = 'api')
    {
        if (!auth()->user()->is_admin && $object->user_id != auth()->id()) {
            abort(404);
        }
    }

    public function SendNotification($receiver_id, $sender_id, $item_id, $message, $type = 'items')
    {
        NotificationMessage::create([
            'receiver_id' => $receiver_id,
            'sender_id' => $sender_id,
            'item_id' => $item_id,
            'type' => $type,
            'message' => $message,
        ]);
    }

    public function SendSms($receiver, $message)
    {
        dispatch(new SendSmsJob($receiver, $message));
    }

    public function ConvertNumbersToEnglish($string)
    {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string = str_replace($persianDecimal, $newNumbers, $string);
        $string = str_replace($arabicDecimal, $newNumbers, $string);
        $string = str_replace($arabic, $newNumbers, $string);
        return str_replace($persian, $newNumbers, $string);
    }

    public function ConvertNumbersToPersian($string)
    {
        $unicode = array('۰', '۱', '۲', '۳', '٤', '٥', '٦', '۷', '۸', '۹');
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $string = str_replace($english, $unicode, $string);
        return $string;
    }
}
