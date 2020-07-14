<?php
/**
 * Created by PhpStorm.
 * User: SamixGroup
 * Date: 14.07.2020
 * Time: 21:24
 */
define("token", "668053083:AAE61apwG4Usy2l_NYGeefyVB6qWRDJZLoE");
$botname = 'http://t.me/alfauzbot';
$admin = 129207598;
$texts = [
    'start_private' => "Salom! Bu bot sizga guruhni boshqarishda yordam beradi.",
    'start_group'=>'Bot guruhda ishlashi uchn administrator qilishni unutmang!\nBot haqida batafsil...',
    'ro'=>'Foydalanuvchi 30 daqiqaga read-only ga tushurildi',
    'crash'=>'Oops! Qandaydur nosozlik: ',
    'kick'=>'Foydalanuvchi guruhdan xaydaldi',
    'ban'=>'Foydalanuvchi guruhdan butunlay xaydaldi',
    'help_private' => "Bot guruhda qila oladigan ishlar:
`!ro` - 30 daqiqaga *read-only*
`!kick` - guruhdan qaytib kira oladigan qilib chiqarish
`!ban` - guruhdan qaytib kira olmaydigan qilib chiqarish
`!pin` - Habarni tepaga qistirish (Закрепить,pin)
*Bot ishlashi uchun guruhda administrator bo'lishi sharta!*
Yaratuvchi: @Kakashi\_Xatake"
];

$buttons = [
    'start_private' => [
        'inline_keyboard' => [
            [['text' => "Github", 'url' => 'https://github.com/samixgroup/alfauz']],
            [['text' => 'Yordam', 'callback_data' => 'help']]
        ]
    ],
    'add_group' => [
        'inline_keyboard' => [
            [['text' => "Guruhga qo'shish", 'url' => $botname . '?startgroup=new']]
        ]
    ],
    'start_group' => [
        'inline_keyboard' => [
            [['text' => "Ochish", 'url' => $botname ]]
        ]
    ]
];