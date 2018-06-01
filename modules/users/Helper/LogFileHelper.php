<?php

/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 11/25/16
 * Time: 4:40 PM
 */

namespace App\Helpers;
use Monolog;


class LogFileHelper
{


    //log file create for user_module
    private static function log_file($label_name = null,$file_name = 'user_log'){
        $log = new Monolog\Logger($label_name);
        /*$log->pushHandler(new Monolog\Handler\StreamHandler(app_path().'/modules/user/logs/'.$file_name.'-'.date('Y-m-d').'.log'),0777);*/
        $log->pushHandler(new Monolog\Handler\StreamHandler('modules/user/logs/'.$file_name.'-'.date('Y-m-d').'.log'),0777);
        return $log;
    }
    public static function log_info($label_name, $message = 'change', $value = array('value' => 'message')){
        $file_create = LogFileHelper::log_file($label_name);
        if($file_create){
            $file_create->addInfo($message, $value);
        }
    }
    public static function log_error($label_name, $message = 'Change', $value = array('value' => 'message')){
        $file_create = LogFileHelper::log_file($label_name);
        if($file_create){
            $file_create->addError($message, $value);
        }
    }
    public function log_alert($label_name, $value = array('value' => 'message')){
        $file_create = $this->log_file($label_name);
        if($file_create){
            $file_create->addInfo('Add Some Info message', $value);
        }
    }
    public function log_notice($label_name, $value = array('value' => 'message')){
        $file_create = $this->log_file($label_name);
        if($file_create){
            $file_create->addInfo('Add Some Info message', $value);
        }
    }


}