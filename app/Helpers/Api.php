<?php

namespace App\Helpers;

// use Kreait\Firebase;
// use Kreait\Firebase\Factory;
// use Kreait\Firebase\ServiceAccount;
// use Kreait\Firebase\Database;
// use Kreait\Firebase\Messaging\Message;
// use Kreait\Firebase\Messaging\Notification;
// use Kreait\Firebase\Messaging\CloudMessage;
// use Kreait\Firebase\Messaging\RawMessageFromArray;

Class Api{

	public static function format($status, $data, $ErrorMessage){
			$arr['status']    = !empty($status) ? $status : '';
			$arr['data']      = !empty($data) ? $data : '';
			$arr['error_msg'] = !empty($ErrorMessage) ? $ErrorMessage : '';
			return $arr;
	}
}
