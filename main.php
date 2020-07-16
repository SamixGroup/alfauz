<?php
/**
 * Created by PhpStorm.
 * User: SamixGroup
 * Date: 14.07.2020
 * Time: 21:00
 */
require "./const.php";
require "./utils.php";
if (!is_dir('./settings')) mkdir('./settings');


function bot($method, $data)
{
    $url = "https://api.telegram.org/bot" . token . '/' . $method;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
    return json_decode($res);
}

$update = json_decode(file_get_contents('php://input'), true);

if (isset($update['message'])) {//agar message mavjud bo'lsa

    $m = $update['message'];
    $chat = $m['chat'];

    if (isset($m['text'])) {
        //matnli habar bo'lsagina ishlash
        $text = $m['text'];

        if ($chat['type'] == 'private') {
            //shaxsiy habarlar(lichka)

            if ($text == '/start') {
                bot('sendMessage', [
                    'chat_id' => $chat['id'],
                    'text' => $texts['start_private'],
                    'reply_markup' => json_encode($buttons['start_private'])
                ]);
            }
        } elseif ($chat['type'] == 'supergroup') {
            $from_id = $m['from']['id'];
            if ($text == '/start') {
                $a = bot('sendMessage', [
                    'chat_id' => $chat['id'],
                    'text' => $texts['start_group'],
                    'reply_markup' => json_encode($buttons['start_group'])
                ]);
            } elseif ($text == '!ro') {
                if (is_admin($from_id, $chat['id'])) {
                    $user = $m['reply_to_message']['from']['id'];
                    $a = bot('restrictchatmember', [
                        'chat_id' => $chat['id'],
                        'user_id' => $user,
                        'until_date' => time() + 1800
                    ]);
                    if($a->ok == true){
                        bot('sendMessage',[
                            'chat_id'=>$chat['id'],
                            'text'=>$texts['ro']
                        ]);
                    }else{
                        bot('sendMessage',[
                            'chat_id'=>$chat['id'],
                            'text'=>$texts['crash'].$a->description
                        ]);
                    }
                }
            }elseif ($text == '!kick') {
                if (is_admin($from_id, $chat['id'])) {
                    $user = $m['reply_to_message']['from']['id'];
                    $a = bot('kickchatmember', [
                        'chat_id' => $chat['id'],
                        'user_id' => $user,
                        'until_date' => time() + 30
                    ]);
                    if($a->ok == true){
                        bot('sendMessage',[
                            'chat_id'=>$chat['id'],
                            'text'=>$texts['kick']
                        ]);
                    }else{
                        bot('sendMessage',[
                            'chat_id'=>$chat['id'],
                            'text'=>$texts['crash'].$a->description
                        ]);
                    }
                }
            }elseif ($text == '!ban') {
                if (is_admin($from_id, $chat['id'])) {
                    $user = $m['reply_to_message']['from']['id'];
                    $a = bot('kickchatmember', [
                        'chat_id' => $chat['id'],
                        'user_id' => $user
                    ]);
                    if($a->ok == true){
                        bot('sendMessage',[
                            'chat_id'=>$chat['id'],
                            'text'=>$texts['ban']
                        ]);
                    }else{
                        bot('sendMessage',[
                            'chat_id'=>$chat['id'],
                            'text'=>$texts['crash'].$a->description
                        ]);
                    }
                }
            }elseif ($text == '!pin') {
                if (is_admin($from_id, $chat['id'])) {
                    $message_id = $m['reply_to_message']['message_id'];
                    $a = bot('pinChatMessage', [
                        'chat_id' => $chat['id'],
                        'message_id' => $message_id
                    ]);
                    if($a->ok == true){
                        bot('sendMessage',[
                            'chat_id'=>$chat['id'],
                            'text'=>$texts['pin']
                        ]);
                    }else{
                        bot('sendMessage',[
                            'chat_id'=>$chat['id'],
                            'text'=>$texts['crash'].$a->description
                        ]);
                    }
                }
            }


        }

    }
}

//inline knopkaga javob qaytarish
if (isset($update['callback_query'])) {
    $call = $update['callback_query'];
    $data = $call['data'];
    $message_id = $call['message']['message_id'];
    $from_id = $call['from']['id'];
    if ($data == 'help') {
        bot('deleteMessage', [
            'chat_id' => $from_id,
            'message_id' => $message_id
        ]);
        bot('sendMessage', [
            'chat_id' => $from_id,
            'text' => $texts['help_private'],
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode($buttons['add_group'])
        ]);
    }
}
