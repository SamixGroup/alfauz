<?php
/**
 * Created by PhpStorm.
 * User: SamixGroup
 * Date: 15.07.2020
 * Time: 1:06
 */


 /**
 * @param $user_id
 * @param $chat_id
 */

function is_admin($user_id,$chat_id){
    $result = bot('getChatMember',[
        'chat_id'=>$chat_id,
        'user_id'=>$user_id
    ])->result;

    if(in_array($result->status,['administrator','creator'])) return true;
    else return false;
}