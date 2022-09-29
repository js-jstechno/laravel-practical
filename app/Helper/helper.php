
<?php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;


function smss($no, $msgs,$templateid=0) {
    if($templateid!=0)
    {
        $key='4852JKGtFrZ8HjT0gh6Hz7';
        $str='http://sms.infisms.co.in/API/SendSMS.aspx?UserID=test123&UserPassword=test123&PhoneNumber=' . urlencode($no) . '&Text=' . urlencode($msgs) . '&SenderId=JKLTYU&AccountType=2&MessageType=0';
        // echo $str;
        $ch = curl_init($str);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
    }
}



