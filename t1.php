<?php

$str = '{
    "user": {
        "userName": "1112223333",
        "password": "1234567"
    },
    "info": {
        "birthday": "2004-05-29 00:00:00",
        "img": "/1566207073580631316_943caf34-2e5a-4101-8769-323d05d7ad91.png?e=1584541545&token=:xLxKAlBODbV95Fw707Hesda-vjY=",
        "occupation": "会计、出纳（经济业务人员)",
        "gender": "1",
        "zone": "北京",
        "companyname": "",
        "preference": "2:0,3:35,4:36,5:30,6:30,7:23,8:0,",
        "idcard": "",
        "nickname": "一只锤子? 潇潇",
        "nicknametype": 1,
        "name": "",
        "username": "15650713960",
        "phone": "15650713960",
        "email": "",
        "points": 285,
        "allmsgCount": 0,
        "noreadmsgCount": 0,
        "noreadmsgCommentCount": 0,
        "aiuispeaker": "",
        "anchorType": 1,
        "userWords": "是是是啊是啊多大的恒大华府哈哈哈货",
        "bindAnchorId": "",
        "attentionCount": 16,
        "fansCount": 9,
        "zanCount": 6,
        "inviteCode": "国学科技",
        "backgroundImg": "/1565755235751616900_4b9d4e4d-63c3-447d-88f7-1a49f4d1115d.png?e=1584541545&token=:_x5wdilt4XNSdyhgDJgp_q4t3To=",
        "description": "",
        "label": "",
        "isAttentionAuthor": "",
        "anchorId": "",
        "isAnchorShare": "",
        "forbidComment": 0,
        "guodongBalance": 0,
        "otherPlatGuodongBalance": 0,
        "bindWx": 0,
        "bindWb": 0,
        "wxNickname": "",
        "wbNickname": "",
        "taskmsgCount": 0
    },
    "config": {},
    "bind": {}
}';
$array = json_decode($str, true);
echo json_encode(parseJson($array));

function rand_id()
{
    return md5(microtime() . mt_rand(1,10000));
}

function parseJson($array, $level = 0, $pid = 0)
{
    $field_array = [];
    if (gettype($array) == 'object') {
        $array = array($array);
    }

    foreach ($array as $key => $item) {
        $id = rand_id();
        $type = gettype($item);
        $recurrence = ($type == 'array' or $type == 'object');

        $field_array[] = [
            'id'        => $id,
            'level'     => strval($level),
            'parent_id' => strval($pid),
            'name'      => $key,
            'title'     => $key,
            'type'      => $recurrence ? (isset($item[0]) ? 'array' : 'object') : $type,
            'required'  => '10',
            'remark'    => '',
            'example_value' => $recurrence ? '' : $item
        ];

        if ($recurrence) {
            $field_array = array_merge($field_array, parseJson($item, $level + 1, $id));
        }
    }

    return $field_array;
}
