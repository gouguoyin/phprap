# 接口协议
```
接口格式约定:
1、  使用标准https协议post方式进行请求，请求包返回包格式都为json；
2、  请求url和json请求包返回包节点名称全部小写，统一utf-8格式；
3、  所有请求包中都需要包含请求基本参数，所有返回包中都需要包含返回基本参数；
4、  Url中汉字需要进行进行url编码；内容是否可以为空见各接口具体说明；
5、  接口中涉及的所有时间格式统一为：yyyy-mm-dd HH:mm:ss（需要更高精度的地方另作说明）；
6、  协议中请求包都必须得有，内容是否可以为空见各接口具体说明；
Url格式说明：
https://域名/{部署路径}/{版本}/{模块名}?c={0}
请求url为统一的url，c代表接口编号；
测试环境域名：dev-fm.tingdao.com
正式环境域名：fm.tingdao.com

如果接口的数据通过加密发送，目前加密方式为：aes-128-ECB-PKCS5Padding，
然后通过base64编码发送字符串，其中如果是接口加密样式如下：
请求数据加密前 --->
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52",
        "longitude": "1.1", // 经度信息
        "latitude": "20.1"  // 纬度信息 
    },
    "param": {
        "signType": "1",
        "content": {}
    }
}

请求数据加密后 --->
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52"
    },
    "param": {
        "signType": "1",
        "secretBody":"xxxx"
    }
}
其中secretBody为"{'content': {}}"通过aes-128-ECB-PKCS5Padding转成base64编码的字符串。

返回数据加密前 --->
{
    "retcode": "000000",
    "desc": "操作成功",
    "biz": {
        "status": "1",
        "msg": "购买成功",
    }
}

返回数据加密后 --->
{{
    "retcode": "000000",
    "desc": "操作成功",
    "biz": {
        "secretBody": "xxx"
    }
}
其中secretBody为"{{'status': '1','msg': '购买成功'}}"通过base64编码aes-128-ECB-PKCS5Padding转成的字符串。
```
**base字段说明：**
```
| userid | 用户名id | string  |
| caller | 用户手机号 | string  |  
| imei | 手机标识 | string  |
| ua | user-agent | string  |
| apn | 网络类型 | string  |
| df | 暂无定义 | string  |
| sid | 登录后的唯一标识 | string  |
```
**返回的header说明：**
```
| X-Method | 调用的方法，模块-ID | string  |
| X-Reqeust-Time | 服务端处理耗时 | string  |
| X-Reqeust-Id | 服务端追踪的唯一ID | string  |
```
<a name="type" style="font-weight: bold;">type类型的定义：</a>
```
| **type** | **说明** | **数据类型** |
| 1 | 专辑 | string  |
| 2 | 节目 | string  |
| 3 | 专题活动 | string  |
| 4 | 广播 | string  |
| 5 | 分期专辑 | string  |
| 6 | 专栏专辑 | string  |
| 7 | 直播 | string  |
| 8 | 广告 | string  |
| 11 | 主播 | string  |
| 12 | 无跳转 | string  |
| 13 | h5 | string  |
| 14 | 专题 | string  |
| 15 | 播客公告 | string  |
| 24 | 文本 | string  |
| 25 | 图片 | string  |
```
<a name="template" style="font-weight: bold;">动态模板类型的定义：</a>
```
| **template** | **说明** | **字段值** |
| A1 | 3.2版本声音模板 | 1  |
| A2 | 3.2版本声音模板 | 2  |
| B1 | 3.2版本声音模板 | 3  |
| B2 | 3.2版本声音模板 | 4  |
| C1 | 3.2版本活动模板 | 5  |
| D | 3.2版本活动模板 | 6  |
| E | 3.2版本活动模板 | 7  |
| B3 | 3.2版本的主播模板 | 8  |
| A | 3.3版本的模板（横向双行） | 9  |
| B | 3.3版本的模板（横向单行） | 10  |
| C | 3.3版本的模板（横向侧滑） | 11  |
| D | 3.3版本的模板（纵向模板） | 12  |
| E | 3.3版本的模板（专栏模板） | 13  |
| F | 3.3版本的模板（主播模板） | 14  |
| G | 3.3版本的模板（新闻模板） | 15  |
| G1 | 3.3版本的模板（直播模板） | 16  |
| G2 | 3.3版本的模板（活动模板） | 17  |
| G3 | 3.3版本的模板（banner模板） | 18  |
| G4 | 3.3版本的模板（单模板或者单专辑类型） | 19 |
| T1 | 3.7版本的21-每日推荐模板 | 21 |
| T2 | 3.7版本的22-专题模板 | 22 |
| T3 | 3.7版本的23-排行榜模板 | 23 |
| T4 | 3.7版本的24-纵向音频模板板 | 24 |
| T5 | 3.7版本的25-横向专辑模板 | 25 |
| T6 | 3.7版本的26-新资讯模板 | 26 |
| T7 | 3.7版本的27-每日推荐活动模板 | 27 |
| T8 | 3.7版本的28-每日推荐专栏模板 | 28 |
| S1 | 3.7版本的29-学习时刻模板 | 29 |
```

=========

## 1001-提供获取手机验证码接口 [POST /v3/user?c=1001]
```
通过该接口获取手机验证码，可用于注册、登录或找回密码。
邮箱能力暂未提供，选择该类型将抛出内部错误。
接口名：sendverify，接口编号：1001。
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| username | 用户名，手机号 | 是 | string  |
| sendtype | 发送类型默认为0：<br>**0代表短信；**<br>**1代表邮箱；**| 否 | string   |
| email | 邮箱，如果sendtype为1，则邮箱不能为空（暂时不支持） | 否 | string   |
| flowno | 默认为0，<br>**0代表注册流程；**<br>**1代表手机找回(重置)密码流程；**<br>**2代表登录流程，0和2均可用于注册；** | 是 | string  |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| status | 手机号码是否存在：<br>**0手机号码不存在**<br>**1手机号码存在，该返回码存在表明短信发送成功** |  int   |
| count |  账号当天发送剩余次数 |    int |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "flowno":"0",
        "sendtype":"1",
        "username":"17724490919",
        "email":"zhoulv@126.com"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 1,
            "count": 0
        }
    }

=========

## 1002-验证账号是否已经登录接口 [POST /v3/user?c=1002]
```
通过该接口验证sid是否在登录状态。
用户不存在，sessionid和userid不匹配均视为未登录。
接口名：verifysid，接口编号：1002。
```
**请求参数**
| **字段名** | **说明**    | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| sid | 会话id，位于base节点中 | 是 | string |
| userid | 用户id，位于base节点中| 是 | string |
| expiretime | 登录会话失效时间，单位s。<br>**-1不更新原有过期时间；**<br>**0不失效,续期时间；**<br>**其他大于0的整数代表从当前操作开始的失效时长。** | 否 | string  |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| status | 是否在登录状态。<br>**0表示不在登录状态；**<br>**1表示在登录状态；** |  int |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "expiretime":"100000"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 1,
            "count": 0
        }
    }

=========

## 1003-登录接口  [POST /v3/user?c=1003]
```
通过该接口实现APP的登录。
接口名：login，接口编号：1003。
```
**请求参数**
| **字段名**      | **说明**    | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| type | 登录类型。<br>**1:手机+验证码;** <br>**2:手机+密码;** <br>**3:微信;** <br>**4:qq;** <br>**5:微博;** <br>**6:游客模式;** | 是 | string  |
| username | 用户名，手机号，数字字符串 | 当type=1/2时非空| string   |
| verifycode | 手机验证码 |  当type=1时非空 | string   |
| password  | 密码 | 当type=2时非空  |  string  |
| opid| 第三方登陆唯一标识符 | 否 | string |
| token| 第三方token | 否 | string |
| osid| 平台id，ios或android，在base中传递 | 是 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| userid | 用户userid |  string   |
| sid | 会话id |  string   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "password":"123456",
        "type":"1",
        "username":"17724490919",
        "verifycode":"517516"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "userid": "1801101519245704",
            "sid": "4926394576699451574"
        }
    }

=========

## 1004-注册并登录接口 [POST /v3/user?c=1004]
```
通过该接口完成注册并登录接口。
接口名：register，接口编号：1004
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| type | 注册类型。<br>**1:手机+验证码;** <br>**2:手机+密码;** <br>**3:微信;** <br>**4:qq;** <br>**5:微博;** <br>**6:游客模式;** | 是 | string  |
| osid | 系统类型，ios或android 在base中传递 | 是 | string |
| username | 用户名，手机号，数字字符串 | 是| string   |
| password  | 密码 |是  |  string  |
| opid | 第三方登陆唯一标识符 | 否 | string |
| token | 第三方token | 否 | string |
| verifycode | 手机验证码 |  是 | string   |
| from | 来源平台 |  否 | string   |
| bindAnchorId | 绑定的主播ID | 否 | string |
**返回参数**
| **字段名**  | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| userid | 用户userid |  string   |
| sid | 会话id |  string   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "password":"abc1234",
        "type":"2",
        "username":"17724490919",
        "verifycode":"102880",
        "bindAnchorId":"xxx"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "userid": "1801101519245704",
            "sid": "4919030938950413772"
        }
    }

=========

## 1005-查询手机号是否已存在接口 [POST /v3/user?c=1005]
```
通过该接口查询手机号是否已存在接口。
接口名：checkphone，接口编号：1005
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| username | 用户名，手机号，数字字符串 | 是 | string   |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| status | 是否存在。<br>**0表示不存在；**<br>**1表示存在** |  int   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "username":"17724490000"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 1
        }
    }

=========

## 1006-密码修改接口 [POST /v3/user?c=1006]
```
此接口用于修改用户密码，用户登录前调用该接口为非法调用，旧密码，及新密码两个必要的参数。
接口名：modifypassword，接口编号：1006
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| oldpassword | 旧密码 | 是| string   |
| newpassword |新密码  | 是 |  string  |
| sid | 会话id，位于请求体base中| 是| string   |
| userid | 用户id，位于请求体base中| 是 |  string  |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "oldpassword":"mgtj12345678",
        "newpassword":"mgtj123456"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 1007-密码找回接口 [POST /v3/user?c=1007]
```
用户忘记密码时通过该接口重置密码，该接口需要传递手机，新密码，及验证码等参数，
因此在调用此接口前首先应该调用获取验证码接口获取验证码信息。
接口名：resetpassword，接口编号：1007
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| type | 找回类型，<br>**1：手机号+验证码，其他待定** | 是 | string |
| username |用户名| 是 |  string  |
| password |密码 | 是| string |
| verifycode| 手机验证码| 是 |  string  |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "password":"mgtj12345678",
        "type":"1",
        "username":"17724490919",
        "verifycode":"349038"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 1008-修改昵称接口 [POST /v3/user?c=1008]
```
该接口用于用户修改昵称。
接口名：modifynickname，接口编号：1008
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| nickname | 新昵称 | 是| string   |
| sid |会话id，位于base节点中| 是 |  string  |
| userid |用户id，位于base节点中| 是| string   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "nickname":"测试2019"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 1009-头像修改接口 [POST /v3/user?c=1009]
```
该接口用于用户修改头像，该接口调用的前提是用户登录。
接口名：modifyhead，接口编号：1009
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| head | 用户头像，将头像文件转换为base64字符串，头像文件必须为png格式，限制大小小于100k | 是| string   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "head":"/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAoJCgsKEQ0LFQsODg0PEyAVExISEyccHhcgLikxMC4pLSwzOko+MzZGNywtQFdBRkx"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 1010-偏好修改接口 [POST /v3/user?c=1010]
```
该接口用于用户设置偏好，用户可能有多个偏好，通过","区分，该接口调用的前提是用户登录。
接口名：modifypreference，接口编号：1010
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| preference | 用户偏好 | 是| array   |
| kindId | 偏好Id | 是| string   |
| percent | 偏好id设置的百分比 | 是| int   |
| sid | 会话id,位于请求体base中 | 是| string   |
| userid | 用户id,位于请求体base中 | 是| string   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "preference":[
            {
                "kindId":"1",
                "percent":90
            },
            {
                "kindId":"2",
                "percent":72
            }
        ]
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 1011-用户信息修改 [POST /v3/user?c=1011]
```
该接口用于设置用户信息。用户包含多种信息,可能包含部分未修改的信息，
未修改的数据参数应该以原数据作为至传至服务器，该接口调用的前提是用户登录，该接口调用的前提是用户登录。
接口名：modifyuserinfo，接口编号：1011
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| gender | 性别，<br>默认0未知，<br>1表示女，<br>2表示男 | 否 |string|
| name | 用户真实姓名 | 否|string|
| occupation | 职业 | 否|string|
| idcard | 身份证号码 | 否|string|
| birthday | 生日 | 否|string|
| zone | 地区 |否|string|
| companyname | 公司名称 |否|string|
| aiuispeaker | ai语音发声选项设置| 否| string   |
| email | 邮箱 | 否|string|
| sid | 会话id，位于请求体base中 | 是| string   |
| userid | 用户id，位于请求体base中 | 是| string   |
| userWords | 用户的签名 | 是 | string |
| backgroundImg | 背景图 | 是 | string |
| inviteCode | 邀请码,邀请码二次提交会报100523,该用户已提交过邀请码 | 是 | string |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "gender": "1",
        "name": "程序员0001",
        "occupation": "程序员",
        "idcard": "123456789",
        "birthday": "1991-01-01",
        "zone": "合肥",
        "companyname": "科大讯飞",
        "email":"1234@qq.com",
        "aiuispeaker": "3",
        "userWords": "xxx",
        "backgroundImg": "awqsq",
        "inviteCode":"张阿姨好"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========
 
## 1012-用户信息查询 [POST /v3/user?c=1012]
```
该接口用于获取用户信息，该接口调用的前提是用户登录。
接口名：getuserinfo，接口编号：1012
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| sid | 会话id，位于请求体base中| 是| string   |
| userid | 用户id，位于请求体base中| 是| string   |
| anchorId | 用户访问的ID | 否 | string |
| anchorType | 类型，访问主播默认为1,访问普通用户默认为0 | 否 | string |
**返回参数**
| **字段名**      | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|anchorId|  主播id(非主播为空),如果是主播，可以拿着这个anchorId去和主播列表的userId对比。如果相同的说明是主播自己|string|
|birthday|  生日|string|
|img  |头像图片url地址|string|
|occupation|  职业|string|
|gender|  性别|string|
|zone  |地区|string|
|companyname  |公司名称|string|
|preference|  偏好|string|
|idcard  |身份证号码|string|
|nickname  |昵称|string|
|nicknameType  |是否为默认昵称<br>0：是默认昵称，<br>1：不是|string|
|name  |用户真实姓名|string|
|email  |邮箱|string|
|points  |积分|int|
|allmsgCount  |消息总数|int|
|noreadmsgCount  |未读消息总数|int|
|aiuispeaker | ai语音发声选项设置 | string   |
|bindAnchorId | 绑定的主播Id | string   |
|userWords | 用户签名 | string |
|anchorType | 用户类型，0-普通用户，1-主播，2-表示个人用户(后续) | string |
|attentionCount | 关注数 | int |
|fansCount | 粉丝数 | int |
|zanCount | 获赞数 | int |
|inviteCode | 邀请码 | string |
|backgroundImg | 背景图 | string |
|forbidComment | 能够评论，0表示可以评论，1表示禁止评论 | string |
|isAttentionAuthor | 是否关注，0表示未关注，1表示关注，2表示相互关注 | string |
|guodongBalance | 果冻的金额总数 | float |
|otherPlatGuodongBalance | 其它平台果冻的金额总数，根据osid判断 | float |
|ChargeGuodong | 充值金额 | float |
|OtherChargeGuodong | 其它平台充值币金额 | float |
|freeGuodong | 赠送金额 | float |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "anchorId": "1810232036463280",
        "anchorType": "1"
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "birthday": "2019-12-30",
    "img": "http://s7.tingdao.com/1574412918547758236_164731fc-0bef-41e4-8dd4-91c0e58e99ea.png?e=1578002585&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:07gW7i3dzywgtpoxQnUQ4f1Siek=",
    "occupation": "医生/护士（医疗卫生人员）",
    "gender": "1",
    "zone": "香港",
    "companyname": "",
    "preference": "2:0,3:0,4:0,5:0,6:0,7:0,8:0,",
    "idcard": "",
    "nickname": "王力宏",
    "nicknametype": "1",
    "name": "",
    "username": "18627556209",
    "phone": "18627556209",
    "email": "",
    "points": 88,
    "allmsgCount": 0,
    "noreadmsgCount": 0,
    "noreadmsgCommentCount": 0,
    "aiuispeaker": "",
    "anchorType": "0",
    "userWords": "我 my魔我现在？我",
    "bindAnchorId": "",
    "attentionCount": 0,
    "fansCount": 0,
    "zanCount": 0,
    "inviteCode": "",
    "backgroundImg": "",
    "description": "",
    "label": "",
    "isAttentionAuthor": "0",
    "anchorId": "",
    "isAnchorShare": "0",
    "forbidComment": "0",
    "guodongBalance": 999884.39,
    "otherPlatGuodongBalance": 195.08,
    "bindWx": 1,
    "bindWb": 0,
    "wxNickname": "",
    "wbNickname": "",
    "taskmsgCount": 1,
    "chargeGuodong": 999884.00,
    "otherChargeGuodong": 195.08,
    "freeGuodong": 0.39
  }
}

=========

## 1013-用户退出登录 [POST /v3/user?c=1013]
```
该接口用于获取用户信息，该接口调用的前提是用户登录。
接口名：logout，接口编号：1013
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| sid | 会话id，位于请求体base中| 是| string   |
| userid | 用户id，位于请求体base中| 是| string   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 1014-查询用户是否设置过偏好 [POST /v3/user?c=1014]
```
通过该接口查询用户是否设置过偏好，用户需登录。
接口名：checkpreference，接口编号：1014
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| sid | 会话id，位于请求体base中| 是| string   |
| userid | 用户id，位于请求体base中| 是| string   |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|status| 是否存在，<br>**0表示未设置偏好；**<br>**1表示设置了偏好；**|string|

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 0
        }
    }

=========

## 1016-安装数目是否超标 [POST /v3/user?c=1016]
```
该接口用户确定安装数目是否超标。
接口名：downloadcount，接口编号：1016
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| sid | 会话id，位于请求体base中| 是| string   |
| userid | 用户id，位于请求体base中| 是| string   |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|status |**0：允许安装；**<br>**1：安装次数超标**  |int|

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 0
        }
    }

=========

## 1017-拉取个人消息列表 [POST /v3/user?c=1017]
```
该接口拉取个人消息详细，最多拉取显示100条。
接口名：getMessagesInfo，接口编号：1017
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| sid | 会话id，位于请求体base中| 是| string   |
| userid | 用户id，位于请求体base中| 是| string   |
| offset | 分页的第几页，type=1时可以为空，从1开始包含当前记录 | 否  | string  |
| count | 每次查询个数，分页查询时生效 | 否 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count |返回消息条数 |int|
|content |返回的内容列表 |array|
|id |对应的消息id |string|
|title |标题 |string|
|subhead |子标题 |string|
|img |图标地址 |string|
|description |详细信息 |string|
|status |状态，0-表示未读，1-表示已读 |int|
|messagesId |消息ID |string|
|messagesType |模板类型，0:全局，1：评论，2：动态，3：订阅，4：关注，5：系统通知,6:赞评论 |string|
|extData | 根据消息的模板定义额外的参数,cid+type跳专辑，fromUserId跳主播| object|
|cid | 对应的音频的ID | string|
|type | 对应的音频的类型 | string |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "offset": "1",
        "count": "10"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "content": [
                {
                    "id": "1",
                    "title": "#@张爱玲# 订阅了你的专辑",
                    "subhead": "@成龙专辑",
                    "description": "没有描述",
                    "status": 1,
                    "messagesType": "3",
                    "messagesId": "1",
                    "updateTime": "2019-04-23 15:25:59",
                    "img": "test-tdbucketimg_307725045867520_c4d263c0-091c-41ea-a3f9-bc63dadaaed96746679511695771633.jpg",
                    "extData": {
                    "cid": "304645771609088",
                    "type": "5",
                    "publishName": "",
                    "fromUserId": "11111",
                    "authorType": "1"
                    }
                }
            ],
            "count": 1
        }
    }

=========

## 1018-设置消息全部已读 [POST /v3/user?c=1018]
```
该接口设置消息全部已读。
接口名：messagesRead，接口编号：1018
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| messagesId | 评论消息id | 否  | string  |
| status | 评论状态,1已读,2删除 | 否 | string |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "messagesId": "1",
        "status": "1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 1019-查询用户是否存在 [POST /v3/user?c=1019]
```
该接口查询用户是否存在。
接口名：userIsExist，接口编号：1019
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| opid | 第三方平台的opid | 是| string   |
| type | 平台类型：<br>**3:微信;** <br>**4:qq;** <br>**5:微博;** | 是| string   |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|status |用户是否存在：<br>**0：不存在，**<br>**1：存在** |int|

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "opid": "xxx",
        "type": "3"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 1
        }
    }

=========

## 1020-用户绑定主播 [POST /v3/user?c=1020]
```
该接口用户绑定。
接口名：userBindAnchor，接口编号：1020
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| bindAnchorId | 绑定主播的ID | 是 | string   |
| inviteCode | 主播的邀请码 | 否 | string   |
| phone | 用户手机号手机号，加上userid去判断用户是否绑定过主播 | 是 | string   |
| verifyCode | 手机获取的验证码 | 否 | string   |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| status | 0表示绑定成功，<br>1表示已经绑定过 | 是| int   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "bindAnchorId": "xxx",
        "inviteCode": "xxx",
        "phone": "17724490919",
        "verifyCode": ""
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 1
        }
    }

=========

## 1021-是否有新的消息通知 [POST /v3/user?c=1021]
```
该接口用户绑定。
接口名：newMessageCount，接口编号：1021
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| count | 消息条数 | 是| int   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1
        }
    }

=========

## 1022-背景图修改接口 [POST /v3/user?c=1022]
```
该接口用于用户修改头像，该接口调用的前提是用户登录。
接口名：modifyBackgroundImg，接口编号：1022
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| backgroundImg | 用户背景图，将背景文件转换为base64字符串，背景图文件必须为png格式，限制大小小于500k | 是| string  |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "backgroundImg":"/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAoJCgsKEQ0LFQsODg0PEyAVExISEyccHhcgLikxMC4pLSwzOko+MzZGNywtQFdBRkx"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 1023-修改用户手机号 [POST /v3/user?c=1023]
```
修改用户手机号。
接口名：UserChangePhone，接口编号：1023
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| type | 类型修改，1-表示手机号+验证码 | 是| string  |
| oldusername | 之前的手机号 | 是| string  |
| oldverifycode | 之前的手机的验证码 | 是| string  |
| username | 验证手机号 | 是| string  |
| verifycode | 当前手机验证码 | 是| string  |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "type":"1",
        "oldusername":"17724490919",
        "oldverifycode":"123456",
        "username":"17724490919",
        "verifycode":"123456"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status":1
        }
    }

=========

## 1024-用户修改绑定 [POST /v3/user?c=1024]
```
用户修改绑定。
接口名：UserBindAccount，接口编号：1024
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| type | 修改数据类型，3:微信; <br>4:qq; <br>5:微博;  | 是| string  |
| opid | 第三方登陆唯一标识符 | 是| string  |
| token | 第三方token | 是| string  |
| status | 1表示绑定，2表示解绑 | 是| string  |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "type":"1",
        "opid":"xxxx",
        "token":"xxxxx",
        "username":"17724490919",
        "status":"1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status":1
        }
    }

=========

## 1025-验证验证码是否合法 [POST /v3/user?c=1025]
```
验证验证码是否合法。
接口名：UserPhoneVerifyCodeV2，接口编号：1025
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| type | 1-手机验证;  | 是| string  |
| verifycode | 验证码 | 是| string  |
| username | 验证手机号 | 是| string  |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "type":"1",
        "verifycode":"123456",
        "username":"17724490919"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status":1
        }
    }

=========

## 1026-用户任务中心 [POST /v4/user?c=1026]
```
获取用户的任务中心。
接口名：UserTaskCenterInfo，接口编号：1026
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| status | 0-未完成;1-已完成；2-未领取；3-无需领取  | 是| int  |
| id | 任务id  | 是| string  |
| type | '行为类型：1-完善个人资料，2-绑定社区账号，3-收听时长，4-签到，5-评论，6-分享，7-收藏，8-订阅，9-偏好,10-收听时长2,11-收听时长3,12-首次充值,13-购买内容,14-专辑促销,15-H5促销| 是| string  |
| jobType | 任务类型：0-每日任务，1-新用户任务，2-购买专辑，3-促销活动 | 是| string  |
| needCount | 需要的次数或时间 | 是| int  |
| realCount | 实际的的次数或时间 | 是| int  |
| jumpUrl | 按钮跳转链接 | 是| string  |
**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "detail": {
      "points": 9163,
      "msg": ""
    },
    "everydayTask": [
      {
        "id": "505900967465984",
        "type": "11",
        "jobType": "0",
        "title": "收听新",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_40f3b1d53ccebc41db82585769c1a29e862c15b0.png",
        "subtitle": "+1积分  ",
        "btnText": "去收听",
        "points": 1,
        "needCount": 20,
        "realCount": 0,
        "jumpUrl": "mgtj://home?id=2",
        "status": 0
      },
      {
        "id": "483868713751552",
        "type": "10",
        "jobType": "0",
        "title": "收听时长2",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_40f3b1d53ccebc41db82585769c1a29e862c15b0.png",
        "subtitle": "+2积分  收听时长2",
        "btnText": "去收听",
        "points": 2,
        "needCount": 2,
        "realCount": 0,
        "jumpUrl": "mgtj://home?id=2",
        "status": 0
      },
      {
        "id": "483868578984960",
        "type": "3",
        "jobType": "0",
        "title": "收听时长1",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_40f3b1d53ccebc41db82585769c1a29e862c15b0.png",
        "subtitle": "+12积分  收听时长1",
        "btnText": "去收听",
        "points": 12,
        "needCount": 1,
        "realCount": 0,
        "jumpUrl": "mgtj://home?id=2",
        "status": 0
      },
      {
        "id": "466928557380608",
        "type": "4",
        "jobType": "0",
        "title": "签到噢",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_4938c1902d83d5feffa850ca870d42e2227116b5.png",
        "subtitle": "签到",
        "btnText": "去签到",
        "points": 5,
        "needCount": 1,
        "realCount": 0,
        "jumpUrl": "mgtj://duibaPage?type=1",
        "status": 0
      },
      {
        "id": "466760406266880",
        "type": "5",
        "jobType": "0",
        "title": "每日评论",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_d6b510ba4a27d2ee5986f0c4317df38091c00003.png",
        "subtitle": "+1积分  2",
        "btnText": "去评论",
        "points": 1,
        "needCount": 5,
        "realCount": 0,
        "jumpUrl": "mgtj://home?id=2",
        "status": 0
      },
      {
        "id": "466779015590912",
        "type": "6",
        "jobType": "0",
        "title": "每日分享",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_e4f71f11e28501c00a01a03c049bb33ee7a98ae2.png",
        "subtitle": "+2积分  23",
        "btnText": "去分享",
        "points": 2,
        "needCount": 2,
        "realCount": 0,
        "jumpUrl": "mgtj://home?id=2",
        "status": 0
      },
      {
        "id": "466900744827904",
        "type": "8",
        "jobType": "0",
        "title": "快去订阅哟！",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_4cf32a5657944741d1e7011a47eb97e46962d0b9.png",
        "subtitle": "+10积分  增加积分",
        "btnText": "去订阅",
        "points": 10,
        "needCount": 5,
        "realCount": 0,
        "jumpUrl": "mgtj://home?id=2",
        "status": 0
      },
      {
        "id": "483032048014336",
        "type": "7",
        "jobType": "0",
        "title": "测试收藏",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_250f10388bf6b7cbe9a892a53644b60425576561.png",
        "subtitle": "+99999积分  阿斯顿",
        "btnText": "去收藏",
        "points": 99999,
        "needCount": 5,
        "realCount": 0,
        "jumpUrl": "mgtj://home?id=2",
        "status": 0
      }
    ],
    "newHandTask": [
      {
        "id": "1",
        "type": "1",
        "jobType": "1",
        "title": "完善个人信息",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_1d3a30cf65772d1fab350bedcf2587dd7b399c35.png",
        "subtitle": "+10积分  让大家更了解你吧",
        "btnText": "去完善",
        "points": 10,
        "needCount": 1,
        "realCount": 0,
        "jumpUrl": "mgtj://personalInformationEditPage",
        "status": 0
      },
      {
        "id": "2",
        "type": "2",
        "jobType": "1",
        "title": "绑定社交账号",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_1b0928cd6a1ce260e3db295c97ca03b5eea98b47.png",
        "subtitle": "+80积分  让动听更懂你",
        "btnText": "去绑定",
        "points": 80,
        "needCount": 1,
        "realCount": 0,
        "jumpUrl": "mgtj://accountSafeAndBindPage",
        "status": 0
      },
      {
        "id": "3",
        "type": "12",
        "jobType": "1",
        "title": "完成首次果冻买买充值",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_876c19689a2fe3f2e8c563499cabb1af883d45b0.png",
        "subtitle": "+80积分  充值果冻买买买拿积分",
        "btnText": "已领取",
        "points": 80,
        "needCount": 1,
        "realCount": 1,
        "jumpUrl": "mgtj://rechargePage",
        "status": 1
      }
    ],
    "otherTask": [
      {
        "id": "4",
        "type": "13",
        "jobType": "2",
        "title": "购买专辑得积分买买买",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_2de88c47bd1d50d98e22d4cd16959545344b247d.png",
        "subtitle": "购买专辑副标题购买买买买买买买买买买买买买买买买买买买买买买",
        "btnText": "去购买",
        "points": 200,
        "needCount": 1,
        "realCount": 0,
        "jumpUrl": "mgtj://home?id=487973709902848",
        "status": 3
      }
    ],
    "activityTask": [
      {
        "id": "0",
        "type": "14",
        "jobType": "3",
        "title": "买大明风华拿积分",
        "imgUrl": "http://s13.tingdao.com/tdbucketimg_public_40f3b1d53ccebc41db82585769c1a29e862c15b0.png",
        "subtitle": "+100积分  大明风华",
        "btnText": "去完成",
        "points": 100,
        "needCount": 1,
        "realCount": 0,
        "jumpUrl": "mgtj://home?id=2",
        "status": 3
      }
    ]
  }
}

=========

# 个人中心接口

## 2001-收藏接口 [POST /v3/center?c=2001]
```
该接口用于用户收藏喜欢的内容，同时此接口可用于判断指定内容是否被收藏，type用来判断id类型。
该接口调用的前提是用户登录。
接口名：store，接口编号：2001
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| status | 是否收藏：<br>1-收藏；<br>2-取消收藏；<br>0-查询是否收藏| 是| string   |
| type  | <a href="#type">类型定义</a>(2,3,4,8) | 是| string  |
| cid | 对应type的数据ID | 是| string |
| title | 当前收藏的标题 | 是 | string |
| img | 当前收藏的背景图 | 否 | string |

**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "status": "2",
        "type": "1",
        "cid": "20102001020201",
        "title": "测试",
        "img": "http://xxx/xxx"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 2002-查询所有收藏记录接口 [POST /v3/center?c=2002]
```
该接口用于查询用户收藏的所有音视频。
该接口调用的前提是用户登录。
接口名：getAllStore，接口编号：2002
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| type |查询类型 <br>1-查询所有（最多200条），<br>2-分页查询| 是| string   |
| offset | 分页的第几页，type=1时可以为空，从1开始包含当前记录 | 否  | string  |
| count | 每次查询个数，分页查询时生效 | 否 | string |
| favortype |查询的分类，(2,3,4,8),0查询全部 |否|string |
| anchorId | 需要查询的主播ID，查询自身不传 | 否| string   |
| anchorType |  来源类型，根据音频所属人员判断-普通用户，1-主播，2-表示个人用户(后续) | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count| 收藏的总数目 | int |
|content| 内容 | array |
|cid |对应type的数据ID|string|
|type |<a href="#type">类型定义</a>|string|
|img |封面|string|
|title  | 标题|string|
|subtitle| type=2子标题|string|
|frequency| 频率，type=4子标题|string|
|playUrl| 播放地址|string|
|nextpage |是否有下一页|string|
|playtype|playtype=2,name为专辑名；playtype=4，name为电台名|string|
|source |频率播放地址 |string|
|status |该条数据状态 |0禁用，1正常，2删除|

**请求**
```
{
    "base" : {
        "userid" : "316239831577501696",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "98a3f98e-7ff1-440f-b1f2-c7c706c086cc"
    },
    "param": {
        "type": "1",
        "offset": "0",
        "count": "388",
        "favortype" : "0",
        "anchorId": "21110",
        "anchorType": "1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 2,
            "nextpage": "1",
            "content": [
                {
                    "id": "330482616698511360",
                    "cid": "307813292835840",
                    "type": "2",
                    "img": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/test-tdbucketimg_307813091648512_cdca8a49-ccc2-4ae4-8454-09d57418600f8791300333555215652.png?Expires=1556288899&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=1eDg6SDRa%2FMsFnG8%2B6obLxcCL60%3D",
                    "bigimg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/test-tdbucketimg_307813137908736_a1835dac-504a-49fa-83ce-f76a6beb37574411811686587506556.jpg?Expires=1556288899&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=rd5%2B1Q6CsbPfb7%2B9uf2xeo2RsFw%3D",
                    "title": "搞笑瞬间-脚麻吗",
                    "subtitle": "搞笑瞬间",
                    "frequency": "",
                    "playUrl": "",
                    "source": "",
                    "status": "1"
                },
                {
                    "id": "326482653291339776",
                    "cid": "17277200296574976",
                    "type": "4",
                    "img": "",
                    "bigimg": "",
                    "title": "衡水交通广播",
                    "subtitle": "",
                    "frequency": "FM88",
                    "playUrl": "",
                    "source": "http://cnlive.cnr.cn/hls/hensjtgb.m3u8",
                    "status": "1"
                }
            ]
        }
    }

=========

## 2003-查询播放历史记录  [POST /v3/center?c=2003]
```
该接口用于查询用户播放记录，该接口调用的前提是用户登录。
接口名：getAllHistory,接口编号：2003
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| type |查询类型 <br>1-查询所有（最多200条），<br>2-分页查询| 是| string   |
| offset | 分页的第几页，type=1时可以为空，从1开始包含当前记录 | 否  | string  |
| count | 每次查询个数，分页查询时生效 | 否 | string |
| favortype |查询的分类，(2,3,4,8),0查询全部 |否|string |
| anchorId | 需要查询的主播ID，查询自身不传 | 否| string   |
|anchorType |  来源类型，根据音频所属人员判断-普通用户，1-主播，2-表示个人用户(后续) | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count| 收藏的总数目 | int |
|content| 内容 | array |
|cid |对应type的数据ID|string|
|type |<a href="#type">类型定义</a>|string|
|img |封面|string|
|title  | 标题|string|
|subtitle| type=2子标题|string|
|frequency| 频率，type=4子标题|string|
|playUrl| 播放地址|string|
|nextpage |是否有下一页|string|
|playtype|playtype=2,name为专辑名；playtype=4，name为电台名|string|
|source |频率播放地址 |string|
|status |该条数据状态 |0禁用，1正常，2删除|

**请求**
```
{
    "base" : {
        "userid" : "316239831577501696",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "98a3f98e-7ff1-440f-b1f2-c7c706c086cc"
    },
    "param": {
        "type": "1",
        "offset": "1",
        "count": "11",
        "playtype" : "0"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 3,
            "nextPage": "1",
            "content": [
                {
                    "id": "326457927483383808",
                    "cid": "302748295668736",
                    "type": "2",
                    "img": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/test-tdbucketimg_303229453231104_7f5aa962-2077-4140-83bc-8d932e6bce5a7238703435628778616.png?Expires=1556289179&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=DOcPKspF8X65f8wtzFtsI8YHNrk%3D",
                    "title": "刘德华2",
                    "position": 0,
                    "duration": 249495,
                    "broadcastTime": -9999,
                    "subtitle": "测试11",
                    "frequency": "",
                    "playUrl": "",
                    "source": "",
                    "bigimg": "",

                },
                {
                    "id": "341320021080907778",
                    "cid": "17277200291921920",
                    "type": "4",
                    "img": "",
                    "title": "河北生活广播",
                    "position": 0,
                    "duration": 0,
                    "broadcastTime": -9999,
                    "subtitle": "",
                    "frequency": "FM88",
                    "playUrl": "",
                    "source": "http://satellitepull.cnr.cn/live/wxhebshgb/playlist.m3u8",
                    "bigimg": "",
                    "status": "1"
                }
            ]
        }
    }

=========

## 2004-用户信息修改 [POST /v3/center?c=2004]
```
该接口用于清空收藏记录，该接口调用的前提是用户登录。
接口名：DeleteCenterStore，接口编号：2004
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| deletetype| 清空用户某一类(节目2或FM4或全清1)播放历史记录 | 否| string   |
| content |内容节点| 否，当删除指定的cid时必填 | array   |
| type | <a href="#type">类型定义</a>| 当删除指定的cid时必填| string |
| position | 播放位置 | 否| string   |
| cid | 对应type的数据ID| 否| string   |

**请求**
```
{
    "base" : {
        "userid" : "316239831577501696",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "dd75e1b6-be9c-4c9d-a058-f3d197da0a25"
    },
    "param": {
        "deletetype" : "0",
        "content":[
            {
                "cid":"20102001020201",
                "type":"1"
            }
        ]
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 2005-删除和批量删除播放历史 [POST /v3/center?c=2005]
```
该接口用于删除用户播放记录，该接口调用的前提是用户登录。
接口名：DeleteHistory，接口编号：2005
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| deletetype | 清空用户某一类(节目2或FM4或全清1)播放历史记录 | 否| string   |
| content |内容节点| 否，当删除指定的cid时必填 | array   |
| type | <a href="#type">类型定义</a>| 当删除指定的cid时必填| string |
| position | 播放位置 | 否| string   |
| cid | 对应type的数据ID| 否| string   |

**请求**
```
{
    "base" : {
        "userid" : "316239831577501696",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7dee006c-d014-4630-ae45-ab550709a46a"
    },
    "param": {
        "deletetype" : "2"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 2006-提交播放历史 [POST /v3/center?c=2006]
```
该接口用于提交用户播放记录，该接口调用的前提是用户登录。
接口名：history，接口编号：2006
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| content |内容节点| 是 | array   |
| type | <a href="#type">类型定义</a> (2,3,4,8)| 是| string |
| position | 播放位置 | 否| string   |
| cid | 对应type的数据ID| 是| string   |
| title | 当前收藏的标题 | 是 | string |
| img | 当前收藏的背景图 | 否 | string |
| broadcastTime | 播放时间 | 是 | int64 |

**请求**
```
{
    "base": {
        "userid": "316239831577501696",
        "caller": "18514281314",
        "imei": "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua": "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version": "2.1",
        "osid": "ios",
        "apn": "wifi",
        "df": "22010000",
        "sid": "5ec9adbe-bf11-4c65-b586-9ae88d8730de"
    },
    "param": {
        "content": [
            {
                "cid": "1",
                "type": "2",
                "position": "100",
                "duration": "100",
                "img": "www.baidu.com",
                "title": "测试",
                "broadcastTime" : 12321355
            }
        ]
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========

## 2007-查询是否收藏 [POST /v3/center?c=2007]
```
该接口用于查询用户收藏的所有音视频。
该接口调用的前提是用户登录。
接口名：getStoreById，接口编号：2007
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| type |<a href="#type">类型定义</a>| 是| string |
| cid | 对应type的数据ID | 是| string   |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| status | 是否收藏<br> **0-未收藏**<br>**1-已收藏** | int |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "cid":"1",
        "type":"2"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 1
        }
    }

=========

## 2008-查询指定节目的播放历史 [POST /v3/center?c=2008]
```
该接口用于查询用户指定音视频的播放记录。
该接口调用的前提是用户登录。
接口名：getHistoryById，接口编号：2008
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| cid |对应type的数据ID | 否| string   |
| type |<a href="#type">类型定义</a>| 是| string   |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "cid":"1",
        "type":"2"
    }
}
```

+ Response 200 (application/json)
    { 
        "retcode": "000000",
        "desc": "查询成功",
        "biz": {
            "position":0
        }
    }

=========

## 2011-查询偏好选项设置 [POST /v3/center?c=2011]
```
该接口用于查询偏好选项设置。
接口名：getAllPreference，接口编号：2011
```
**返回参数**
| **字段名** | **说明** | **数据类型** |
| :-: | :-: | :-: |
|content| 内容 |  string|
|kindId |偏好类型id字段|  string|
|name |偏好类型|  string|
|percent |偏好设置的百分比，如果用户已经登录，则会带想要设置值，否则为0 | int|
|id |偏好id|  string|
|status |是否设置，<br>**0-未设置**<br>**1-已设置**| int|

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    { 
        "retcode": "000000",
        "desc": "查询成功",
        "biz": {
            "content":[
                {
                    "id": "1",
                    "name": "测试",
                    "kindId": "2",
                    "percent": 20,
                    "status": 1
                }
            ]
        } 
    }

=========

## 2009-上传图片返回地址 [POST /v3/center?c=2009]
```
该接口用于上传图片返回地址。
接口名：uploadImg，接口编号：2009
```
**返回参数**
| **字段名** | **说明** | **数据类型** |
| :-: | :-: | :-: |
|url| 返回的地址 |  string|

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "img":"iVBORw0KGgoA"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "url": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1550311436940325600_87af80f3-a53d-4947-9bd3-c902660a549d.png?Expires=1550325837&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=LJn7H7vEheUHxSgU1FZOw%2FhH%2FPY%3D"
        }
    }

=========

## 2010-上传反馈的内容 [POST /v3/center?c=2010]
```
该接口用于上传反馈的内容。
接口名：feedback，接口编号：2010
```

**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "text":"填充内容",
        "phone":"联系方式",
        "imgs":"图片地址，以,分割"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
        }
    }

=========
 
## 2012-用户订阅专辑接口 [POST /v3/center?c=2012]
```
该接口用于订阅专辑，需要登录。
接口名：userSubscribe，接口编号：2012
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| status | 是否订阅：<br>1-订阅；<br>2-取消订阅；<br>0-查询是否订阅| 是| string   |
| type  | <a href="#type">类型定义</a> 1专辑；5分期专辑 | 是| string  |
| cid | 对应type的数据ID | 是| string |
| title | 当前订阅的标题 | 是,2013返回此主标题 | string |
| img | 当前订阅的背景图 | 否，不需要传 | string |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "status": "1",
        "type": "1",
        "cid": "181504605201408",
        "title": "测试2",
        "img": "http://xxx/xxx"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": "1",
            "text": "已订阅"
        }
    }

=========

## 2013-查询订阅专辑记录接口 [POST /v3/center?c=2013]
```
该接口用于查询用户订阅专辑，需用户登录
接口名：getAllAlbumSubscribe，接口编号：2013
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| id |对应type的数据ID|string|
| cid |专辑cid|string|
| type  | <a href="#type">类型定义</a> 1专辑；5分期专辑 | string  |
| title | 主标题,上传的title | string |
| img | 封面地址 | string |
| subtitle | 副标题 | string |
| updateTime | 更新时间，unix时间 | int64 |
| contentsNum | 音频数 | int64 |
| status |该条数据状态 |0禁用，1正常，2删除|

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 2,
            "content": [
                {
                    "id": "341320216149598208",
                    "cid": "3495833870016512",
                    "type": "5",
                    "img": "",
                    "title": "你的月亮我的心2",
                    "subtitle": "",
                    "updateTime": 0,
                    "contentsNum": 0,
                    "status": "2"
                },
                {
                    "id": "341281224540659712",
                    "cid": "3176954291560448",
                    "type": "5",
                    "img": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/test-tdbucketimg_d84e65d0cc8c4cfd673d29702d9d975b58a6a003.png?Expires=1556289387&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=kIhst%2BcMYANJeEKgftvs%2FVybvGI%3D",
                    "title": "吴彦祖专辑",
                    "subtitle": "特警新人类",
                    "updateTime": 1556177101,
                    "contentsNum": 1,
                    "status": "1"
                }
            ]
        }
    }

=========

## 2014-获取已购专辑 [POST /v3/center?c=2014]
```
该接口用于查询用户购买专辑，需用户登录
接口名：PersonalCenterGetBought，接口编号：2014
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| offset | 分页 |string|
| type | 是否分页 |string|
| count  | 数量 | string  |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| id | 唯一ID列表 | string|
| cid | 对应的音频ID | string|
| type  | 对应的音频类型 | string  |
| title  | 显示的title | string  |
| subtitle  | 显示的副标题 | string  |
| updateTime  | 更新时间 | int  |
| contentsNum  | 剩余总数 | int  |
| serial  | 是否为完本 | int |
| quality  | 是否为精品 | int  |
| paymentCount | 购买的集数 | int |
| paymentType  | 购买的类型，0表示购买多少集，显示取paymentCount，1表示购买整本 | int  |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1,
            "content": [
                {
                    "id": "341281224540659712",
                    "cid": "3176954291560448",
                    "type": "1",
                    "img": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/test-tdbucketimg_d84e65d0cc8c4cfd673d29702d9d975b58a6a003.png?Expires=1556289387&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=kIhst%2BcMYANJeEKgftvs%2FVybvGI%3D",
                    "title": "吴彦祖专辑",
                    "subtitle": "特警新人类",
                    "updateTime": 1556177101,
                    "contentsNum": 1,
                    "status": "1",
                    "serial": "1",
                    "quality": "1",
                    "paymentCount": 100,
                    "paymentType": "1"
                }
            ]
        }
    }

=========

## 2016-任务中心上报接口 [POST /v4/center?c=2016]
```
任务中心上报接口
接口名：PersonalCenterTaskUpload，接口编号：2016
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| id | 任务id | string|
| count | 上报的次数或时长 | string|
| type | 行为类型：1-完善个人资料，2-绑定社区账号，3-收听时长，4-签到，5-评论，6-分享，7-喜欢，8-订阅,9.设定个人偏好 | 是| int  |
| jobType | 任务类型：0-每日任务，1-新用户任务 | 是| int  
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| status | 状态，1：成功，0：失败 | int|


**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "id" : "7316877616488209201",
        "type" : "1",
        "jobType" : "1",
        "count" : "1"
    }
}
```

+ Response 200 (application/json)
    {
        "status":1
    }

=========

## 2017-领取任务积分接口 [POST /v4/center?c=2017]
```
领取任务积分接口
接口名：PersonalCenterTaskGetPoint，接口编号：2017
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| id | 任务id | string|
| type | 行为类型：1-完善个人资料，2-绑定社区账号，3-收听时长，4-签到，5-评论，6-分享，7-喜欢，8-订阅,9.设定个人偏好 | 是| int  |
| jobType | 任务类型：0-每日任务，1-新用户任务 | 是| int  
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| status | 状态，1：成功，0：失败 | int|
| text | 状态描述| string|


**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "id" : "7316877616488209201",
        "type" : "1",
        "jobType" : "1"
    }
}
```

+ Response 200 (application/json)
    {
        "status":1，
        "text":"领取成功"
    }

=========

## 2018-获取兑吧登录地址 [POST /v4/center?c=2018]
```
领取任务积分接口
接口名：PersonalCenterDuibaLoginUrl，接口编号：2018
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| redirect | redirect地址url| 否| string|
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| status | 状态，1：成功，0：失败 | int|
| text | 状态描述| string|


**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "redirect" : "https://activity.m.duiba.com.cn/aaw/lotterySquare/index?opId=3733748"
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "url": "https://activity.m.duiba.com.cn/autoLogin/autologin?sign=ab966ddf0d8d584be1a019efc59c05a7&credits=0&timestamp=15686056048645&uid=1810232029531260&appKey=2KKrWnBDTYBKcSSWRk7fhuTScfqM"
  }
}


=========
## 2019-获取用户积分明细 [POST /v4/center?c=2019]
```
领取任务积分接口
接口名：PersonalCenterPointHistory，接口编号：2019
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| 则需要登录|
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|offset | 第几页的数据 | string |
|count | 一页数据总量 | string |


**请求**
```
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "17724490919",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid": "87d205fa-91a5-4163-a4c2-33aa10c86c12"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "Content": [
      {
        "id": "414876577546178560",
        "title": "订阅",
        "subtitle": "1970-01-01",
        "pointsText": "+10"
      },
      {
        "id": "128851999948148736",
        "title": "10月新番3天VIP体验",
        "subtitle": "1970-01-01",
        "pointsText": "+3"
      },
      {
        "id": "128851938879082496",
        "title": "良品铺子专区满188减100元券",
        "subtitle": "1970-01-01",
        "pointsText": "+3"
      },
      {
        "id": "128851833258119168",
        "title": "小小运动馆美式儿童运动课程免费体验",
        "subtitle": "1970-01-01",
        "pointsText": "+5"
      },
      {
        "id": "414800288806121472",
        "title": "订阅",
        "subtitle": "1970-01-01",
        "pointsText": "+10"
      },
      {
        "id": "128851558757699584",
        "title": "签到拿积分测试版",
        "subtitle": "1970-01-01",
        "pointsText": "+5"
      },
      {
        "id": "128843456079597568",
        "title": "游戏加积分接口测试",
        "subtitle": "1970-01-01",
        "pointsText": "+500"
      },
      {
        "id": "414452782771331072",
        "title": "订阅",
        "subtitle": "1970-01-01",
        "pointsText": "+10"
      }
    ]
  }
}

=========

# 详情接口

## 4002-查询猜你喜欢内容 [POST /v3/detail?c=4002]
```
该接口用于查询指定用户推荐的模块音视频。
接口名：guess，接口编号：4002
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| offset | 分页的第几页，数据从1开始 | 否 | string |
| count | 每一页的数据  | 是 | string  |
| index | 3.2版本增加值，index取每次音频的index参数，如果没有则默认传0 | 是 | string |
| uid | 用户手机的唯一标识 | 否 | string |
| sid | 用户登录标识  | 否 | string  |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count | 数据总量|string|
|content |内容|string|
|id |对应type的数据ID|string|
|type | <a href="#type">类型定义</a> |string|
|name | 音频名称|string|
|publishName | 音频发布名称|string|
|subhead | 副标题|string|
|summary | 简介|string|
|img |背景图片url|string|
|bigImg | 大图 | string |
|palyUrl |播放地址|string|
|kps  | 音频的kps | string|
|authorId | 作者的ID | string |
|authorName  | 作者名称 | string|
|anchorType | 来源类型，0表示普通来源，1表示主播来源，后续可以扩展 | string|
|authorImg | 作者头像 | string|
|authorWords | 作者关键字 | string|
|authorFansCount | 关注的粉丝数 | int |
|createPersonName  | 创建名 | string|
|jumpUrl  | 跳转的url | string|
|jumpType | 跳转的类型，如果为空则没有跳转 | string|
|linkId  | 链接的ID | string|
|linkType | 链接的类型 | string|
|isFavorites |是否点赞，1表示点赞，0表示未点赞|string|
|isAttentionAuthor | 是否关注作者，1表示关注，0表示未关注，2表示相互关注| string |
|labels | 标签 | string |
|commentCount | 评论数 | int |
|forbidComment | 是否能评论，0表示能评论，1表示不能评论 | string |
|payment | 是否付费，0表示免费，1表示付费，2表示会员免费，3表示已购买，4表示试听 | string |
|paymentFee | 付费需要支付的金额 | float |

**请求**
```
{
    "base":{
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param":{ 
        "offset": "5",
        "count": "10"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1,
            "content": [
                {
                    "name": "测5555",
                    "publishName": "测试5555",
                    "subhead": "",
                    "summary": "用于测试",
                    "kps": "",
                    "authorId": "作者ID",
                    "authorName": "",
                    "anchorType": "0",
                    "authorImg": "xxx",
                    "authorWords": "xxx",
                    "authorFansCount": 10,
                    "createPersonName": "",
                    "id": "203481548523520",
                    "type": "5",
                    "img": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                    "bigImg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                    "duration": 11,
                    "playCount": 111,
                    "playUrl": "http://tdbucketdefault.oss-cn-shanghai.aliyuncs.com/himango/res/Jessie%20J%E8%AE%A9%E3%80%8A%E6%AD%8C%E6%89%8B%E3%80%8B%E7%BF%BB%E5%BC%80%E6%96%B0%E7%9A%84%E7%AF%87%E7%AB%A0.mp3",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "1970-01-01",
                    "linkId": "203481548523525",
                    "linkType": "5",
                    "isFavorites": "1",
                    "isAttentionAuthor": "1",
                    "labels": "新闻资讯",
                    "commentCount": 10,
                    "forbidComment": "0",
                    "payment": "1",
                    "paymentFee": 1.00
                }
            ]
        }
    }

=========

## 4005-查询音频专辑或者对应类型的信息 [POST /v3/detail?c=4005]
```
该接口用于查询指定内容的信息。
接口名：getContentInfo，接口编号：4005
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| cid | 对应type的数据ID   | 是  | string  |
| type | <a href="#type">类型定义</a>  |  否 |  string |
| count | 查询个数 | 否 |string|
| offset | 分页的第几页 |否 |string|
| sortOrder | 1-正序，<br>2-倒序 |否|string|
| beginIndex | 偏移量开始位置 | 否 | string |
| endIndex | 偏移量结束位置 | 否 | string |
| offsetType | 偏移的方式，1表示使用count，offset，sortOrder，2表示使用beginindex和endindex | 否 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|index |序列值|int|
|id |对应type的数据ID|string|
|type | <a href="#type">类型定义</a> |string|
|name | 音频名称|string|
|publishName | 音频发布名称|string|
|subhead | 副标题|string|
|summary | 简介|string|
|img |背景图片url|string|
|bigImg | 大图 |string |
|palyUrl |播放地址|string|
|palyCount |播放次数| int|
|kps  | 音频的kps | string|
|authorId   | 作者的ID | string |
|authorName  | 作者名称 | string|
|authorType | 来源类型，0表示普通来源，1表示主播来源，后续可以扩展 | string|
|authorImg | 作者头像 | string|
|authorWords | 作者关键字 | string|
|authorFansCount | 关注的粉丝数 | int |
|createPersonName  | 创建名 | string|
|jumpUrl  | 跳转的url | string|
|jumpType | 跳转的类型，如果为空则没有跳转 | string|
|isMore | 是否有更多专辑|string|
|content | 当返回列表类型，将数据放入这个数组中 | array|
|count  | 返回列表的条数 | string|
|periods | 表示期数，如果是分栏分期，其中拿到列表中对应的id再获取详细的信息 | array |
|periodsName | 期数名 | array |
|share字段|参照4015接口| |
|isSubscribe | 是否订阅，1表示订阅，2表示未订阅，针对专辑 | string |
|isFavorites |是否喜欢，针对音频|string|
|subscribeCount | 订阅的人数 | int |
|isAttentionAuthor | 是否关注作者，1表示关注，0表示未关注，2表示相互关注| string |
|contentsNum | 如果是专辑，包含的音频的总数 | int |
|commentCount | 评论数 | int |
|forbidComment | 是否能评论，0表示能评论，1表示不能评论 | string |
|payment | 是否付费，0表示免费，1表示付费，2表示会员免费，3表示已购买，4表示试听 | string |
|paymentFee | 付费需要支付的金额 | float |
|serial | 是否为完本，0表示完本，1表示非完本 | int |
|quality | 是否为精品，0表示非精品，1表示精品 | int |

**请求**
```
{
    "base":{
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param":{ 
        "cid":"1",
        "type":"1",
        "count": "20",
        "offset": "0"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1,
            "content": [
                {
                    "index": 0,
                    "name": "测5555",
                    "publishName": "测试5555",
                    "subhead": "",
                    "summary": "用于测试",
                    "kps": "",
                    "authorId":"",
                    "authorName": "",
                    "anchorType":"0",
                    "authorImg":"xxx",
                    "authorWords": "xxx",
                    "authorFansCount": 10,
                    "createPersonName": "",
                    "id": "203481548523520",
                    "type": "5",
                    "img": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                    "bigImg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                    "duration": 11,
                    "playCount": 111,
                    "playUrl": "http://tdbucketdefault.oss-cn-shanghai.aliyuncs.com/himango/res/Jessie%20J%E8%AE%A9%E3%80%8A%E6%AD%8C%E6%89%8B%E3%80%8B%E7%BF%BB%E5%BC%80%E6%96%B0%E7%9A%84%E7%AF%87%E7%AB%A0.mp3",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "1970-01-01",
                    "isAttentionAuthor": "1",
                    "contentsNum": "250",
                    "isSubscribe": "0",
                    "subscribeCount": 0,
                    "commentCount": 10,
                    "forbidComment": "0",
                    "payment": "1",
                    "paymentFee": 1.00,
                    "serial": "1",
                    "quality": "1"
                }
            ],
            "detail": {
                "index": 0,
                "name": "测5555",
                "publishName": "测试5555",
                "subhead": "",
                "summary": "用于测试",
                "kps": "",
                "authorId":"",
                "authorName": "",
                "authorType":"0",
                "authorImg":"xxx",
                "createPersonName": "",
                "id": "203481548523520",
                "type": "5",
                "img": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                "bigImg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                "duration": 11,
                "playCount": 111,
                "playUrl": "http://tdbucketdefault.oss-cn-shanghai.aliyuncs.com/himango/res/Jessie%20J%E8%AE%A9%E3%80%8A%E6%AD%8C%E6%89%8B%E3%80%8B%E7%BF%BB%E5%BC%80%E6%96%B0%E7%9A%84%E7%AF%87%E7%AB%A0.mp3",
                "jumpUrl": "",
                "jumpType": "",
                "issueDate": "1970-01-01",
                "shareType": 1,
                "shareLink": "http://www.baidu.com",
                "shareTitle": "http://www.baidu.com",
                "shareSubTitle": "http://www.baidu.com",
                "shareImg": "",
                "themeName": "测试11",
                "isFavorites": "1",
                "isAttentionAuthor": "1",
                "contentsNum": "250",
                "isMore": "0",
                "isSubscribe": "0",
                "subscribeCount": 0,
                "commentCount": 10,
                "forbidComment": "0",
                "payment": "1",
                "paymentFee": 1.00,
                "serial": "1",
                "quality": "1"
            },
            "periods": [
                {
                    "id": "203481548523520",
                    "type": "1",
                    "name": "",
                    "periodsName": "第一期",
                    "contentsNum": 10
                }
            ]
        }
    }

=========

## 4011-查询节目的播放地址  [POST /v3/detail?c=4011]
```
该接口用于查询指定节目的播放地址。
接口名：getPlayUrl，接口编号：4011 
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
|cid |对应type的数据ID |是|string|
|type |<a href="#type">类型定义</a>|是|string|
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|playUrl| 播放url|string|

**请求**
```
{
    "base":{
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param":{ 
       "cid":"1",
       "type":"1"
    }
}
```

+ Response 200 (application/json)
    { 
        "retcode": "000000",
        "desc": "查询成功",
        "biz": { 
            "playUrl": "http://oss-cn-shanghai.aliyuncs.com/1111"
        } 
    }

=========

## 4012-查询二级栏目的模板数据列表 [POST /v3/detail?c=4012]
```
该接口用于查询各个动态板块的数据。
接口名：getDynamicContentTemplateSoundV2，接口编号：4012
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|topicId| 对应的栏目ID |string|
|topicType| 对应栏目的类型（1-一级栏目，2-二级栏目，3-三级栏目） | string |
|offset | 第几页的数据 | string |
|count | 一页数据总量 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count| 总数(int) |string|
|content| 内容| array |
|list | 内容列表 | array |
|templateTitle | 配置模板的标题，如果为空则不显示 | string |
|templateSubtitle | 配置的子标题 | string |
|templateId | 配置模板的id | string |
|jumpId    | 跳转的id | string |
|jumpType  | 跳转的类型 | string |
|id |音视频的id|string|
|type |查询的类型|string|
|name| 标题|string|
|publishName| 发布名称|string|
|summary |简介|string|
|img |背景图片url|string|
|bigImg |大图url| string |
|playCount| 播放次数|int|
|duration | 播放时长 | int |
|playUrl | 播放url |string|
|issueDate| 发布时间 |string|
|jumpId | 跳转的ID | string |
|jumpType | 跳转的类型 | string |

**注意：其他字段与4005接口统一**

**请求**
```
{
    "base":{
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param":{
        "topicId": "10",
        "topicType": "1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 29,
            "content": [
            {
                "templateTitle": "Banner模板",
                "templateId": "18",
                "jumpId": "1",
                "jumpType": "1",
                "count": 1,
                "list": [
                {
                    "index": 0,
                    "name": "非常有梗",
                    "publishName": "非常有梗",
                    "subhead": "【笑一笑，十年少】",
                    "summary": "意想不到的段子让你捧腹大笑！",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "308366222722048",
                    "type": "6",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_362784625295360_a492e975-90de-4923-9c0a-826737f782ce5877210452358184925.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:wzdvW-_Y93mieeLK_E3_z95yEg8=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_362784837296128_5f52dc93-1fd5-4c1a-88fb-ea5f43dadfa97822664684717825923.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:XqnwGejFfYVCPjnV_VnsjzeUtN0=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "不定期更新",
                    "subscribeCount": 0,
                    "contentsNum": 0,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0,
                    "themeName": "专辑名"
                }
                ]
            },
            {
                "templateTitle": "非常有梗",
                "templateId": "9",
                "templateSubtitle": "xxx",
                "jumpId": "1",
                "jumpType": "1",
                "count": 1,
                "list": [
                {
                    "index": 0,
                    "name": "非常有梗",
                    "publishName": "非常有梗",
                    "subhead": "【笑一笑，十年少】",
                    "summary": "意想不到的段子让你捧腹大笑！",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "308366222722048",
                    "type": "6",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_362784625295360_a492e975-90de-4923-9c0a-826737f782ce5877210452358184925.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:wzdvW-_Y93mieeLK_E3_z95yEg8=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_362784837296128_5f52dc93-1fd5-4c1a-88fb-ea5f43dadfa97822664684717825923.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:XqnwGejFfYVCPjnV_VnsjzeUtN0=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "不定期更新",
                    "subscribeCount": 0,
                    "contentsNum": 0,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0,
                    "themeName": "专辑名"
                }
                ]
            },
            {
                "templateTitle": "",
                "templateId": "10",
                "templateSubtitle": "xxx",
                "jumpId": "1",
                "jumpType": "1",
                "count": 2,
                "list": [
                {
                    "index": 0,
                    "name": "轻松时刻",
                    "publishName": "轻松时刻",
                    "subhead": "轻松时刻轻松时刻",
                    "summary": "轻松时刻轻松时刻轻松时刻",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "312632606876672",
                    "type": "1",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：2019-03-11",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "每周五更新",
                    "subscribeCount": 0,
                    "contentsNum": 2,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0,
                    "themeName": "专辑名"
                },
                {
                    "index": 0,
                    "name": "张怡筠123",
                    "publishName": "张怡筠123",
                    "subhead": "张怡筠",
                    "summary": "张怡筠",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "312633292948480",
                    "type": "1",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_307788787221504_a8168d00-44fc-42c0-b473-49b5d63af3cd9113865813720192294.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Uf8FswVjrKn36vSpwlbKqslXAnU=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_307788787221504_a8168d00-44fc-42c0-b473-49b5d63af3cd9113865813720192294.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Uf8FswVjrKn36vSpwlbKqslXAnU=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：2019-03-11",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "每周五更新",
                    "subscribeCount": 0,
                    "contentsNum": 0,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0,
                    "themeName": "专辑名"
                }
                ]
            },
            {
                "templateTitle": "",
                "templateId": "11",
                "templateSubtitle": "xxx",
                "jumpId": "1",
                "jumpType": "1",
                "count": 1,
                "list": [
                {
                    "index": 0,
                    "name": "轻松时刻",
                    "publishName": "轻松时刻",
                    "subhead": "轻松时刻轻松时刻",
                    "summary": "轻松时刻轻松时刻轻松时刻",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "312632606876672",
                    "type": "1",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：2019-03-11",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "每周五更新",
                    "subscribeCount": 0,
                    "contentsNum": 2,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0,
                    "themeName": "专辑名"
                }
                ]
            },
            {
                "templateTitle": "",
                "templateId": "12",
                "templateSubtitle": "xxx",
                "jumpId": "1",
                "jumpType": "1",
                "count": 1,
                "list": [
                {
                    "index": 0,
                    "name": "轻松时刻",
                    "publishName": "轻松时刻",
                    "subhead": "轻松时刻轻松时刻",
                    "summary": "轻松时刻轻松时刻轻松时刻",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "312632606876672",
                    "type": "1",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：2019-03-11",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "每周五更新",
                    "subscribeCount": 0,
                    "contentsNum": 2,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0,
                    "themeName": "专辑名"
                }
                ]
            },
            {
                "templateTitle": "",
                "templateId": "13",
                "templateSubtitle": "xxx",
                "jumpId": "1",
                "jumpType": "1",
                "count": 1,
                "list": [
                {
                    "index": 0,
                    "name": "轻松时刻",
                    "publishName": "轻松时刻",
                    "subhead": "轻松时刻轻松时刻",
                    "summary": "轻松时刻轻松时刻轻松时刻",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "312632606876672",
                    "type": "1",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：2019-03-11",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "每周五更新",
                    "subscribeCount": 0,
                    "contentsNum": 2,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0,
                    "themeName": "专辑名"
                }
                ]
            }
            ]
        }
    }

=========

## 4013-根据跳转模板查询更多的数据 [POST /v3/detail?c=4013]
```
该接口用于跳转模板查询更多的数据。
接口名：getDynamicContentMoreData，接口编号：4013
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|jumpId| 对应动态模板返回的ID |string|
|jumpType| 对应动态模板跳转的类型 | string |
|offset | 第几页的数据 | string |
|count | 一页数据总量 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count| 总数(int) |string|
|content| 内容| array |
|id |音视频的id|string|
|type |查询的类型|string|
|name| 标题|string|
|publishName| 发布名称|string|
|summary |简介|string|
|img |背景图片url|string|
|bigImg |大图url| string |
|playCount| 播放次数|int|
|duration |播放时长 | int|
|playUrl |播放url|string|
|issueDate| 发布时间|string|

**注意：其他字段与4005接口统一**

**请求**
```
{
    "base":{
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param":{
        "jumpId": "10",
        "jumpType": "1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1,
            "content": [
            {
                "index": 0,
                "name": "非常有梗",
                "publishName": "非常有梗",
                "subhead": "【笑一笑，十年少】",
                "summary": "意想不到的段子让你捧腹大笑！",
                "kps": "",
                "authorName": "",
                "authorId": "",
                "authorImg": "",
                "authorType": "",
                "authorWords": "",
                "authorFansCount": 0,
                "labels": "",
                "createPersonName": "",
                "id": "308366222722048",
                "type": "6",
                "img": "http://s7.tingdao.com/test-tdbucketimg_362784625295360_a492e975-90de-4923-9c0a-826737f782ce5877210452358184925.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:wzdvW-_Y93mieeLK_E3_z95yEg8=",
                "bigImg": "http://s7.tingdao.com/test-tdbucketimg_362784837296128_5f52dc93-1fd5-4c1a-88fb-ea5f43dadfa97822664684717825923.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:XqnwGejFfYVCPjnV_VnsjzeUtN0=",
                "duration": 0,
                "playCount": 0,
                "playUrl": "",
                "jumpUrl": "",
                "jumpType": "",
                "issueDate": "更新时间：",
                "startTime": "1970-01-01",
                "endTime": "1970-01-01",
                "statusCn": "",
                "updateFrequency": "不定期更新",
                "subscribeCount": 0,
                "contentsNum": 0,
                "commentCount": 0,
                "forbidComment": "",
                "payment": "0",
                "paymentFee": 0,
                "paymentType": "",
                "isSubscribe": "0",
                "isFavorites": "0",
                "isAttentionAuthor": "0",
                "linkId": "",
                "linkType": "",
                "serial": 0,
                "quality": 0,
                "themeName": "专辑名"
            }
            ]
        }
    }

=========



## 4014-查询资讯模板内容 [POST /v3/detail?c=4014]
```
该接口用于跳转模板查询更多的数据。
接口名：getDynamicContentMoreData，接口编号：4014
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|topicId| 对应的栏目ID,topicId与templateLayoutId二选一，当是电台下资讯刘时传该参数 |string|
|topicType| 对应栏目的类型（1-一级栏目，2-二级栏目，3-三级栏目） | string |
|templateLayoutId| 模板ID |string|
|templateId | 配置模板的id（新资讯与老资讯cms配置在不同的表，需要加参数判断） | string |
|topicId + topicType 与 templateLayoutId +templateId ,二选一 |
|offset | 第几页的数据 | string |
|count | 一页数据总量 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count| 总数(int) |string|
|content| 内容| array |
|id |音视频的id|string|
|type |查询的类型|string|
|name| 标题|string|
|publishName| 发布名称|string|
|summary |简介|string|
|img |背景图片url|string|
|bigImg |大图url| string |
|playCount| 播放次数|int|
|duration |播放时长 | int|
|playUrl |播放url|string|
|issueDate| 发布时间|string|

**注意：其他字段与4005接口统一**

**请求**
```
{ 
    "base":{ 
        "userid" : "1810232029531260", 
        "caller" : "18514281314", 
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4", 
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334", 
        "version" : "2.1", 
        "osid" : "ios", 
        "apn" : "wifi", 
        "df" : "22010000", 
        "sid" : "7316877616488209201" 
    }, 
    "param":{ 
        "templateLayoutId": "5"
    } 
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "count": 45,
    "layoutImg": "http://s7.tingdao.com/test-tdbucketimg_986fef6e4b8d338581e578eccce309d42dfc482e.jpg-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:cMnyIOnaRUSb6HlGmOpTr04zbuA=",
    "content": [
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=9356155322680320&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "世间美好与你环环相扣",
        "publishName": "世间美好与你环环相扣",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "新闻资讯",
        "createPersonName": "",
        "id": "9356155322680320",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_9900b6694a8f79ebb30858a10c0826ae9d9164ac.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:BJ7zGJyMnmBpnaaJW0SXln4DRVc=",
        "bigImg": "http://s7.tingdao.com/test-tdbucketimg_9900b6694a8f79ebb30858a10c0826ae9d9164ac.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:BJ7zGJyMnmBpnaaJW0SXln4DRVc=",
        "duration": 181000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-11-08 09:40:00",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=9356155322680320&type=2",
        "shareTitle": "世间美好与你环环相扣",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_9900b6694a8f79ebb30858a10c0826ae9d9164ac.png?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:1UXrpEIn7h_8deZ9gHhWZo480OU="
      },
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=8997874257937408&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "周杰伦-稻香 (Demo)",
        "publishName": "周杰伦-稻香 (Demo)",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "我是歌手",
        "createPersonName": "",
        "id": "8997874257937408",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_e97af445738be2882ebc2d6d9b81e9423b5b3eeb.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:hdg3-XNKktzrzL4hOHJHdsv45Dc=",
        "bigImg": "",
        "duration": 244000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-10-31 11:52:00",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 5,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=8997874257937408&type=2",
        "shareTitle": "周杰伦-稻香 (Demo)",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_e97af445738be2882ebc2d6d9b81e9423b5b3eeb.png?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:SRajyjn5q820A7efwxvT_KPnrpQ="
      },
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=8420589213107200&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "野狼dddddddd",
        "publishName": "野狼dddddddd",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "休闲娱乐",
        "createPersonName": "",
        "id": "8420589213107200",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_544b2795d7214b426d8ba4d7de4bc92527ba48af.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:ssaYenAfUeYg1xN_nDm1ebFxh3M=",
        "bigImg": "http://s7.tingdao.com/test-tdbucketimg_544b2795d7214b426d8ba4d7de4bc92527ba48af.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:ssaYenAfUeYg1xN_nDm1ebFxh3M=",
        "duration": 239000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-10-19 04:34:00",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 12,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=8420589213107200&type=2",
        "shareTitle": "野狼dddddddd",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_544b2795d7214b426d8ba4d7de4bc92527ba48af.png?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:8QpzCvNic5c33dztcSj1v-hCzGw="
      },
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=7558929577460737&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "20190927-快乐颂-性格羞涩要怎么表白？",
        "publishName": "20190927-快乐颂-性格羞涩要怎么表白？",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "情感",
        "createPersonName": "",
        "id": "7558929577460737",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_0ae19548b108ebd6df46dde6a61f783856897b95.jpg-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:OcUe-ff8U_Cu-ZikkwYWaflZo9E=",
        "bigImg": "",
        "duration": 93000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-09-26 17:30:05",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=7558929577460737&type=2",
        "shareTitle": "20190927-快乐颂-性格羞涩要怎么表白？",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_0ae19548b108ebd6df46dde6a61f783856897b95.jpg?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:UgmIVfpheXV93bFKRq48ppMi3Po="
      },
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=7558929577460736&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "20190926-快乐颂-口是心非的女人",
        "publishName": "20190926-快乐颂-口是心非的女人",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "情感",
        "createPersonName": "",
        "id": "7558929577460736",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_9995cb9cdd5514659123775df74ac1eb77d149a9.jpg-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Tj5CjIO0ADhu08TSSPrHbugpxJw=",
        "bigImg": "",
        "duration": 127000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-09-26 17:30:05",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 1,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=7558929577460736&type=2",
        "shareTitle": "20190926-快乐颂-口是心非的女人",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_9995cb9cdd5514659123775df74ac1eb77d149a9.jpg?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:pK3nigmf_iGytg1ibUehnhT3ycQ="
      }
    ]
  }
}
**请求**
```
{ 
    "base":{ 
        "userid" : "1810232029531260", 
        "caller" : "18514281314", 
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4", 
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334", 
        "version" : "2.1", 
        "osid" : "ios", 
        "apn" : "wifi", 
        "df" : "22010000", 
        "sid" : "7316877616488209201" 
    }, 
    "param":{ 
        "templateLayoutId": "419295539360768",
        "templateId": "26",
         "offset": "1",
        "count": "100"
    } 
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "count": 45,
    "layoutImg": "http://s7.tingdao.com/test-tdbucketimg_986fef6e4b8d338581e578eccce309d42dfc482e.jpg-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:cMnyIOnaRUSb6HlGmOpTr04zbuA=",
    "content": [
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=9356155322680320&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "世间美好与你环环相扣",
        "publishName": "世间美好与你环环相扣",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "新闻资讯",
        "createPersonName": "",
        "id": "9356155322680320",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_9900b6694a8f79ebb30858a10c0826ae9d9164ac.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:BJ7zGJyMnmBpnaaJW0SXln4DRVc=",
        "bigImg": "http://s7.tingdao.com/test-tdbucketimg_9900b6694a8f79ebb30858a10c0826ae9d9164ac.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:BJ7zGJyMnmBpnaaJW0SXln4DRVc=",
        "duration": 181000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-11-08 09:40:00",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=9356155322680320&type=2",
        "shareTitle": "世间美好与你环环相扣",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_9900b6694a8f79ebb30858a10c0826ae9d9164ac.png?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:1UXrpEIn7h_8deZ9gHhWZo480OU="
      },
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=8997874257937408&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "周杰伦-稻香 (Demo)",
        "publishName": "周杰伦-稻香 (Demo)",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "我是歌手",
        "createPersonName": "",
        "id": "8997874257937408",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_e97af445738be2882ebc2d6d9b81e9423b5b3eeb.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:hdg3-XNKktzrzL4hOHJHdsv45Dc=",
        "bigImg": "",
        "duration": 244000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-10-31 11:52:00",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 5,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=8997874257937408&type=2",
        "shareTitle": "周杰伦-稻香 (Demo)",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_e97af445738be2882ebc2d6d9b81e9423b5b3eeb.png?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:SRajyjn5q820A7efwxvT_KPnrpQ="
      },
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=8420589213107200&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "野狼dddddddd",
        "publishName": "野狼dddddddd",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "休闲娱乐",
        "createPersonName": "",
        "id": "8420589213107200",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_544b2795d7214b426d8ba4d7de4bc92527ba48af.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:ssaYenAfUeYg1xN_nDm1ebFxh3M=",
        "bigImg": "http://s7.tingdao.com/test-tdbucketimg_544b2795d7214b426d8ba4d7de4bc92527ba48af.png-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:ssaYenAfUeYg1xN_nDm1ebFxh3M=",
        "duration": 239000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-10-19 04:34:00",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 12,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=8420589213107200&type=2",
        "shareTitle": "野狼dddddddd",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_544b2795d7214b426d8ba4d7de4bc92527ba48af.png?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:8QpzCvNic5c33dztcSj1v-hCzGw="
      },
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=7558929577460737&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "20190927-快乐颂-性格羞涩要怎么表白？",
        "publishName": "20190927-快乐颂-性格羞涩要怎么表白？",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "情感",
        "createPersonName": "",
        "id": "7558929577460737",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_0ae19548b108ebd6df46dde6a61f783856897b95.jpg-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:OcUe-ff8U_Cu-ZikkwYWaflZo9E=",
        "bigImg": "",
        "duration": 93000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-09-26 17:30:05",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=7558929577460737&type=2",
        "shareTitle": "20190927-快乐颂-性格羞涩要怎么表白？",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_0ae19548b108ebd6df46dde6a61f783856897b95.jpg?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:UgmIVfpheXV93bFKRq48ppMi3Po="
      },
      {
        "h5Url": "http://dev-h5.tingdao.com/h5/consult?cid=7558929577460736&type=2&layoutid=482435684003840&needReload=true&userid=",
        "index": 0,
        "name": "20190926-快乐颂-口是心非的女人",
        "publishName": "20190926-快乐颂-口是心非的女人",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "情感",
        "createPersonName": "",
        "id": "7558929577460736",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_9995cb9cdd5514659123775df74ac1eb77d149a9.jpg-st1?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Tj5CjIO0ADhu08TSSPrHbugpxJw=",
        "bigImg": "",
        "duration": 127000,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-09-26 17:30:05",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 1,
        "forbidComment": "0",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": "",
        "shareType": "1",
        "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=7558929577460736&type=2",
        "shareTitle": "20190926-快乐颂-口是心非的女人",
        "shareSubTitle": "",
        "shareImg": "http://s7.tingdao.com/test-tdbucketimg_9995cb9cdd5514659123775df74ac1eb77d149a9.jpg?e=1574979603&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:pK3nigmf_iGytg1ibUehnhT3ycQ="
      }
    ]
  }
}

=========


## 4016-查询主播模板内容 [POST /v3/detail?c=4016]
```
该接口用于跳转模板查询更多的数据。
接口名：getDynamicContentMoreData，接口编号：4016
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|templateLayoutId| 模板ID |string|
|offset | 第几页的数据 | string |
|count | 一页数据总量 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count| 总数(int) |string|
|content| 内容| array |
|id |音视频的id|string|
|type |查询的类型|string|
|name| 标题|string|
|publishName| 发布名称|string|
|summary |简介|string|
|img |背景图片url|string|
|bigImg |大图url| string |
|playCount| 播放次数|int|
|duration |播放时长 | int|
|playUrl |播放url|string|
|issueDate| 发布时间|string|

**注意：其他字段与4005接口统一**

**请求**
```
{ 
    "base":{ 
        "userid" : "1810232029531260", 
        "caller" : "18514281314", 
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4", 
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334", 
        "version" : "2.1", 
        "osid" : "ios", 
        "apn" : "wifi", 
        "df" : "22010000", 
        "sid" : "7316877616488209201" 
    }, 
    "param":{ 
        "templateLayoutId": "5"
    } 
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "count": 0,
    "content": [
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "一只锤子?",
        "authorId": "325720270784552960",
        "authorImg": "",
        "authorType": "1",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "0",
        "type": "",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "list": [
          {
            "index": 0,
            "name": "",
            "publishName": "梦然 - 读心",
            "subhead": "",
            "summary": "",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "186049851082752",
            "type": "2",
            "img": "test-tdbucketimg_60a4d61df4eb78ee0a01202159e7e54450119939.png",
            "bigImg": "",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "",
            "startTime": "",
            "endTime": "",
            "statusCn": "",
            "updateFrequency": "",
            "subscribeCount": 0,
            "contentsNum": 0,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "",
            "paymentFee": 0,
            "paymentType": "",
            "isSubscribe": "",
            "isFavorites": "",
            "isAttentionAuthor": "",
            "linkId": "",
            "linkType": "",
            "serial": 0,
            "quality": 0,
            "themeName": ""
          },
          {
            "index": 0,
            "name": "",
            "publishName": "吴亦凡、那吾克热·玉素甫江、Blow Fever - 家人 (Live)",
            "subhead": "",
            "summary": "",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "186049785546752",
            "type": "2",
            "img": "test-tdbucketimg_60a4d61df4eb78ee0a01202159e7e54450119939.png",
            "bigImg": "",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "",
            "startTime": "",
            "endTime": "",
            "statusCn": "",
            "updateFrequency": "",
            "subscribeCount": 0,
            "contentsNum": 0,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "",
            "paymentFee": 0,
            "paymentType": "",
            "isSubscribe": "",
            "isFavorites": "",
            "isAttentionAuthor": "",
            "linkId": "",
            "linkType": "",
            "serial": 0,
            "quality": 0,
            "themeName": ""
          },
          {
            "index": 0,
            "name": "",
            "publishName": "潘玮柏、G.E.M.邓紫棋、艾热、ICE - 蜕变 (Live)",
            "subhead": "",
            "summary": "",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "186049717446656",
            "type": "2",
            "img": "test-tdbucketimg_60a4d61df4eb78ee0a01202159e7e54450119939.png",
            "bigImg": "",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "",
            "startTime": "",
            "endTime": "",
            "statusCn": "",
            "updateFrequency": "",
            "subscribeCount": 0,
            "contentsNum": 0,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "",
            "paymentFee": 0,
            "paymentType": "",
            "isSubscribe": "",
            "isFavorites": "",
            "isAttentionAuthor": "",
            "linkId": "",
            "linkType": "",
            "serial": 0,
            "quality": 0,
            "themeName": ""
          }
        ]
      }
    ]
  }
}

=========
## 4017-查询html资讯内容接口 [POST /v3/detail?c=4017]
```
该接口用于html页面查询资讯内容并显示。
接口名：GetDynamicNewsTextMoreData，接口编号：4017
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|cid| 资讯唯一cid |string|

**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|text| 返回文本内容 |string|

**注意：其他字段与4005接口统一**

**请求**
```
{ 
    "base":{ 
        "userid" : "1810232029531260", 
        "caller" : "18514281314", 
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4", 
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334", 
        "version" : "2.1", 
        "osid" : "ios", 
        "apn" : "wifi", 
        "df" : "22010000", 
        "sid" : "7316877616488209201" 
    }, 
    "param":{ 
        "cid": "11"
    } 
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "text": "<p><span style=\"letter-spacing:1px\"><span style=\"line-height:1.8\"><span style=\"font-size:18px\">经济学很有趣，贯穿在我们的生活中</span></span></span></p ><p><span style=\"color:#000000\"><span style=\"letter-spacing:1px\"><span style=\"font-size:15px\"><span style=\"line-height:1.8\">经济学很有趣，贯穿在我们的生活中经济学很有趣，贯穿在我们的生活中经济学很有趣，贯穿在我们的生活中经济学很有趣，贯穿在我们的生活中经济学很有趣，贯穿在我们的生活中经济学很有趣，贯穿在我们的生活中经济学很有趣，贯穿在我们的生活中</span></span></span></span></p ><p><span style=\"letter-spacing:1px\"><span style=\"font-size:12px\"><span style=\"line-height:1.9\">经济学很有趣，贯穿在我们的生活中</span></span></span></p >"
  }
}

=========

## 4021-声音动态内容板块查询 [POST /v3/detail?c=4021]
```
该接口用于查询全部声音动态内容板块。
接口名：getDynamicContentTemplateSound，接口编号：4021
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|offset | 第几页的数据 | string |
|count | 一页数据总量 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count| 总数(int) |string|
|content| 内容| array |
|list | 内容列表 | array |
|templateTitle | 配置模板的标题，如果为空则不显示 | string |
|templateId | 配置模板的id（类型参考顶部的类型分类） | string |
|id |音视频的id|string|
|type |查询的类型|string|
|name| 标题|string|
|publishName| 发布名称|string|
|summary |简介|string|
|img |背景图片url|string|
|playCount| 播放次数|int|
|duration |播放时长 | int|
|playUrl |播放url|string|
|issueDate| 发布时间|string|

**注意：其他字段与4005接口统一**

**请求**
```
{
    "base":{
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param":{
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 29,
            "content": [
            {
                "templateTitle": "非常有梗",
                "templateId": "2",
                "count": 1,
                "list": [
                {
                    "index": 0,
                    "name": "非常有梗",
                    "publishName": "非常有梗",
                    "subhead": "【笑一笑，十年少】",
                    "summary": "意想不到的段子让你捧腹大笑！",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "308366222722048",
                    "type": "6",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_362784625295360_a492e975-90de-4923-9c0a-826737f782ce5877210452358184925.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:wzdvW-_Y93mieeLK_E3_z95yEg8=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_362784837296128_5f52dc93-1fd5-4c1a-88fb-ea5f43dadfa97822664684717825923.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:XqnwGejFfYVCPjnV_VnsjzeUtN0=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "不定期更新",
                    "subscribeCount": 0,
                    "contentsNum": 0,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0
                }
                ]
            },
            {
                "templateTitle": "",
                "templateId": "4",
                "count": 2,
                "list": [
                {
                    "index": 0,
                    "name": "轻松时刻",
                    "publishName": "轻松时刻",
                    "subhead": "轻松时刻轻松时刻",
                    "summary": "轻松时刻轻松时刻轻松时刻",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "312632606876672",
                    "type": "1",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_307820220228608_e1af6247-d61b-4ee8-9f86-5c26528d90cb4403120452510453489.png-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Qtvb7Dd2rt22a7laPBLObwOnO_0=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：2019-03-11",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "每周五更新",
                    "subscribeCount": 0,
                    "contentsNum": 2,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0
                },
                {
                    "index": 0,
                    "name": "张怡筠123",
                    "publishName": "张怡筠123",
                    "subhead": "张怡筠",
                    "summary": "张怡筠",
                    "kps": "",
                    "authorName": "",
                    "authorId": "",
                    "authorImg": "",
                    "authorType": "",
                    "authorWords": "",
                    "authorFansCount": 0,
                    "labels": "",
                    "createPersonName": "",
                    "id": "312633292948480",
                    "type": "1",
                    "img": "http://s7.tingdao.com/test-tdbucketimg_307788787221504_a8168d00-44fc-42c0-b473-49b5d63af3cd9113865813720192294.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Uf8FswVjrKn36vSpwlbKqslXAnU=",
                    "bigImg": "http://s7.tingdao.com/test-tdbucketimg_307788787221504_a8168d00-44fc-42c0-b473-49b5d63af3cd9113865813720192294.jpg-st1?e=1562264240&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Uf8FswVjrKn36vSpwlbKqslXAnU=",
                    "duration": 0,
                    "playCount": 0,
                    "playUrl": "",
                    "jumpUrl": "",
                    "jumpType": "",
                    "issueDate": "更新时间：2019-03-11",
                    "startTime": "1970-01-01",
                    "endTime": "1970-01-01",
                    "statusCn": "",
                    "updateFrequency": "每周五更新",
                    "subscribeCount": 0,
                    "contentsNum": 0,
                    "commentCount": 0,
                    "forbidComment": "",
                    "payment": "0",
                    "paymentFee": 0,
                    "paymentType": "",
                    "isSubscribe": "0",
                    "isFavorites": "0",
                    "isAttentionAuthor": "0",
                    "linkId": "",
                    "linkType": "",
                    "serial": 0,
                    "quality": 0
                }
                ]
            }
            ]
        }
    }

=========

## 4022-发现动态内容板块查询 [POST /v3/detail?c=4022]
```
该接口用于查询全部声音动态内容板块。
接口名：getDynamicContentTemplateFound，接口编号：4022
```
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| count | 总数(int) |string|
| content | 内容| array |
| list | 内容列表 | array |
| templateTitle | 配置模板的标题，如果为空则不显示 | string |
| templateId | 配置模板的id | string |
| name | 广告名称 |string|
| adType| 广告类型：<br>**0是链接，**<br>**1专辑，**<br>**2音频，**<br>**3视频** | string |
| linkType | <a href="#type">类型定义</a> |string|
| linkId | 关联音频id |string|
| linkUrl | 链接地址，type=0时有效 |string|
| imgUrl | 图片地址 |string|
| statusCn | 直播的状态 | string |

**请求**
```
{
    "base":{
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param":{
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 3,
            "content": [
                {
                    "templateTitle": "",
                    "templateId": "5",
                    "name": "测试",
                    "summary": "测试1111",
                    "adType": "1",
                    "linkType": "链接类型",
                    "linkId": "1",
                    "linkUrl": "http://www.baidu.com/",
                    "imgUrl": "http://tdbucketdefault.oss-cn-shanghai.aliyuncs.com/himango/res/IMG_1143.JPG",
                    "activityDate": "0001-01-01T00:00:00Z",
                    "statusCn": "直播中"
                },
                {
                    "templateTitle": "",
                    "templateId": "6",
                    "name": "测试",
                    "summary": "测试1111",
                    "adType": "1",
                    "linkType": "链接类型",
                    "linkId": "1",
                    "linkUrl": "http://www.baidu.com/",
                    "imgUrl": "http://tdbucketdefault.oss-cn-shanghai.aliyuncs.com/himango/res/IMG_1143.JPG",
                    "activityDate": "0001-01-01T00:00:00Z",
                    "statusCn": "直播中"
                },
                {
                    "templateTitle": "",
                    "templateId": "7",
                    "name": "测试",
                    "summary": "测试1111",
                    "adType": "1",
                    "linkType": "链接类型",
                    "linkId": "1",
                    "linkUrl": "http://www.baidu.com/",
                    "imgUrl": "http://tdbucketdefault.oss-cn-shanghai.aliyuncs.com/himango/res/IMG_1143.JPG",
                    "activityDate": "0001-01-01T00:00:00Z",
                    "statusCn": "直播中"
                }
            ]
        }
    }

=========

## 4024-查询指定区域的广播频率列表 [POST /v3/detail?c=4024]
```
该接口用户获取指定区域下的广播频率列表。
接口名：findChannelByArea，接口编号：4024
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
|areaId| 区域id |是|string|
|jointQuery| 是否联合查询上级广播 |是|string|
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|id| 广播Id | string |
|name| 广播名称 |string|
|areaId| 地区ID |long|
|logoImg| 频率图标 |string|
|source| 频率播放地址 | string |
|frequency| 频率 | string |
|radioLogo| 电台Logo | string |
|status| 状态，0表示未发布，1表示发布 | string |
|sort| 排序字段 |long|

**请求**
```
{
    "base":{
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param":{   
        "areaId":"41",
        "jointQuery":"1"
    }
}
```

+ Response 200 (application/json)
    {
        "count": 2,
        "content": [
            {
                "id": "6",
                "name": "长沙广播电台",
                "frequency": "FM88.8",
                "logoImg": "41",
                "areaId": "41",
                "source": "http://satellitepull.cnr.cn/live/wxahxxgb/playlist.m3u8",
                "status": "",
                "sort": 1
            }
        ],
        "parentquery": [
            {
                "id": "3",
                "name": "湖南广播电台",
                "frequency": "FM88.8",
                "logoImg": "111",
                "areaId": "40",
                "source": "http://satellitepull.cnr.cn/live/wxahxxgb/playlist.m3u8",
                "status": "",
                "sort": 1
            }
        ]
    }

=========

## 4025-查询指广播频率的当天的节目列表 [POST /v3/detail?c=4025]
```
该接口查询指定广播频率的当天的节目列表。
接口名：findChannelProgram，接口编号：4025
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
|radioId| 广播的id |是|string|
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|id |节目id |string|
|name| 节目名称 |string|
|date| 当前日期 |string|
|startTime |节目开始时间 |string|
|endTime |节目结束时间|string|
|source| 当前节目的播放地址 |string|
|sort |排序字段 |string|

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "radioId":"1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1,
            "content": [
                {
                    "id": "1",
                    "name": "湖南新闻联播",
                    "date": "2019-01-31",
                    "startTime": "2019-01-31 00:00:00",
                    "endTime": "2019-01-31 12:00:00",
                    "source": "",
                    "sort": -9999
                }
            ]
        }
    }

=========

## 4026-查询区域列表(城市列表) [POST /v3/detail?c=4026]
```
该接口用于查询区域列表。
接口名：getAreas，接口编号：4026
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|name |区域名称   |string|
|code |区域编码   |string|
|id |区域主键 |string|
|parentId | 对应parent的ID | string| 

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 340,
            "content": [
                {
                    "id": "2",
                    "parentId": "1",
                    "name": "长春",
                    "code": "10002",
                    "pinyin": ""
                },
                {
                    "id": "3",
                    "parentId": "1",
                    "name": "吉林",
                    "code": "10003",
                    "pinyin": ""
                }
            ],
            "hots": [
                {
                    "id": "2",
                    "parentId": "1",
                    "name": "长春",
                    "code": "10002",
                    "pinyin": ""
                }
            ]
        }
    }

=========

## 4027-查询热词列表 [POST /v3/detail?c=4027]
```
app端通过查询热词列表，默认随机查询20条记录。
接口名：getHotWords，接口编号：4027
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count |content的长度 |int|
|content |热词列表 | array |
|id |热词id|string|
|name |热词名称 |string|
|sort |排序 |string|
|heat |热度 |string|
|validity |是否有效 |string| 

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 3,
            "content": [
                {
                    "id": "216219601773568",
                    "name": "新闻",
                    "sort": -9999,
                    "heat": 126,
                    "validity": -9999
                },
                {
                    "id": "216219793147904",
                    "name": "刷刷朋友圈",
                    "sort": -9999,
                    "heat": 25,
                    "validity": -9999
                },
                {
                    "id": "216219873911808",
                    "name": "国生开讲",
                    "sort": -9999,
                    "heat": 154972,
                    "validity": -9999
                }
            ]
        }
    }

=========

## 4028-查询搜索联想词接口 [POST /v3/detail?c=4028]
```
该接口用于查询联想词的信息。
接口名：associate，接口编号：4028
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| uid | 用户手机的唯一标识 | 否 | string |
| sid | 用户登录标识  | 否 | string  |
| keyword | 关键字  | 是 | string  |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count | 返回数目|string|
|content |内容|string|
|id |对应类型的id|string|
|name | 联想词名称|string|

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "keyword":"测"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 2,
            "content": [
            {
                "id": "1",
                "name": "测试"
            },
            {
                "id": "2",
                "name": "测11111"
            }
            ]
        }
    }

=========

## 4029-查询开屏或者加载广告接口 [POST /v5/detail?c=4029]
```
app端查询开屏广告，接口名：getLoadingAds，接口编号：4029
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count | 返回数目|string|
|content |内容|string|
|id |对应类型的id|string|
|name | 联想词名称|string|
|adType | 广告类型：0是链接，1专辑，2音频，3视频,4主播,5无跳转 | string|
|linkTyp | app类型定义 | string|

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "id": "541215001900032",
    "name": "H5跳转",
    "adType": "0",
    "linkType": "13",
    "linkId": "",
    "linkUrl": "wwwwwwwwwwwwwwwwwwwwwwwwwwwwwww",
    "imgUrl": "http://s7.tingdao.com/test-tdbucketimg_6659772b7aeb75df2de9451720608d2389fc68bd.png?e=1580857917&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:E09HcRdZCH5TYMz9MozbievV2sI=",
    "showDuration": 3,
    "shareType": "1",
    "shareLink": "tingdaotingdaotingdaotingdao",
    "shareTitle": "aaaaa",
    "shareSubTitle": "11",
    "shareImg": "http://s7.tingdao.com/test-tdbucketimg_7e4a1b70a389f03205d922fdce017ea7a8b5a7c4.png-st1?e=1580857917&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:upWHunap1z6mZci5I-uwZs3iUCw="
  }
}

=========

## 4040-搜索的接口 [POST /v3/detail?c=4040]
```
该接口用于查询相关的信息。
接口名：search，接口编号：4040
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| uid | 用户手机的唯一标识 | 否 | string |
| sid | 用户登录标识  | 否 | string  |
| keyword | 关键字  | 是 | string  |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count | 返回数目|string|
|content |内容|string|
|id |对应类型的id|string|
|name | 音频名称|string|
|publishName | 发布名称|string|
|cid | 内容id|string|
|type | 类型：<br>11-主播，<br><a href="#type">类型定义</a> |string|
|img |背景图片url|string|
|duration |播放时长|string|
|fansCount |粉丝数|string|
|contentsNum |作品数|int64|
|playCount |播放次数|int64|
|updateDate |更新时间，只包含年月日|string|
|fansCount |粉丝数|int64|
|anchorLabel |主播标签|string|
|isAttentionAuthor|是否关注主播，1-表示关注，0-表示未关注，2表示相互关注|是|string|
|authorType | 来源类型，0表示普通来源，1表示主播来源，后续可以扩展 | string|

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "keyword": "111"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 5,
            "content": [
                {
                "id": "0",
                "name": "奔波灞霸波奔",
                "summary": "",
                "cid": "335067417108480",
                "type": "11",
                "imgurl": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1556189611428691839_3f31bd0f-12f0-4ada-b031-f8a7fcb2980d.png?Expires=1556307164&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=ZCS6hwomx70wZNQf1i6ZwhQT7qc%3D",
                "frequency": "",
                "logoimg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1556189611428691839_3f31bd0f-12f0-4ada-b031-f8a7fcb2980d.png?Expires=1556307164&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=ZCS6hwomx70wZNQf1i6ZwhQT7qc%3D",
                "jumpUrl": "",
                "subhead": "",
                "startTime": "",
                "updatetime": "活动时间：",
                "publishname": "奔波灞霸波奔",
                "updateDate": "",
                "anchorLabel": "",
                "fansCount": 8,
                "contentsNum": 11,
                "isAttentionAuthor": "",
                "authorType": "1"
            },
            {
                "id": "0",
                "name": "防务111",
                "summary": "",
                "cid": "300614476915712",
                "type": "3",
                "imgurl": "",
                "frequency": "",
                "logoimg": "",
                "jumpUrl": "www.baidu.com",
                "subhead": "测试直播",
                "startTime": "测试直播",
                "fansCount": "",
                "contentsNum": 0,
                "updateDate": "",
                "anchorLabel": "wqewqewqe",
                "fansCount": 111,
                "playCount": 0,
                "isAttentionAuthor": "",
                "authorType": "0"
            },
            {
                "id": "1",
                "name": "防务111",
                "summary": "",
                "cid": "302740413129728",
                "type": "2",
                "imgurl": "",
                "frequency": "",
                "logoimg": "",
                "jumpUrl": "",
                "subhead": "",
                "startTime": "",
                "fansCount": "",
                "audioCount": "",
                "updateDate": "",
                "playCount": "",
                "contentsNum": 0,
                "updateDate": "",
                "anchorLabel": "wqewqewqe",
                "fansCount": 111,
                "playCount": 0,
                "isAttentionAuthor": "",
                "authorType": "0"
            },
            {
                "id": "2",
                "name": "防务111",
                "summary": "",
                "cid": "302740059825152",
                "type": "2",
                "imgurl": "",
                "frequency": "",
                "logoimg": "",
                "jumpUrl": "",
                "subhead": "",
                "startTime": "",
                "fansCount": "",
                "audioCount": "",
                "updateDate": "",
                "playCount": "",
                "contentsNum": 0,
                "updateDate": "",
                "anchorLabel": "wqewqewqe",
                "fansCount": 111,
                "playCount": 0,
                "isAttentionAuthor": "",
                "authorType": "0"
            },
            {
                "id": "3",
                "name": "防务111",
                "summary": "",
                "cid": "302739643008000",
                "type": "2",
                "imgurl": "",
                "frequency": "",
                "logoimg": "",
                "jumpUrl": "",
                "subhead": "",
                "startTime": "",
                "contentsNum": 0,
                "updateDate": "",
                "anchorLabel": "wqewqewqe",
                "fansCount": 111,
                "playCount": 0,
                "isAttentionAuthor": "",
                "authorType": "0"
            }
            ]
        }
    }

=========

## 4041-经纬度查询地区 [POST /v3/detail?c=4041]
```
该接口用于根据经纬度查询地区信息。
接口名：LongLat，接口编号：4041
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| uid | 用户手机的唯一标识 | 否 | string |
| sid | 用户登录标识  | 否 | string  |
| longitude | 经度信息 | 是 | string |
| latitude | 纬度信息 | 是 | string  |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|proviceId |省份的ID|string|
|proviceName | 省的名称|string|
|proviceCode | 省的编码|string|
|cityId | 城市的ID|string|
|cityName | 城市的名称 |string|
|cityCode | 城市的编码 |string|

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "longitude":"1.1",
        "latitude":"20.1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "proviceId": "1",
            "proviceName": "湖南省",
            "proviceCode": "10000",
            "cityId": "2",
            "cityName": "长沙市",
            "cityCode": "10001"
        }
    }

=========

## 4042-查询热门广播频率列表 [POST /v3/detail?c=4042]
```
该接口用户获取指定区域下的广播频率列表。
接口名：GetHotRadio，接口编号：4042
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|id| 广播Id | string |
|name| 广播名称 | string |
|areaId| 地区ID | long |
|logoImg| 频率图标 | string |
|source| 频率播放地址 | string |
|frequency| 频率 | string |
|radioLogo| 电台Logo | string |
|status| 状态，0表示未发布，0表示发布 | string |
|sort| 排序字段 |long|

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1,
            "content": [
                {
                    "id": "1",
                    "name": "湖南广播电台",
                    "frequency": "Fm88.8.5",
                    "logoImg": "111",
                    "areaId": "1",
                    "source": "http://satellitepull.cnr.cn/live/wxahxxgb/playlist.m3u8",
                    "status": "",
                    "sort": 1
                }
            ]
        }
    }

=========

## 4043-查询省份及城市列表 [POST /v3/detail?c=4043]
```
该接口用于查询省份及城市区域列表。
接口名：getAreas，接口编号：4043
```
**返回参数**
| **字段名**  | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|name |区域名称   |string|
|code |区域编码   |string|
|id |区域主键 |string|
|parentId | 对应parent的ID | string| 

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 340,
            "content": [
                {
                    "id": "1",
                    "parentId": "0",
                    "name": "吉林",
                    "code": "10001",
                    "pinyin": ""
                },
                {
                    "id": "2",
                    "parentId": "1",
                    "name": "长春",
                    "code": "10002",
                    "pinyin": ""
                },
                {
                    "id": "3",
                    "parentId": "1",
                    "name": "吉林",
                    "code": "10003",
                    "pinyin": ""
                }
            ]
        }
    }

=========

## 4044-学习时刻接口 [POST /v3/detail?c=4044]
```
该接口用于查询相关的信息。
接口名：search，接口编号：4044
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| uid | 用户手机的唯一标识 | 否 | string |
| sid | 用户登录标识  | 否 | string  |
| offset | 分页的第几页 | 否  | string  |
| count | 每次查询个数，分页查询时生效 | 否 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count | 返回数目|string|
|id |学习时刻id|string|
|audioid |学习时刻音频id(cid)|string|
|newstitle |学习时刻title|string|
|audio |学习时刻音频信息|string|
|name |学习时刻音频name|string|
|publishname |学习时刻音频发布名称|string|

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "offset": "1",
        "count": "5"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 5,
            "content": [
            {
                "id": "1111",
                "audioid": "11111",
                "newstitle": "",
                "newsdate": "1970-01-01 08:00:00",
                "newsimg": "",
                "createtime": "1970-01-01 08:00:00",
                "updatetime": "1970-01-01 08:00:00",
                "audio": {
                    "name": "",
                    "publishname": "",
                    "summary": "",
                    "size": "",
                    "duration": "",
                    "type": "",
                    "kbps": "",
                    "playurl": "",
                    "img": ""
                }
            },
            {
                "id": "302567622886400",
                "audioid": "300627450684416",
                "newstitle": "娱乐",
                "newsdate": "2019-03-17 00:00:00",
                "newsimg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/test-tdbucketimg_302567610188800_939c2ff8-9d01-4c8d-b855-06a1571f00671806420033455110227.png?Expires=1552561126&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=Q5eTm7zNZTqN5%2BNTzvi6RJEKiFo%3D",
                "createtime": "1970-01-01 08:00:00",
                "updatetime": "1970-01-01 08:00:00",
                "audio": {
                    "name": "邓紫棋-龙卷风1 - 副本 (4)",
                    "publishname": "邓紫棋-龙卷风1 - 副本 (4)",
                    "summary": "",
                    "size": "3889",
                    "duration": "249495",
                    "type": "1",
                    "kbps": "128",
                    "playurl": "test-tdbucketaudio_300627513443328_6a37f05a-9705-4cd1-8633-87cb31853d59.mp3",
                    "img": ""
                }
            },
            {
                "id": "302569115534336",
                "audioid": "300619266515968",
                "newstitle": "国防",
                "newsdate": "2019-03-04 00:00:00",
                "newsimg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/test-tdbucketimg_302569107497984_623097e9-0231-4f95-ac49-fde52431bf88930963026651269910.png?Expires=1552561126&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=%2BSOCBdR5bksDHfs8%2BQcAEopEKi0%3D",
                "createtime": "1970-01-01 08:00:00",
                "updatetime": "1970-01-01 08:00:00",
                "audio": {
                    "name": "防务",
                    "publishname": "防务",
                    "summary": "",
                    "size": "163",
                    "duration": "10419",
                    "type": "1",
                    "kbps": "128",
                    "playurl": "test-tdbucketaudio_300619268498432_48eee2ff-ab09-4f59-9481-0ceb5042cfcf.mp3",
                    "img": ""
                }
            },
            {
                "id": "302722934842368",
                "audioid": "302674718761984",
                "newstitle": "社会新闻",
                "newsdate": "2019-03-04 00:00:00",
                "newsimg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/test-tdbucketimg_302722922636288_aaf42829-14a5-4948-813c-4f6fe13efaf17176195478174955579.png?Expires=1552561126&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=k19e1WbZ4OEkda3B7awQIoepG9w%3D",
                "createtime": "1970-01-01 08:00:00",
                "updatetime": "1970-01-01 08:00:00",
                "audio": {
                    "name": "林俊杰2",
                    "publishname": "林俊杰2",
                    "summary": "",
                    "size": "3889",
                    "duration": "249495",
                    "type": "1",
                    "kbps": "128",
                    "playurl": "test-tdbucketaudio_302674782077952_a3fdba37-6f6e-4c93-8108-448f73fbb491.mp3",
                    "img": ""
                }
            },
            {
                "id": "302743698875392",
                "audioid": "11111",
                "newstitle": "新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题新闻标题",
                "newsdate": "2019-03-12 00:00:00",
                "newsimg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/test-tdbucketimg_302743489643520_1efcca9b-dac9-4944-9b70-b37ae95651a67127106967000489865.png?Expires=1552561126&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=sqmqIdVzW7lGFlbEVA1kIkZtonc%3D",
                "createtime": "1970-01-01 08:00:00",
                "updatetime": "1970-01-01 08:00:00",
                "audio": {
                    "name": "",
                    "publishname": "",
                    "summary": "",
                    "size": "",
                    "duration": "",
                    "type": "",
                    "kbps": "",
                    "playurl": "",
                    "img": ""
                }
            }
            ]
        }
    }

=========

## 4046-根据ID查询对应的页数 [POST /v3/detail?c=4046]
```
接口名：GetOffsetByID，接口编号：4046
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|parentCid| 所属音频ID | string |
|parentType| 参考type类型 | string |
|cid| 音频ID | long |
|type| 参考type类型 | string |
| count | 一页数据的长度，默认为10 | string |
| sortOrder | 1-正序，<br>2-倒序，默认为1 |string|
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|offset | 对应的第几页 | int |
|themeId | 分期id | string |
|type| 专辑type | string |
**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param":{ 
        "parentType": "5",
        "parentCid": "5154277844632576",
        "count": "20",
        "type": "2",
        "sortOrder": "1",
        "cid": "391924878221313"
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "offset": 1,
    "themeId": "5154277845156864",
    "type": "1"
  }
}

=========

## 4047-根据资讯ID查询对应的页数 [POST /v3/detail?c=4047]
```
接口名：GetNewsContentOffsetByID，接口编号：4047
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|topicId| 对应的栏目ID |string|
|topicType| 对应栏目的类型（1-一级栏目，2-二级栏目，3-三级栏目） | string |
|查询时，topicId与templateLayoutId，必选其一|
|templateLayoutId| 模板id | string |
|cid| 资讯id | string |
| count | 一页数据的长度，默认为10 | string |
| sortOrder | 1-正序，<br>2-倒序，默认为1 |string|
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|offset | 对应的第几页 | int |

**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param":{ 
        "templateLayoutId": "414378215363584",
        "cid": "384794404978688",
        "count": "20",
        "sortOrder": "1"
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "offset": 2
  }
}
**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param":{ 
        "topicId": "20004",
        "topicType": "5",
        "cid": "9640416533595144",
        "count": "20",
        "sortOrder": "1"
    }
}
```

+ Response 200 (application/json)

  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "offset": 1,
    "themeId": "",
    "type": ""
  }
}

=========

## 4051-推荐每日推荐接口 [POST /v5/detail?c=4051]
```
接口名：DetailGetEveryday，接口编号：4051
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|topicId| 对应的栏目ID |string|
|topicType| 对应栏目的类型（1-一级栏目，2-二级栏目，3-三级栏目） | string |
| offset | 分页的第几页，从1开始包含当前记录 | 否  | string  |
| count | 每次查询个数 | 否 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|offset | 对应的第几页 | int |

**请求**
```
{
    "base" : {
        "userid" : "316239831577501696",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "98a3f98e-7ff1-440f-b1f2-c7c706c086cc"
    },
    "param":{ 
        "topicId": "10",
        "topicType": "10",
        "count": "10",
        "offset": "1"
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "everydayTime": "2019-11-28 00:00:00",
    "everydayMsg": "今日推荐",
    "content": [
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "5154376482604032",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "5154277844632576",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "9945646142374912",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "9356155322680320",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "7557975623910400",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "9953452245959680",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "8686539671913472",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      }
    ]
  }
}

=========

## 4052-v5版本模板数据 [POST /v5/detail?c=4052]
```
接口名：DetailGetEveryday，接口编号：4052
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|topicId| 对应的栏目ID |string|
|topicType| 对应栏目的类型（1-一级栏目，2-二级栏目，3-三级栏目） | string |
|offset | 第几页的数据 | string |
|count | 一页数据总量 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count| 总数(int) |string|
|content| 内容| array |
|list | 内容列表 | array |
|templateTitle | 配置模板的标题，如果为空则不显示 | string |
|templateSubtitle | 配置的子标题 | string |
|templateId | 配置模板的id | string |
|jumpId    | 跳转的id | string |
|jumpType  | 跳转的类型 | string |
|id |音视频的id|string|
|type |查询的类型|string|
|name| 标题|string|
|publishName| 发布名称|string|
|summary |简介|string|
|img |背景图片url|string|
|bigImg |大图url| string |
|playCount| 播放次数|int|
|duration | 播放时长 | int |
|playUrl | 播放url |string|
|issueDate| 发布时间 |string|
|jumpId | 跳转的ID | string |
|jumpType | 跳转的类型 | string |
|allCount | 总共数量，templateId为23,28的需要在页面上显示总共数量 | int |

**请求**
```
{
    "base" : {
        "userid" : "316239831577501696",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "98a3f98e-7ff1-440f-b1f2-c7c706c086cc"
    },
    "param":{ 
        "count": "10",
        "offset": "1"
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "count": 26,
    "content": [
      {
        "templateTitle": "测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测",
        "templateSubtitle": "测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测啊的",
        "templateId": "22",
        "templateLayoutId": "502266441061376",
        "jumpId": "502266441061376",
        "jumpType": "9",
        "isMore": "0",
        "count": 0,
        "allCount": 0,
        "list": [
          {
            "index": 0,
            "name": "测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测",
            "publishName": "",
            "subhead": "测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测啊的",
            "summary": "",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "502266441061376",
            "type": "14",
            "img": "http://s7.tingdao.com/test-tdbucketimg_d352cb560e1723b64f39a1305214d41f7065a018.jpg-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:ueosY7jQaZpQmaQXU0dcn_fP_y8=",
            "bigImg": "",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "http://dev-h5.tingdao.com/H5/subjectPage?cid=502266441061376",
            "jumpType": "1",
            "issueDate": "",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "不定期更新",
            "subscribeCount": 0,
            "contentsNum": 0,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 0,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "1",
            "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=502266441061376&type=22",
            "shareTitle": "",
            "shareSubTitle": "测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测啊的专题测啊测啊的",
            "shareImg": "http://s7.tingdao.com/test-tdbucketimg_d352cb560e1723b64f39a1305214d41f7065a018.jpg?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:afSuRopMgawcaa4iGrujMI1h6VU="
          }
        ]
      },
      {
        "templateTitle": "岸识竹",
        "templateSubtitle": "岸识竹岸识竹岸识竹岸识竹",
        "templateId": "28",
        "templateLayoutId": "501433765516288",
        "jumpId": "501433765516288",
        "jumpType": "9",
        "isMore": "1",
        "count": 10,
        "allCount": 14,
        "list": [
          {
            "index": 0,
            "name": "肯德基kfc",
            "publishName": "肯德基kfc",
            "subhead": "kfc",
            "summary": "we do chicken right  的的",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "5154277844632576",
            "type": "5",
            "img": "http://s7.tingdao.com/test-tdbucketimg_f3e7b98695e7bcdb263c2ad4bd6dbae86d59a7d6.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:H69aXvJDJrkYGO-4wy1k4JgJOUA=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_b5889ddbaa32610a8823ddc282815d297b238706.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:yCfq-_5pt56B-u-9NM0Ogl9Nl_4=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-09-12",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "12356",
            "subscribeCount": 115,
            "contentsNum": 28,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "麦当劳",
            "publishName": "麦当劳",
            "subhead": "McDonald's",
            "summary": "I’M LOVIN’ITI’M LOVIN’ITI’M LOVIN’ITI’M LOVIN’ITI’M LOVIN’IT",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "5154376482604033",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_88891e2a9f108a678419f7e30a128e97227b1927.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:LLUOcWJJDFWyTlxU0uCpGPKPSEc=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_8be90619e4487f3fdd885d316a7d18270730507a.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Ha7TqivZajtfVqEKrcdvWc8hhFQ=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-09-12",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "223",
            "subscribeCount": 0,
            "contentsNum": 3,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "单集收费",
            "publishName": "单集收费",
            "subhead": "单集单集单集单集单集单集单集单集单集",
            "summary": "打钱",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "9953452247008256",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_42fe332cd148194b0be9014fc1b6e6c246a66a80.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Ax6W0lmziljvwcAMQFcdM8TGcwU=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_76b064fcbb638f196f952be2a531b07d5567abda.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:85-GzGZrhv7OjaLR4eGfBmfYWO0=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "0RIEoSP2F4Tg+dhu5/sPYQ==",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-11-21",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "12580",
            "subscribeCount": 0,
            "contentsNum": 11,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "1",
            "paymentFee": 2,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 1,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "专辑付费",
            "publishName": "专辑付费",
            "subhead": "专辑专辑专辑专辑专辑专辑",
            "summary": "halohalohalohalohalohalohalohalohalohalohalohalohalo",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "8686539672437760",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_8f8917eb5c949f2f9601d78bb757351e2dff440a.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:GziiPk-kK5kKDbFjAQNmXQ_KXfE=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_1a57dd85b4b488f63b9e662dd0c603b54a7c4e0b.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:6U1-KX3FEuZXudrvKKgrDyC8zGU=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "0RIEoSP2F4Tg+dhu5/sPYQ==",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-10-24",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "22222",
            "subscribeCount": 1,
            "contentsNum": 4,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "1",
            "paymentFee": 2,
            "paymentType": "1",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 1,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "肯德基kfc",
            "publishName": "肯德基kfc",
            "subhead": "kfc",
            "summary": "we do chicken right  的的",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "5154277844632576",
            "type": "5",
            "img": "http://s7.tingdao.com/test-tdbucketimg_f3e7b98695e7bcdb263c2ad4bd6dbae86d59a7d6.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:H69aXvJDJrkYGO-4wy1k4JgJOUA=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_b5889ddbaa32610a8823ddc282815d297b238706.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:yCfq-_5pt56B-u-9NM0Ogl9Nl_4=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-09-12",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "12356",
            "subscribeCount": 115,
            "contentsNum": 28,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "专辑付费",
            "publishName": "专辑付费",
            "subhead": "专辑专辑专辑专辑专辑专辑",
            "summary": "halohalohalohalohalohalohalohalohalohalohalohalohalo",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "8686539672437760",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_8f8917eb5c949f2f9601d78bb757351e2dff440a.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:GziiPk-kK5kKDbFjAQNmXQ_KXfE=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_1a57dd85b4b488f63b9e662dd0c603b54a7c4e0b.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:6U1-KX3FEuZXudrvKKgrDyC8zGU=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "0RIEoSP2F4Tg+dhu5/sPYQ==",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-10-24",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "22222",
            "subscribeCount": 1,
            "contentsNum": 4,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "1",
            "paymentFee": 2,
            "paymentType": "1",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 1,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "单集收费",
            "publishName": "单集收费",
            "subhead": "单集单集单集单集单集单集单集单集单集",
            "summary": "打钱",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "9953452247008256",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_42fe332cd148194b0be9014fc1b6e6c246a66a80.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Ax6W0lmziljvwcAMQFcdM8TGcwU=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_76b064fcbb638f196f952be2a531b07d5567abda.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:85-GzGZrhv7OjaLR4eGfBmfYWO0=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "0RIEoSP2F4Tg+dhu5/sPYQ==",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-11-21",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "12580",
            "subscribeCount": 0,
            "contentsNum": 11,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "1",
            "paymentFee": 2,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 1,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "测试音频定位专辑",
            "publishName": "测试音频定位专辑",
            "subhead": "测试音频定位专辑",
            "summary": "测试音频定位专辑测试音频定位专辑测试音频定位专辑",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "9954016849085440",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_8d9a155b19fcb02be8fa496549718f46a34f7282.jpg-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:vvhKt4Xodcu8weQvJb82XrYfYUs=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_a154d45daa5f587cc8d75b47707094c75997baf1.jpg-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:clQn2ZnyK7FhuGLm-Eo5qAqfy7k=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "0RIEoSP2F4Tg+dhu5/sPYQ==",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-11-21",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "测试音频定位专",
            "subscribeCount": 0,
            "contentsNum": 29,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "1",
            "paymentFee": 2,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 0,
            "quality": 1,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "麦当劳",
            "publishName": "麦当劳",
            "subhead": "McDonald's",
            "summary": "I’M LOVIN’ITI’M LOVIN’ITI’M LOVIN’ITI’M LOVIN’ITI’M LOVIN’IT",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "5154376482604033",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_88891e2a9f108a678419f7e30a128e97227b1927.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:LLUOcWJJDFWyTlxU0uCpGPKPSEc=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_8be90619e4487f3fdd885d316a7d18270730507a.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Ha7TqivZajtfVqEKrcdvWc8hhFQ=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-09-12",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "223",
            "subscribeCount": 0,
            "contentsNum": 3,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "音频定位2",
            "publishName": "音频定位2",
            "subhead": "音频定位2",
            "summary": "音频定位2音频定位2音频定位2音频定位2音频定位2音频定位2",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "9954608201384960",
            "type": "5",
            "img": "http://s7.tingdao.com/test-tdbucketimg_0a8aefa53d004a76e48582afddfc46eda92156c2.jpg-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:ZoE6VA_ZG-7aCBdK8yjLREjuFfw=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_6d408d476abf81fc2fe696059060b653af2ecd42.jpg-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:xcc2uWE5qnKR2a2_3jIWPfjsyK4=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-11-21",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "音频定位2",
            "subscribeCount": 0,
            "contentsNum": 30,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "1",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 0,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          }
        ]
      },
      {
        "templateTitle": "专题测试专题测试专题测试专题测试",
        "templateSubtitle": "专题专题专题专题专题专题专题",
        "templateId": "22",
        "templateLayoutId": "500861679735808",
        "jumpId": "500861679735808",
        "jumpType": "9",
        "isMore": "0",
        "count": 0,
        "allCount": 0,
        "list": [
          {
            "index": 0,
            "name": "专题测试专题测试专题测试专题测试",
            "publishName": "",
            "subhead": "专题专题专题专题专题专题专题",
            "summary": "",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "500861679735808",
            "type": "14",
            "img": "http://s7.tingdao.com/test-tdbucketimg_303cd277e9ff1a9872634132eac7bfb5d2239d14.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Em3aof3FhD_VdpgiJ0q66Ek7Y1I=",
            "bigImg": "",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "http://dev-h5.tingdao.com/H5/subjectPage?cid=500861679735808",
            "jumpType": "1",
            "issueDate": "",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "不定期更新",
            "subscribeCount": 0,
            "contentsNum": 0,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 0,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "1",
            "shareLink": "http://dev-h5.tingdao.com/activity/sharev3?cid=500861679735808&type=22",
            "shareTitle": "",
            "shareSubTitle": "专题专题专题专题专题专题专题",
            "shareImg": "http://s7.tingdao.com/test-tdbucketimg_303cd277e9ff1a9872634132eac7bfb5d2239d14.png?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:PcbCwtt_T8nF5vXtAbH_iVrrH5A="
          }
        ]
      },
      {
        "templateTitle": "每日专栏",
        "templateSubtitle": "123",
        "templateId": "28",
        "templateLayoutId": "495782848803840",
        "jumpId": "495782848803840",
        "jumpType": "9",
        "isMore": "0",
        "count": 4,
        "allCount": 4,
        "list": [
          {
            "index": 0,
            "name": "肯德基kfc",
            "publishName": "肯德基kfc",
            "subhead": "kfc",
            "summary": "we do chicken right  的的",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "5154277844632576",
            "type": "5",
            "img": "http://s7.tingdao.com/test-tdbucketimg_f3e7b98695e7bcdb263c2ad4bd6dbae86d59a7d6.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:H69aXvJDJrkYGO-4wy1k4JgJOUA=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_b5889ddbaa32610a8823ddc282815d297b238706.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:yCfq-_5pt56B-u-9NM0Ogl9Nl_4=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-09-12",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "12356",
            "subscribeCount": 115,
            "contentsNum": 28,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "专辑付费",
            "publishName": "专辑付费",
            "subhead": "专辑专辑专辑专辑专辑专辑",
            "summary": "halohalohalohalohalohalohalohalohalohalohalohalohalo",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "8686539672437760",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_8f8917eb5c949f2f9601d78bb757351e2dff440a.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:GziiPk-kK5kKDbFjAQNmXQ_KXfE=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_1a57dd85b4b488f63b9e662dd0c603b54a7c4e0b.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:6U1-KX3FEuZXudrvKKgrDyC8zGU=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "0RIEoSP2F4Tg+dhu5/sPYQ==",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-10-24",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "22222",
            "subscribeCount": 1,
            "contentsNum": 4,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "1",
            "paymentFee": 2,
            "paymentType": "1",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 1,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "测试音频定位专辑",
            "publishName": "测试音频定位专辑",
            "subhead": "测试音频定位专辑",
            "summary": "测试音频定位专辑测试音频定位专辑测试音频定位专辑",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "9954016849085440",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_8d9a155b19fcb02be8fa496549718f46a34f7282.jpg-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:vvhKt4Xodcu8weQvJb82XrYfYUs=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_a154d45daa5f587cc8d75b47707094c75997baf1.jpg-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:clQn2ZnyK7FhuGLm-Eo5qAqfy7k=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "0RIEoSP2F4Tg+dhu5/sPYQ==",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-11-21",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "测试音频定位专",
            "subscribeCount": 0,
            "contentsNum": 29,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "1",
            "paymentFee": 2,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 0,
            "quality": 1,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "麦当劳",
            "publishName": "麦当劳",
            "subhead": "McDonald's",
            "summary": "I’M LOVIN’ITI’M LOVIN’ITI’M LOVIN’ITI’M LOVIN’ITI’M LOVIN’IT",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "5154376482604033",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_88891e2a9f108a678419f7e30a128e97227b1927.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:LLUOcWJJDFWyTlxU0uCpGPKPSEc=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_8be90619e4487f3fdd885d316a7d18270730507a.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Ha7TqivZajtfVqEKrcdvWc8hhFQ=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-09-12",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "223",
            "subscribeCount": 0,
            "contentsNum": 3,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          }
        ]
      },
      {
        "templateTitle": "横向专辑横向专辑横向专辑横",
        "templateSubtitle": "横向专辑横向专辑横向专辑横向专",
        "templateId": "25",
        "templateLayoutId": "495780641625088",
        "jumpId": "495780641625088",
        "jumpType": "9",
        "isMore": "1",
        "count": 3,
        "allCount": 0,
        "list": [
          {
            "index": 0,
            "name": "兰博基尼5元券111122222222123",
            "publishName": "兰博基尼5元券111122222222123",
            "subhead": "1111",
            "summary": "112212",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "4828106264708096",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_84c8ba0eebadfa5cfdf657e558f55365751b7dbe.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:DYn-uUCiPRCY9t6CITuyYV-kPYM=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_9cbea0274f62202a9f6a44498110ba35feaaa657.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:96kjZIJlfTG_CTqWXSV9ZF8tFYY=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-09-12",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "不定期更新",
            "subscribeCount": 7,
            "contentsNum": 36,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "0",
            "paymentFee": 0,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 0,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "专辑付费",
            "publishName": "专辑付费",
            "subhead": "专辑专辑专辑专辑专辑专辑",
            "summary": "halohalohalohalohalohalohalohalohalohalohalohalohalo",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "8686539672437760",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_8f8917eb5c949f2f9601d78bb757351e2dff440a.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:GziiPk-kK5kKDbFjAQNmXQ_KXfE=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_1a57dd85b4b488f63b9e662dd0c603b54a7c4e0b.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:6U1-KX3FEuZXudrvKKgrDyC8zGU=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "0RIEoSP2F4Tg+dhu5/sPYQ==",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-10-24",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "22222",
            "subscribeCount": 1,
            "contentsNum": 4,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "1",
            "paymentFee": 2,
            "paymentType": "1",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 1,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          },
          {
            "index": 0,
            "name": "单集收费",
            "publishName": "单集收费",
            "subhead": "单集单集单集单集单集单集单集单集单集",
            "summary": "打钱",
            "kps": "",
            "authorName": "",
            "authorId": "",
            "authorImg": "",
            "authorType": "",
            "authorWords": "",
            "authorFansCount": 0,
            "labels": "",
            "createPersonName": "",
            "id": "9953452247008256",
            "type": "1",
            "img": "http://s7.tingdao.com/test-tdbucketimg_42fe332cd148194b0be9014fc1b6e6c246a66a80.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:Ax6W0lmziljvwcAMQFcdM8TGcwU=",
            "bigImg": "http://s7.tingdao.com/test-tdbucketimg_76b064fcbb638f196f952be2a531b07d5567abda.png-st1?e=1576096499&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:85-GzGZrhv7OjaLR4eGfBmfYWO0=",
            "duration": 0,
            "playCount": 0,
            "playUrl": "0RIEoSP2F4Tg+dhu5/sPYQ==",
            "jumpUrl": "",
            "jumpType": "",
            "issueDate": "2019-11-21",
            "startTime": "1970-01-01",
            "endTime": "1970-01-01",
            "statusCn": "",
            "updateFrequency": "12580",
            "subscribeCount": 0,
            "contentsNum": 11,
            "commentCount": 0,
            "forbidComment": "",
            "payment": "1",
            "paymentFee": 2,
            "paymentType": "0",
            "isSubscribe": "0",
            "isFavorites": "0",
            "isAttentionAuthor": "0",
            "linkId": "",
            "linkType": "",
            "serial": 1,
            "quality": 1,
            "themeName": "",
            "themeImg": "",
            "shareType": "",
            "shareLink": "",
            "shareTitle": "",
            "shareSubTitle": "",
            "shareImg": ""
          }
        ]
      }
    ]
  }
}

=========

## 4053-排行版数据 [POST /v5/detail?c=4053]
```
接口名：GetDynamicV5ContentMoreData，接口编号：4053
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|templateLayoutId| 模板ID |string|
| offset | 分页的第几页，从1开始包含当前记录 | 否  | string  |
| count | 每次查询个数 | 否 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |


**请求**
```
{
  "base" : {
    "userid" : "1810232036463280",
    "caller" : "18514281314",
    "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
    "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
    "version" : "2.1",
    "osid" : "ios",
    "apn" : "wifi",
    "df" : "22010000",
    "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
  },
  "param": {
    "offset": "0",
    "count": "10",
    "templateLayoutId": "497152242496512"
  }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "count": 0,
    "img": "",
    "type": "2",
    "title": "vbbbbbbww",
    "subtitle": "",
    "updateDate": "2019-07-18 11:36:00",
    "content": [
      {
        "index": 0,
        "name": "剪云者",
        "publishName": "剪云者",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "4783627452335104",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_323f56f41aa3dbd173c7d2c8db5f30a52da086f1.jpg-st1?e=1575664507&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:N4-SQilzR80Ijdk9ou5iNjZThWw=",
        "bigImg": "http://s7.tingdao.com/test-tdbucketimg_9fa7ba369d27b4f6f07040f75c8d3e22d7c6ee41.jpg-st1?e=1575664507&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:bFwtSSxOv5smBg4-qZAvZhTu1e0=",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-09-12 15:34:11",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "A-Sky-Full-of-Stars",
        "publishName": "我是测试同步",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "4790839007036416",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-09-12 15:34:11",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "sound_of_silence",
        "publishName": "sound_of_silence",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "7152149521810432",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-09-20 17:58:54",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "德玛西亚 - 副本",
        "publishName": "德玛西亚 - 副本",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "9954730380411906",
        "type": "2",
        "img": "http://s7.tingdao.com/test-tdbucketimg_1a23e9aa11caf7bf99b675552620d51e0a26befe.jpg-st1?e=1575664507&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:2rhP8Sj_maQHXeYR3QK3hYohmQI=",
        "bigImg": "http://s7.tingdao.com/test-tdbucketimg_4f588f68ad87b4c8faa3d7dd492cab5acf3bba66.jpg-st1?e=1575664507&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:SDlCGk6UbAoVRHFCRcbMFyjqg4I=",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-11-21 14:49:00",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      }
    ]
  }
}

=========

## 4054-获取专题数据 [POST /v5/detail?c=4054]
```
接口名：GetDynamicV5ProjectMoreData，接口编号：4054
```
**请求参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| cid | 对应type的数据ID   | 是  | string  |
| type | <a href="#type">类型定义</a>  |  否 |  string |
| offset | 分页的第几页，从1开始包含当前记录 | 否  | string  |
| count | 每次查询个数 | 否 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| readCount | 阅读量 |  是 |  int64 |
| count | 总数 |  是 |  int64 |
1.5：专辑,2：音频,11：主播,14：专题,24：文本，25：图片
**请求**
```
{ 
    "base":{ 
        "userid" : "1810232029531260", 
        "caller" : "18514281314", 
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4", 
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334", 
        "version" : "2.1", 
        "osid" : "ios", 
        "apn" : "wifi", 
        "df" : "22010000", 
        "sid" : "7316877616488209201" 
    }, 
    "param":{ 
        "cid": "10242236893676544"
    } 
}
```

+ Response 200 (application/json)

{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "count": 4,
    "title": "来呀造作呀",
    "authorName": "苗苗",
    "issueDate": "2019-11-28 11:22:52",
    "readCount": 0,
    "content": [
      {
        "index": 0,
        "name": "单集收费",
        "publishName": "",
        "subhead": "",
        "summary": "打钱",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "9953452247008256",
        "type": "1",
        "img": "http://s7.tingdao.com/test-tdbucketimg_42fe332cd148194b0be9014fc1b6e6c246a66a80.png-st1?e=1575065696&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:wda3DgMPS-KsFy6J8i67n59sf8A=",
        "bigImg": "http://s7.tingdao.com/test-tdbucketimg_76b064fcbb638f196f952be2a531b07d5567abda.png-st1?e=1575065696&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:j2QFUqbmx8DX_DY4WjnmqP_u0fE=",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "<blockquote>褪放纽扣儿，解开罗带结。<br>酥胸白似银，玉体浑如雪。<br>肘膊赛凝胭，香肩欺粉贴。<br>肚皮软又绵，脊背光还洁。<br>膝腕半围团，金莲三寸窄。<br>中间一段情，露出风流穴。 </blockquote>",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "<blockquote>褪放纽扣儿，解开罗带结。<br>酥胸白似银，玉体浑如雪。<br>肘膊赛凝胭，香肩欺粉贴。<br>肚皮软又绵，脊背光还洁。<br>膝腕半围团，金莲三寸窄。<br>中间一段情，露出风流穴。 </blockquote>",
        "type": "4",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "",
        "publishName": "",
        "subhead": "",
        "summary": "test-tdbucketimg_a4c9f39077bedc90af425266b2da0325442c395e.jpg",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "test-tdbucketimg_a4c9f39077bedc90af425266b2da0325442c395e.jpg",
        "type": "",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "",
        "startTime": "",
        "endTime": "",
        "statusCn": "",
        "updateFrequency": "",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "",
        "isFavorites": "",
        "isAttentionAuthor": "",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      },
      {
        "index": 0,
        "name": "그 중에 그대를 만나(人海之中遇见你)",
        "publishName": "그 중에 그대를 만나(人海之中遇见你)",
        "subhead": "",
        "summary": "",
        "kps": "",
        "authorName": "",
        "authorId": "",
        "authorImg": "",
        "authorType": "",
        "authorWords": "",
        "authorFansCount": 0,
        "labels": "",
        "createPersonName": "",
        "id": "9907875040757248",
        "type": "2",
        "img": "",
        "bigImg": "",
        "duration": 0,
        "playCount": 0,
        "playUrl": "",
        "jumpUrl": "",
        "jumpType": "",
        "issueDate": "2019-11-20 14:01:03",
        "startTime": "1970-01-01",
        "endTime": "1970-01-01",
        "statusCn": "",
        "updateFrequency": "不定期更新",
        "subscribeCount": 0,
        "contentsNum": 0,
        "commentCount": 0,
        "forbidComment": "",
        "payment": "0",
        "paymentFee": 0,
        "paymentType": "",
        "isSubscribe": "0",
        "isFavorites": "0",
        "isAttentionAuthor": "0",
        "linkId": "",
        "linkType": "",
        "serial": 0,
        "quality": 0,
        "themeName": "",
        "themeImg": ""
      }
    ]
  }
}

=========
## 4080-查询配置文件 [POST /v5/detail?c=4080]
```
该接口用户查询配置文件。
接口名：DetailConfig，接口编号：4080
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| domain | 域名信息 | string |
| type | 类目类型 0-功能菜单,1-类目, 2-H5 | string |
| url | 跳转位置，当type="2",跳转位置 | string |
| id | 类目id，每个类别有一个唯一id| string |
| focus | 是否选中| bool |
| color | 背景色| string |
| icon | 类目图标| string |
| titleColor | 类目颜色| string |
| titleSelectedColor | 类目选中颜色| string |
| iconFocus | 类目选中图标| string |
| bkGroundImage | 背景图| string |
| searchBarColor | 搜索栏颜色| string |
| indicatorColor | 指示器颜色| string |

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
{
    "retcode": "000000",
    "desc": "操作成功",
    "biz": {
        "argeeUrl": "https://fm.tingdao.com/html/agreement.html",
        "domain": "https://fm.tingdao.com",
        "helpUrl": "https://fm.tingdao.com/html/help.html",
        "learningSwitch": "1",
        "learningUrl": "http://h5.tingdao.com/learn/time",
        "logCount": 5,
        "logInterval": 30,
        "paysecret": "YGdFxPHzDifLgZlp",
        "protocol": "http://tdbucketdefault.oss-cn-shanghai.aliyuncs.com/himango/mangofm.html",
        "shareAnchorUrl": "http://h5.tingdao.com/anchor/share",
        "title": {
            "count": 4,
            "content": [
                {
                    "id": "1",
                    "type": "1",
                    "name": "推荐",
                    "url": "",
                    "focus": true,
                    "color": "#FFFFFFFF",
                    "icon": "",
                    "titleColor": "",
                    "titleSelectedColor": "",
                    "colorFocus":  "#FFFFFFFF",
                    "iconFocus": "",
                    "bkGroundImage": "",
                    "searchBarColor": "",
                    "indicatorColor": ""
                    "subConfig": [
                        {
                            "id": "10",
                            "type": "10",
                            "name": "今日",
                            "url": "",
                            "focus": false,
                            "color": "#FFFFFFFF",
                            "icon": "",
                            "titleColor": "",
                            "titleSelectedColor": "",
                            "colorFocus":  "#FFFFFFFF",
                            "iconFocus": "",
                            "bkGroundImage": "",
                            "searchBarColor": "",
                            "indicatorColor": "",
                            "subConfig": null
                        },                    
                        {
                            "id": "6",
                            "type": "6",
                            "name": "电台",
                            "url": "",
                            "focus": false,
                            "color": "#FFFFFFFF",
                            "icon": "",
                            "titleColor": "",
                            "titleSelectedColor": "",
                            "colorFocus":  "#FFFFFFFF",
                            "iconFocus": "",
                            "bkGroundImage": "",
                            "searchBarColor": "",
                            "indicatorColor": "",
                            "subConfig": null
                        }
                    ]
                },
                {
                    "id": "2",
                    "type": "2",
                    "name": "声音",
                    "url": "",
                    "focus": false,
                    "color": "#FFFFFFFF",
                    "icon": "",
                    "titleColor": "",
                    "titleSelectedColor": "",
                    "colorFocus":  "#FFFFFFFF",
                    "iconFocus": "",
                    "bkGroundImage": "",
                    "searchBarColor": "",
                    "indicatorColor": ""
                    "subConfig": [
                        {
                            "id": "5",
                            "type": "5",
                            "name": "可配类目（模板列表）",
                            "url": "",
                            "focus": false,
                            "color": "#FFFFFFFF",
                            "icon": "",
                            "titleColor": "",
                            "titleSelectedColor": "",
                            "colorFocus":  "#FFFFFFFF",
                            "iconFocus": "",
                            "bkGroundImage": "",
                            "searchBarColor": "",
                            "indicatorColor": "",
                            "subConfig": null
                        }
                    ]
                },
                {
                    "id": "3",
                    "type": "3",
                    "name": "听书",
                    "url": "",
                    "focus": false,
                    "color": "#FFFFFFFF",
                    "icon": "",
                    "titleColor": "",
                    "titleSelectedColor": "",
                    "colorFocus":  "#FFFFFFFF",
                    "iconFocus": "",
                    "bkGroundImage": "",
                    "searchBarColor": "",
                    "indicatorColor": "",
                    "subConfig": [
                        {
                            "id": "7",
                            "type": "7",
                            "name": "不可配类目（模板列表）",
                            "url": "",
                            "focus": false,
                            "color": "#FFFFFFFF",
                            "icon": "",
                            "titleColor": "",
                            "titleSelectedColor": "",
                            "colorFocus":  "#FFFFFFFF",
                            "iconFocus": "",
                            "bkGroundImage": "",
                            "searchBarColor": "",
                            "indicatorColor": "",
                            "subConfig": null
                        }                    
                    ]
                },
                {
                   "id": "4",
                    "type": "4",
                    "name": "我的",
                    "url": "",
                    "focus": false,
                    "color": "#FFFFFFFF",
                    "icon": "",
                    "titleColor": "",
                    "titleSelectedColor": "",
                    "colorFocus":  "#FFFFFFFF",
                    "iconFocus": "",
                    "bkGroundImage": "",
                    "searchBarColor": "",
                    "indicatorColor": "",
                    "subConfig": null
                },                    
            ]
        }
    }
}

=========

## 4081-请求二级菜单名 [POST /v5/detail?c=4081]
```
该接口用户查询二级菜单名
接口名：DetailConfig，接口编号：4081
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| domain | 域名信息 | string |
| type | 类目类型 0-功能菜单,1-类目, 2-H5 | string |
| url | 跳转位置，当type="2",跳转位置 | string |
| id | 类目id，每个类别有一个唯一id| string |
| focus | 是否选中| bool |
| color | 背景色| string |
| icon | 类目图标| string |
| titleColor | 类目颜色| string |
| titleSelectedColor | 类目选中颜色| string |
| iconFocus | 类目选中图标| string |
| bkGroundImage | 背景图| string |
| searchBarColor | 搜索栏颜色| string |
| indicatorColor | 指示器颜色| string |

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "id": "4"
    }
}
```

+ Response 200 (application/json)
{
    "retcode": "000000",
    "desc": "操作成功",
    "biz": {
        "count": 5    
        "content": [
            {
                "id": "11",
                "type": "1",
                "name": "推荐",
                "url": "",
                "focus": false,
                "color": "#FFFFFFFF",
                "icon": "",
                "titleColor": "",
                "titleSelectedColor": "",
                "colorFocus":  "#FFFFFFFF",
                "iconFocus": "",
                "bkGroundImage": "",
                "searchBarColor": "",
                "indicatorColor": "",
                "subConfig": null         
            },
            {
                "id": "12",
                "type": "1",
                "name": "综艺",
                "url": "",
                "focus": false,
                "color": "#FFFFFFFF",
                "icon": "",
                "titleColor": "",
                "titleSelectedColor": "",
                "colorFocus":  "#FFFFFFFF",
                "iconFocus": "",
                "bkGroundImage": "",
                "searchBarColor": "",
                "indicatorColor": "",
                "subConfig": null
            },
            {
                "id": "13",
                "type": "1",
                "name": "娱乐",
                "url": "",
                "focus": false,
                "color": "#FFFFFFFF",
                "icon": "",
                "titleColor": "",
                "titleSelectedColor": "",
                "colorFocus":  "#FFFFFFFF",
                "iconFocus": "",
                "bkGroundImage": "",
                "searchBarColor": "",
                "indicatorColor": "",
                "subConfig": null
            },
            {
                "id": "14",
                "type": "1",
                "name": "大剧",
                "url": "",
                "focus": false,
                "color": "#FFFFFFFF",
                "icon": "",
                "titleColor": "",
                "titleSelectedColor": "",
                "colorFocus":  "#FFFFFFFF",
                "iconFocus": "",
                "bkGroundImage": "",
                "searchBarColor": "",
                "indicatorColor": "",
                "subConfig": null
            },
            {
                "id": "15",
                "type": "1",
                "name": "情感",
                "url": "",
                "focus": false,
                "color": "#FFFFFFFF",
                "icon": "",
                "titleColor": "",
                "titleSelectedColor": "",
                "colorFocus":  "#FFFFFFFF",
                "iconFocus": "",
                "bkGroundImage": "",
                "searchBarColor": "",
                "indicatorColor": "",
                "subConfig": null
            }
        ],
    }
}

=========

## 4082-获取弹窗 [POST /v4/detail?c=4082]
```
获取弹窗
接口名：DetailPop，接口编号：4082
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| id | 弹窗id | int |
| 1 | 专辑 | string  |
| 2 | 节目 | string  |
| 3 | 专题活动 | string  |
| 4 | 广播 | string  |
| 5 | 分期专辑 | string  |
| 6 | 专栏专辑 | string  |
| 7 | 直播 | string  |
| 8 | 广告 | string  |
| 11 | 主播 | string  |
| 12 | 无跳转 | string  |
| 11 | h5 | string  |

**请求**
```
{
    "base": {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
  {
        "id": "1111",
        "cid": "2",
        "type": "2",
        "title": "",
        "imgUrl": "www.baidu.com",
        "jumpUrl": "www.baidu.com"
}

=========

## 4083-获取区号或地区信息 [POST /v5/detail?c=4083]
```
获取区号或地区信息
接口名：DetailCodeConfig，接口编号：4083
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| requestType | 请求类型，1.获取地区信息，2.获取手机区号信息 | string |

**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "requestType": "2"
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "content": [
      {
        "en": "Andorra",
        "name": "安道尔共和国",
        "pinyin": "adeghg",
        "short": "AD",
        "tel": "376"
      },
      {
        "en": "UnitedArabEmirates",
        "name": "阿拉伯联合酋长国",
        "pinyin": "alblhqzg",
        "short": "AE",
        "tel": "971"
      },
      {
        "en": "Afghanistan",
        "name": "阿富汗",
        "pinyin": "afh",
        "short": "AF",
        "tel": "93"
      },
      {
        "en": "AntiguaandBarbuda",
        "name": "安提瓜和巴布达",
        "pinyin": "atghbbd",
        "short": "AG",
        "tel": "1268"
      },
      {
        "en": "Anguilla",
        "name": "安圭拉岛",
        "pinyin": "agld",
        "short": "AI",
        "tel": "1264"
      },
      {
        "en": "Albania",
        "name": "阿尔巴尼亚",
        "pinyin": "aebny",
        "short": "AL",
        "tel": "355"
      },
      {
        "en": "Armenia",
        "name": "阿美尼亚",
        "pinyin": "amny",
        "short": "AM",
        "tel": "374"
      },
      {
        "en": "Ascension",
        "name": "阿森松",
        "pinyin": "als",
        "short": "",
        "tel": "247"
      },
      {
        "en": "Angola",
        "name": "安哥拉",
        "pinyin": "agl",
        "short": "AO",
        "tel": "244"
      },
      {
        "en": "Argentina",
        "name": "阿根廷",
        "pinyin": "agt",
        "short": "AR",
        "tel": "54"
      },
      {
        "en": "Austria",
        "name": "奥地利",
        "pinyin": "adl",
        "short": "AT",
        "tel": "43"
      },
      {
        "en": "Australia",
        "name": "澳大利亚",
        "pinyin": "adly",
        "short": "AU",
        "tel": "61"
      },
      {
        "en": "Azerbaijan",
        "name": "阿塞拜疆",
        "pinyin": "asbj",
        "short": "AZ",
        "tel": "994"
      },
      {
        "en": "Barbados",
        "name": "巴巴多斯",
        "pinyin": "bbds",
        "short": "BB",
        "tel": "1246"
      },
      {
        "en": "Bangladesh",
        "name": "孟加拉国",
        "pinyin": "mjlg",
        "short": "BD",
        "tel": "880"
      },
      {
        "en": "Belgium",
        "name": "比利时",
        "pinyin": "bls",
        "short": "BE",
        "tel": "32"
      },
      {
        "en": "Burkina-faso",
        "name": "布基纳法索",
        "pinyin": "bjnfs",
        "short": "BF",
        "tel": "226"
      },
      {
        "en": "Bulgaria",
        "name": "保加利亚",
        "pinyin": "bjly",
        "short": "BG",
        "tel": "359"
      },
      {
        "en": "Bahrain",
        "name": "巴林",
        "pinyin": "bl",
        "short": "BH",
        "tel": "973"
      },
      {
        "en": "Burundi",
        "name": "布隆迪",
        "pinyin": "bld",
        "short": "BI",
        "tel": "257"
      },
      {
        "en": "Benin",
        "name": "贝宁",
        "pinyin": "bl",
        "short": "BJ",
        "tel": "229"
      },
      {
        "en": "Palestine",
        "name": "巴勒斯坦",
        "pinyin": "blst",
        "short": "BL",
        "tel": "970"
      },
      {
        "en": "BermudaIs.",
        "name": "百慕大群岛",
        "pinyin": "bmdqd",
        "short": "BM",
        "tel": "1441"
      },
      {
        "en": "Brunei",
        "name": "文莱",
        "pinyin": "wl",
        "short": "BN",
        "tel": "673"
      },
      {
        "en": "Bolivia",
        "name": "玻利维亚",
        "pinyin": "blwy",
        "short": "BO",
        "tel": "591"
      },
      {
        "en": "Brazil",
        "name": "巴西",
        "pinyin": "bx",
        "short": "BR",
        "tel": "55"
      },
      {
        "en": "Bahamas",
        "name": "巴哈马",
        "pinyin": "bhm",
        "short": "BS",
        "tel": "1242"
      },
      {
        "en": "Botswana",
        "name": "博茨瓦纳",
        "pinyin": "bcwn",
        "short": "BW",
        "tel": "267"
      },
      {
        "en": "Belarus",
        "name": "白俄罗斯",
        "pinyin": "bels",
        "short": "BY",
        "tel": "375"
      },
      {
        "en": "Belize",
        "name": "伯利兹",
        "pinyin": "blz",
        "short": "BZ",
        "tel": "501"
      },
      {
        "en": "Canada",
        "name": "加拿大",
        "pinyin": "jnd",
        "short": "CA",
        "tel": "1"
      },
      {
        "en": "CaymanIs.",
        "name": "开曼群岛",
        "pinyin": "kmqd",
        "short": "",
        "tel": "1345"
      },
      {
        "en": "CentralAfricanRepublic",
        "name": "中非共和国",
        "pinyin": "zfghg",
        "short": "CF",
        "tel": "236"
      },
      {
        "en": "Congo",
        "name": "刚果",
        "pinyin": "gg",
        "short": "CG",
        "tel": "242"
      },
      {
        "en": "Switzerland",
        "name": "瑞士",
        "pinyin": "rs",
        "short": "CH",
        "tel": "41"
      },
      {
        "en": "CookIs.",
        "name": "库克群岛",
        "pinyin": "kkqd",
        "short": "CK",
        "tel": "682"
      },
      {
        "en": "Chile",
        "name": "智利",
        "pinyin": "zl",
        "short": "CL",
        "tel": "56"
      },
      {
        "en": "Cameroon",
        "name": "喀麦隆",
        "pinyin": "kml",
        "short": "CM",
        "tel": "237"
      },
      {
        "en": "China",
        "name": "中国",
        "pinyin": "zg",
        "short": "CN",
        "tel": "86"
      },
      {
        "en": "Colombia",
        "name": "哥伦比亚",
        "pinyin": "glby",
        "short": "CO",
        "tel": "57"
      },
      {
        "en": "CostaRica",
        "name": "哥斯达黎加",
        "pinyin": "gsdlj",
        "short": "CR",
        "tel": "506"
      },
      {
        "en": "Czech",
        "name": "捷克",
        "pinyin": "jk",
        "short": "CS",
        "tel": "420"
      },
      {
        "en": "Cuba",
        "name": "古巴",
        "pinyin": "gb",
        "short": "CU",
        "tel": "53"
      },
      {
        "en": "Cyprus",
        "name": "塞浦路斯",
        "pinyin": "spls",
        "short": "CY",
        "tel": "357"
      },
      {
        "en": "CzechRepublic",
        "name": "捷克",
        "pinyin": "jk",
        "short": "CZ",
        "tel": "420"
      },
      {
        "en": "Germany",
        "name": "德国",
        "pinyin": "dg",
        "short": "DE",
        "tel": "49"
      },
      {
        "en": "Djibouti",
        "name": "吉布提",
        "pinyin": "jbt",
        "short": "DJ",
        "tel": "253"
      },
      {
        "en": "Denmark",
        "name": "丹麦",
        "pinyin": "dm",
        "short": "DK",
        "tel": "45"
      },
      {
        "en": "DominicaRep.",
        "name": "多米尼加共和国",
        "pinyin": "dmnjghg",
        "short": "DO",
        "tel": "1890"
      },
      {
        "en": "Algeria",
        "name": "阿尔及利亚",
        "pinyin": "aejly",
        "short": "DZ",
        "tel": "213"
      },
      {
        "en": "Ecuador",
        "name": "厄瓜多尔",
        "pinyin": "egde",
        "short": "EC",
        "tel": "593"
      },
      {
        "en": "Estonia",
        "name": "爱沙尼亚",
        "pinyin": "asny",
        "short": "EE",
        "tel": "372"
      },
      {
        "en": "Egypt",
        "name": "埃及",
        "pinyin": "ej",
        "short": "EG",
        "tel": "20"
      },
      {
        "en": "Spain",
        "name": "西班牙",
        "pinyin": "xby",
        "short": "ES",
        "tel": "34"
      },
      {
        "en": "Ethiopia",
        "name": "埃塞俄比亚",
        "pinyin": "aseby",
        "short": "ET",
        "tel": "251"
      },
      {
        "en": "Finland",
        "name": "芬兰",
        "pinyin": "fl",
        "short": "FI",
        "tel": "358"
      },
      {
        "en": "Fiji",
        "name": "斐济",
        "pinyin": "fj",
        "short": "FJ",
        "tel": "679"
      },
      {
        "en": "France",
        "name": "法国",
        "pinyin": "fg",
        "short": "FR",
        "tel": "33"
      },
      {
        "en": "Gabon",
        "name": "加蓬",
        "pinyin": "jp",
        "short": "GA",
        "tel": "241"
      },
      {
        "en": "UnitedKiongdom",
        "name": "英国",
        "pinyin": "yg",
        "short": "GB",
        "tel": "44"
      },
      {
        "en": "Grenada",
        "name": "格林纳达",
        "pinyin": "glnd",
        "short": "GD",
        "tel": "1809"
      },
      {
        "en": "Georgia",
        "name": "格鲁吉亚",
        "pinyin": "gljy",
        "short": "GE",
        "tel": "995"
      },
      {
        "en": "FrenchGuiana",
        "name": "法属圭亚那",
        "pinyin": "fsgyn",
        "short": "GF",
        "tel": "594"
      },
      {
        "en": "Ghana",
        "name": "加纳",
        "pinyin": "jn",
        "short": "GH",
        "tel": "233"
      },
      {
        "en": "Gibraltar",
        "name": "直布罗陀",
        "pinyin": "zblt",
        "short": "GI",
        "tel": "350"
      },
      {
        "en": "Gambia",
        "name": "冈比亚",
        "pinyin": "gby",
        "short": "GM",
        "tel": "220"
      },
      {
        "en": "Guinea",
        "name": "几内亚",
        "pinyin": "jny",
        "short": "GN",
        "tel": "224"
      },
      {
        "en": "Greece",
        "name": "希腊",
        "pinyin": "xl",
        "short": "GR",
        "tel": "30"
      },
      {
        "en": "Guatemala",
        "name": "危地马拉",
        "pinyin": "wdml",
        "short": "GT",
        "tel": "502"
      },
      {
        "en": "Guam",
        "name": "关岛",
        "pinyin": "gd",
        "short": "GU",
        "tel": "1671"
      },
      {
        "en": "Guyana",
        "name": "圭亚那",
        "pinyin": "gyn",
        "short": "GY",
        "tel": "592"
      },
      {
        "en": "Hongkong",
        "name": "香港(中国)",
        "pinyin": "xgzg",
        "short": "HK",
        "tel": "852"
      },
      {
        "en": "Honduras",
        "name": "洪都拉斯",
        "pinyin": "hdls",
        "short": "HN",
        "tel": "504"
      },
      {
        "en": "Haiti",
        "name": "海地",
        "pinyin": "hd",
        "short": "HT",
        "tel": "509"
      },
      {
        "en": "Hungary",
        "name": "匈牙利",
        "pinyin": "xyl",
        "short": "HU",
        "tel": "36"
      },
      {
        "en": "Indonesia",
        "name": "印度尼西亚",
        "pinyin": "ydnxy",
        "short": "ID",
        "tel": "62"
      },
      {
        "en": "Ireland",
        "name": "爱尔兰",
        "pinyin": "ael",
        "short": "IE",
        "tel": "353"
      },
      {
        "en": "Israel",
        "name": "以色列",
        "pinyin": "ysl",
        "short": "IL",
        "tel": "972"
      },
      {
        "en": "India",
        "name": "印度",
        "pinyin": "yd",
        "short": "IN",
        "tel": "91"
      },
      {
        "en": "Iraq",
        "name": "伊拉克",
        "pinyin": "ylk",
        "short": "IQ",
        "tel": "964"
      },
      {
        "en": "Iran",
        "name": "伊朗",
        "pinyin": "yl",
        "short": "IR",
        "tel": "98"
      },
      {
        "en": "Iceland",
        "name": "冰岛",
        "pinyin": "bd",
        "short": "IS",
        "tel": "354"
      },
      {
        "en": "Italy",
        "name": "意大利",
        "pinyin": "ydl",
        "short": "IT",
        "tel": "39"
      },
      {
        "en": "IvoryCoast",
        "name": "科特迪瓦",
        "pinyin": "ktdw",
        "short": "",
        "tel": "225"
      },
      {
        "en": "Jamaica",
        "name": "牙买加",
        "pinyin": "ymj",
        "short": "JM",
        "tel": "1876"
      },
      {
        "en": "Jordan",
        "name": "约旦",
        "pinyin": "yd",
        "short": "JO",
        "tel": "962"
      },
      {
        "en": "Japan",
        "name": "日本",
        "pinyin": "rb",
        "short": "JP",
        "tel": "81"
      },
      {
        "en": "Kenya",
        "name": "肯尼亚",
        "pinyin": "kny",
        "short": "KE",
        "tel": "254"
      },
      {
        "en": "Kyrgyzstan",
        "name": "吉尔吉斯坦",
        "pinyin": "jejst",
        "short": "KG",
        "tel": "331"
      },
      {
        "en": "Kampuchea(Cambodia)",
        "name": "柬埔寨",
        "pinyin": "jpz",
        "short": "KH",
        "tel": "855"
      },
      {
        "en": "NorthKorea",
        "name": "朝鲜",
        "pinyin": "cx",
        "short": "KP",
        "tel": "850"
      },
      {
        "en": "Korea",
        "name": "韩国",
        "pinyin": "hg",
        "short": "KR",
        "tel": "82"
      },
      {
        "en": "RepublicofIvoryCoast",
        "name": "科特迪瓦共和国",
        "pinyin": "ktdwghg",
        "short": "KT",
        "tel": "225"
      },
      {
        "en": "Kuwait",
        "name": "科威特",
        "pinyin": "kwt",
        "short": "KW",
        "tel": "965"
      },
      {
        "en": "Kazakstan",
        "name": "哈萨克斯坦",
        "pinyin": "hskst",
        "short": "KZ",
        "tel": "327"
      },
      {
        "en": "Laos",
        "name": "老挝",
        "pinyin": "lw",
        "short": "LA",
        "tel": "856"
      },
      {
        "en": "Lebanon",
        "name": "黎巴嫩",
        "pinyin": "lbn",
        "short": "LB",
        "tel": "961"
      },
      {
        "en": "St.Lucia",
        "name": "圣卢西亚",
        "pinyin": "slxy",
        "short": "LC",
        "tel": "1758"
      },
      {
        "en": "Liechtenstein",
        "name": "列支敦士登",
        "pinyin": "lzdsd",
        "short": "LI",
        "tel": "423"
      },
      {
        "en": "SriLanka",
        "name": "斯里兰卡",
        "pinyin": "sllk",
        "short": "LK",
        "tel": "94"
      },
      {
        "en": "Liberia",
        "name": "利比里亚",
        "pinyin": "lbly",
        "short": "LR",
        "tel": "231"
      },
      {
        "en": "Lesotho",
        "name": "莱索托",
        "pinyin": "lst",
        "short": "LS",
        "tel": "266"
      },
      {
        "en": "Lithuania",
        "name": "立陶宛",
        "pinyin": "ltw",
        "short": "LT",
        "tel": "370"
      },
      {
        "en": "Luxembourg",
        "name": "卢森堡",
        "pinyin": "lsb",
        "short": "LU",
        "tel": "352"
      },
      {
        "en": "Latvia",
        "name": "拉脱维亚",
        "pinyin": "ltwy",
        "short": "LV",
        "tel": "371"
      },
      {
        "en": "Libya",
        "name": "利比亚",
        "pinyin": "lby",
        "short": "LY",
        "tel": "218"
      },
      {
        "en": "Morocco",
        "name": "摩洛哥",
        "pinyin": "mlg",
        "short": "MA",
        "tel": "212"
      },
      {
        "en": "Monaco",
        "name": "摩纳哥",
        "pinyin": "mng",
        "short": "MC",
        "tel": "377"
      },
      {
        "en": "Moldova,Republicof",
        "name": "摩尔多瓦",
        "pinyin": "medw",
        "short": "MD",
        "tel": "373"
      },
      {
        "en": "Madagascar",
        "name": "马达加斯加",
        "pinyin": "mdjsj",
        "short": "MG",
        "tel": "261"
      },
      {
        "en": "Mali",
        "name": "马里",
        "pinyin": "ml",
        "short": "ML",
        "tel": "223"
      },
      {
        "en": "Burma",
        "name": "缅甸",
        "pinyin": "md",
        "short": "MM",
        "tel": "95"
      },
      {
        "en": "Mongolia",
        "name": "蒙古",
        "pinyin": "mg",
        "short": "MN",
        "tel": "976"
      },
      {
        "en": "Macao",
        "name": "澳门（中国）",
        "pinyin": "am zg",
        "short": "MO",
        "tel": "853"
      },
      {
        "en": "MontserratIs",
        "name": "蒙特塞拉特岛",
        "pinyin": "mtsstd",
        "short": "MS",
        "tel": "1664"
      },
      {
        "en": "Malta",
        "name": "马耳他",
        "pinyin": "met",
        "short": "MT",
        "tel": "356"
      },
      {
        "en": "MarianaIs",
        "name": "马里亚那群岛",
        "pinyin": "mlynqd",
        "short": "",
        "tel": "1670"
      },
      {
        "en": "Martinique",
        "name": "马提尼克",
        "pinyin": "mtnk",
        "short": "",
        "tel": "596"
      },
      {
        "en": "Mauritius",
        "name": "毛里求斯",
        "pinyin": "mlqs",
        "short": "MU",
        "tel": "230"
      },
      {
        "en": "Maldives",
        "name": "马尔代夫",
        "pinyin": "medf",
        "short": "MV",
        "tel": "960"
      },
      {
        "en": "Malawi",
        "name": "马拉维",
        "pinyin": "mlw",
        "short": "MW",
        "tel": "265"
      },
      {
        "en": "Mexico",
        "name": "墨西哥",
        "pinyin": "mxg",
        "short": "MX",
        "tel": "52"
      },
      {
        "en": "Malaysia",
        "name": "马来西亚",
        "pinyin": "mlxy",
        "short": "MY",
        "tel": "60"
      },
      {
        "en": "Mozambique",
        "name": "莫桑比克",
        "pinyin": "msbk",
        "short": "MZ",
        "tel": "258"
      },
      {
        "en": "Namibia",
        "name": "纳米比亚",
        "pinyin": "nmby",
        "short": "NA",
        "tel": "264"
      },
      {
        "en": "Niger",
        "name": "尼日尔",
        "pinyin": "nre",
        "short": "NE",
        "tel": "977"
      },
      {
        "en": "Nigeria",
        "name": "尼日利亚",
        "pinyin": "nrly",
        "short": "NG",
        "tel": "234"
      },
      {
        "en": "Nicaragua",
        "name": "尼加拉瓜",
        "pinyin": "njlg",
        "short": "NI",
        "tel": "505"
      },
      {
        "en": "Netherlands",
        "name": "荷兰",
        "pinyin": "hl",
        "short": "NL",
        "tel": "31"
      },
      {
        "en": "Norway",
        "name": "挪威",
        "pinyin": "nw",
        "short": "NO",
        "tel": "47"
      },
      {
        "en": "Nepal",
        "name": "尼泊尔",
        "pinyin": "nbe",
        "short": "NP",
        "tel": "977"
      },
      {
        "en": "NetheriandsAntilles",
        "name": "荷属安的列斯",
        "pinyin": "hsadls",
        "short": "",
        "tel": "599"
      },
      {
        "en": "Nauru",
        "name": "瑙鲁",
        "pinyin": "nl",
        "short": "NR",
        "tel": "674"
      },
      {
        "en": "NewZealand",
        "name": "新西兰",
        "pinyin": "xxl",
        "short": "NZ",
        "tel": "64"
      },
      {
        "en": "Oman",
        "name": "阿曼",
        "pinyin": "am",
        "short": "OM",
        "tel": "968"
      },
      {
        "en": "Panama",
        "name": "巴拿马",
        "pinyin": "bnm",
        "short": "PA",
        "tel": "507"
      },
      {
        "en": "Peru",
        "name": "秘鲁",
        "pinyin": "bl",
        "short": "PE",
        "tel": "51"
      },
      {
        "en": "FrenchPolynesia",
        "name": "法属玻利尼西亚",
        "pinyin": "fsblnxy",
        "short": "PF",
        "tel": "689"
      },
      {
        "en": "PapuaNewCuinea",
        "name": "巴布亚新几内亚",
        "pinyin": "bbyxjny",
        "short": "PG",
        "tel": "675"
      },
      {
        "en": "Philippines",
        "name": "菲律宾",
        "pinyin": "flb",
        "short": "PH",
        "tel": "63"
      },
      {
        "en": "Pakistan",
        "name": "巴基斯坦",
        "pinyin": "bjst",
        "short": "PK",
        "tel": "92"
      },
      {
        "en": "Poland",
        "name": "波兰",
        "pinyin": "bl",
        "short": "PL",
        "tel": "48"
      },
      {
        "en": "PuertoRico",
        "name": "波多黎各",
        "pinyin": "bdlg",
        "short": "PR",
        "tel": "1787"
      },
      {
        "en": "Portugal",
        "name": "葡萄牙",
        "pinyin": "pty",
        "short": "PT",
        "tel": "351"
      },
      {
        "en": "Paraguay",
        "name": "巴拉圭",
        "pinyin": "blg",
        "short": "PY",
        "tel": "595"
      },
      {
        "en": "Qatar",
        "name": "卡塔尔",
        "pinyin": "kte",
        "short": "QA",
        "tel": "974"
      },
      {
        "en": "Reunion",
        "name": "留尼旺",
        "pinyin": "lnw",
        "short": "",
        "tel": "262"
      },
      {
        "en": "Romania",
        "name": "罗马尼亚",
        "pinyin": "lmny",
        "short": "RO",
        "tel": "40"
      },
      {
        "en": "Russia",
        "name": "俄罗斯",
        "pinyin": "els",
        "short": "RU",
        "tel": "7"
      },
      {
        "en": "SaudiArabia",
        "name": "沙特阿拉伯",
        "pinyin": "stalb",
        "short": "SA",
        "tel": "966"
      },
      {
        "en": "SolomonIs",
        "name": "所罗门群岛",
        "pinyin": "slmqd",
        "short": "SB",
        "tel": "677"
      },
      {
        "en": "Seychelles",
        "name": "塞舌尔",
        "pinyin": "sse",
        "short": "SC",
        "tel": "248"
      },
      {
        "en": "Sudan",
        "name": "苏丹",
        "pinyin": "sd",
        "short": "SD",
        "tel": "249"
      },
      {
        "en": "Sweden",
        "name": "瑞典",
        "pinyin": "rd",
        "short": "SE",
        "tel": "46"
      },
      {
        "en": "Singapore",
        "name": "新加坡",
        "pinyin": "xjp",
        "short": "SG",
        "tel": "65"
      },
      {
        "en": "Slovenia",
        "name": "斯洛文尼亚",
        "pinyin": "slwny",
        "short": "SI",
        "tel": "386"
      },
      {
        "en": "Slovakia",
        "name": "斯洛伐克",
        "pinyin": "slfk",
        "short": "SK",
        "tel": "421"
      },
      {
        "en": "SierraLeone",
        "name": "塞拉利昂",
        "pinyin": "slla",
        "short": "SL",
        "tel": "232"
      },
      {
        "en": "SanMarino",
        "name": "圣马力诺",
        "pinyin": "smln",
        "short": "SM",
        "tel": "378"
      },
      {
        "en": "SamoaEastern",
        "name": "东萨摩亚(美)",
        "pinyin": "dsmym",
        "short": "",
        "tel": "684"
      },
      {
        "en": "SanMarino",
        "name": "西萨摩亚",
        "pinyin": "xsmy",
        "short": "",
        "tel": "685"
      },
      {
        "en": "Senegal",
        "name": "塞内加尔",
        "pinyin": "snje",
        "short": "SN",
        "tel": "221"
      },
      {
        "en": "Somali",
        "name": "索马里",
        "pinyin": "sml",
        "short": "SO",
        "tel": "252"
      },
      {
        "en": "Suriname",
        "name": "苏里南",
        "pinyin": "sln",
        "short": "SR",
        "tel": "597"
      },
      {
        "en": "SaoTomeandPrincipe",
        "name": "圣多美和普林西比",
        "pinyin": "sdmhplxb",
        "short": "ST",
        "tel": "239"
      },
      {
        "en": "EISalvador",
        "name": "萨尔瓦多",
        "pinyin": "sewd",
        "short": "SV",
        "tel": "503"
      },
      {
        "en": "Syria",
        "name": "叙利亚",
        "pinyin": "xly",
        "short": "SY",
        "tel": "963"
      },
      {
        "en": "Swaziland",
        "name": "斯威士兰",
        "pinyin": "swsl",
        "short": "SZ",
        "tel": "268"
      },
      {
        "en": "Chad",
        "name": "乍得",
        "pinyin": "zd",
        "short": "TD",
        "tel": "235"
      },
      {
        "en": "Togo",
        "name": "多哥",
        "pinyin": "dg",
        "short": "TG",
        "tel": "228"
      },
      {
        "en": "Thailand",
        "name": "泰国",
        "pinyin": "tg",
        "short": "TH",
        "tel": "66"
      },
      {
        "en": "Tajikstan",
        "name": "塔吉克斯坦",
        "pinyin": "tjkst",
        "short": "TJ",
        "tel": "992"
      },
      {
        "en": "Turkmenistan",
        "name": "土库曼斯坦",
        "pinyin": "tkmst",
        "short": "TM",
        "tel": "993"
      },
      {
        "en": "Tunisia",
        "name": "突尼斯",
        "pinyin": "tns",
        "short": "TN",
        "tel": "216"
      },
      {
        "en": "Tonga",
        "name": "汤加",
        "pinyin": "tj",
        "short": "TO",
        "tel": "676"
      },
      {
        "en": "Turkey",
        "name": "土耳其",
        "pinyin": "teq",
        "short": "TR",
        "tel": "90"
      },
      {
        "en": "TrinidadandTobago",
        "name": "特立尼达和多巴哥",
        "pinyin": "tlndhdbg",
        "short": "TT",
        "tel": "1809"
      },
      {
        "en": "Taiwan",
        "name": "台湾（中国）",
        "pinyin": "twzg",
        "short": "TW",
        "tel": "886"
      },
      {
        "en": "Tanzania",
        "name": "坦桑尼亚",
        "pinyin": "tsny",
        "short": "TZ",
        "tel": "255"
      },
      {
        "en": "Ukraine",
        "name": "乌克兰",
        "pinyin": "wkl",
        "short": "UA",
        "tel": "380"
      },
      {
        "en": "Uganda",
        "name": "乌干达",
        "pinyin": "wgd",
        "short": "UG",
        "tel": "256"
      },
      {
        "en": "UnitedStatesofAmerica",
        "name": "美国",
        "pinyin": "mg",
        "short": "US",
        "tel": "1"
      },
      {
        "en": "Uruguay",
        "name": "乌拉圭",
        "pinyin": "wlg",
        "short": "UY",
        "tel": "598"
      },
      {
        "en": "Uzbekistan",
        "name": "乌兹别克斯坦",
        "pinyin": "wzbkst",
        "short": "UZ",
        "tel": "233"
      },
      {
        "en": "SaintVincent",
        "name": "圣文森特岛",
        "pinyin": "swstd",
        "short": "VC",
        "tel": "1784"
      },
      {
        "en": "Venezuela",
        "name": "委内瑞拉",
        "pinyin": "wnrl",
        "short": "VE",
        "tel": "58"
      },
      {
        "en": "Vietnam",
        "name": "越南",
        "pinyin": "yn",
        "short": "VN",
        "tel": "84"
      },
      {
        "en": "Yemen",
        "name": "也门",
        "pinyin": "ym",
        "short": "YE",
        "tel": "967"
      },
      {
        "en": "Yugoslavia",
        "name": "南斯拉夫",
        "pinyin": "nslf",
        "short": "YU",
        "tel": "381"
      },
      {
        "en": "SouthAfrica",
        "name": "南非",
        "pinyin": "nf",
        "short": "ZA",
        "tel": "27"
      },
      {
        "en": "Zambia",
        "name": "赞比亚",
        "pinyin": "zby",
        "short": "ZM",
        "tel": "260"
      },
      {
        "en": "Zaire",
        "name": "扎伊尔",
        "pinyin": "zye",
        "short": "ZR",
        "tel": "243"
      },
      {
        "en": "Zimbabwe",
        "name": "津巴布韦",
        "pinyin": "jbbw",
        "short": "ZW",
        "tel": "263"
      }
    ]
  }
}

=========

# 评论接口

## 5001-提交评论接口 [POST /v3/comment?c=5001]
```
该接口用于用户评论专辑、音频等内容，在规定时间内多次评论会提示无法评论,以及评论被封禁
该接口调用的前提是用户登录。
接口名：setComment，接口编号：5001
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| type  | <a href="#type">类型定义</a> | 是| string  |
| cid | 对应type的数据ID | 是| string |
| commentText | 评论内容 | 是 | string |
| commentType | 评论类型，1为一级评论，2为二级评论 | 是| string |
| replyId | 回复某条评论时，填写该评论id | 否 | string |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| commentId  | 当前对应的评论ID | 是| string  |
| commentType  | 当前评论类型，1-一级评论，2-二级评论 | 是| string  |

注意：评论后不立刻调用获取评论接口，直接前端处理显示给用户，评论需要审核，用户输入同样评论显示评论失败。

**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "cid": "1",
        "type": "1",
        "commentText": "测试222",
        "commentType": "1",
        "replyId": ""
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "commentId": "xx",
            "commentType": "1"
        }
    }

=========

## 5002-获取级评论接口（包括查看详情接口） [POST /v3/comment?c=5002]
```
该接口用于获取用户评论内容，该接口无需用户登录。
接口名：getComment，接口编号：5002
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| showType | 1表示最新评论，2表示精选评论 | 否，默认为1 | string |
| type  | <a href="#type">类型定义</a> | 否| string  |
| cid | 对应type的数据ID | 否| string |
| commentId | 评论id(查询评论下的二级评论) | 否| string |
| commentType | 评论类型，1为一级评论，2为二级评论 | 否| string |
| offset | 分页的第几页，从1开始包含当前记录 | 否  | string  |
| count | 每次查询个数 | 否 | string |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| commentId | 主键ID,评论id | 是| string |
| commentText  | 评论内容 | 是| string  |
| commentStatus  | 评论状态，1-正常，2-删除，3-未审核通过 | 是| string  |
| commentTime  | 评论时间 | 是| string  |
| commentType | 评论类型，1为一级评论，2为二级评论 | 是| string |
| commentUserid | 评论用户唯一userid | 是| string |
| commentUserType | 评论用户的用户类型，0表示普通用户，1表示主播 | 是| string |
| commentName  | 评论昵称 | 是| string  |
| commentLogoImg  | 评论人的头像，可能头像为空，使用默认头像 | 否| string  |
| commentReplyUserid | 对回复评论用户唯一userid，如果为0或者为空，则表示当前评论者为空 | 是| string |
| commentReplyName  | 对回复评论昵称 | 是| string  |
| commentReplyLogoImg  | 对回复评论人的头像，可能头像为空，使用默认头像 | 否| string  |
| commentReplyUserType | 对回复评论用户的用户类型，0表示普通用户，1表示主播 | 否| string  |
| zanCount  | 点赞数 | 是| int  |
| replyCount  | 回复总数 | 是| int  |
| isZan   | 当前用户是否点赞，0-未点赞，1-点赞 | 是| string  |
| replyComment | 回复当前评论的数据，目前只会显示1条，其中返回字段和前面含义一样 | 是| array |
| detail | 当前音频的信息，字段的具体和4005接口一样，参考4005接口文档 | 是 | object |
| forbidComment | 禁止评论，0表示不禁止，1表示禁止 |

**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "showType": "1",
        "type": "2",
        "cid": "20102001020201",
        "commentId" : "",
        "commentType" : "",
        "offset": "1",
        "count": "10"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1,
            "comment": [
                {
                    "commentId": "5555",
                    "commentText": "1号用户评论内容",
                    "commentStatus": "1",
                    "commentTime": "2019-05-05 11:11:11",
                    "commentType": "1",
                    "commentUserid": "112121", 
                    "commentUserType": "0",
                    "commentName": "jack",
                    "commentLogoImg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                    "commentReplyUserid": "112121", 
                    "commentReplyUserType": "0",
                    "commentReplyName": "jack",
                    "commentReplyLogoImg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                    "zanCount": 122,
                    "replyCount": 5,
                    "isZan": "1",
                    "replyComment": [
                        {
                            "commentId": "5555",
                            "commentText": "1号用户评论内容",
                            "commentStatus": "1",
                            "commentTime": "2019-05-05 11:11:11",
                            "commentType": "1",
                            "commentUserid": "112121", 
                            "commentName": "jack",
                            "commentReplyUserid": "112121", 
                            "commentReplyUserType": "0",
                            "commentReplyName": "jack",
                            "commentReplyLogoImg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D"
                        }
                    ]
                }
            ],
            "detail": {
                "name": "测5555",
                "publishName": "测试5555",
                "subhead": "",
                "summary": "用于测试",
                "kps": "",
                "authorId": "作者ID",
                "authorName": "",
                "anchorType": "0",
                "authorImg": "xxx",
                "createPersonName": "",
                "id": "203481548523520",
                "type": "5",
                "img": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                "bigImg": "http://test-tdbucketimg.oss-cn-shanghai.aliyuncs.com/1548387392734088800_2855747148235050480.jpg?Expires=1550853124&OSSAccessKeyId=LTAIUa60fyy014rC&Signature=fhVexo1Jv6cWcK9Hjz5FOxnBibE%3D",
                "duration": 11,
                "playCount": 111,
                "playUrl": "http://tdbucketdefault.oss-cn-shanghai.aliyuncs.com/himango/res/Jessie%20J%E8%AE%A9%E3%80%8A%E6%AD%8C%E6%89%8B%E3%80%8B%E7%BF%BB%E5%BC%80%E6%96%B0%E7%9A%84%E7%AF%87%E7%AB%A0.mp3",
                "jumpUrl": "",
                "jumpType": "",
                "issueDate": "1970-01-01",
                "labels": "新闻资讯",
                "commentCount": 10,
                "forbidComment": "0"
            }
        }
    }

=========

## 5003-举报接口 [POST /v3/comment?c=5003]
```
该接口用于用户举报评论，该接口调用的前提是用户登录。
接口名：reportComment，接口编号：5003
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| commentId | 主键ID,评论id | 是| string |
| commentUserid | 评论用户唯一userid | 是| string |
| commentText  | 评论内容 | 是| string  |
| reportType | 举报类型，1.广告，2.色情，3.虚假消息，4.骚扰谩骂，5.恶意灌水，6.其他，可以多选，为一个数组数据 | 是 | array |
| reportText | 举报描述 | 否 | string |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| commentId | 主键ID,评论id | 是| string |
| commentText  | 评论内容 | 是| string  |
| commentStatus  | 评论状态，1-正常，2-删除，3-未审核通过 | 是| string  |
| commentTime  | 评论时间 | 是| string  |
| commentType | 评论类型，1为一级评论，2为二级评论 | 是| string |
| commentUserid | 评论用户唯一userid | 是| string |
| commentUserType | 评论用户的用户类型，0表示普通用户，1表示主播 | 是| string |
| commentName  | 评论昵称 | 是| string  |
| commentLogoImg  | 评论人的头像，可能头像为空，使用默认头像 | 否| string  |
| commentReplyUserid | 对回复评论用户唯一userid，如果为0或者为空，则表示当前评论者为空 | 是| string |
| commentReplyName  | 对回复评论昵称 | 是| string  |
| commentReplyLogoImg  | 对回复评论人的头像，可能头像为空，使用默认头像 | 否| string  |
| commentReplyUserType | 对回复评论用户的用户类型，0表示普通用户，1表示主播 | 否| string  |
| zanCount  | 点赞数 | 是| int  |
| replyCount  | 回复总数 | 是| int  |
| isZan   | 当前用户是否点赞，0-未点赞，1-点赞 | 是| string  |
| replyComment | 回复当前评论的数据，目前只会显示1条，其中返回字段和前面含义一样 | 是| array |
| detail | 当前音频的信息，字段的具体和4005接口一样，参考4005接口文档 | 是 | object |
| forbidComment | 禁止评论，0表示不禁止，1表示禁止 |

**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "commentId": "346686247084777472",
        "commentText": "你*****",
        "commentUserid": "134543",
        "reportType": ["1","2"],
        "reportComment": "人身攻击省"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {}
    }
    
=========

## 5004-点赞或取消点赞接口 [POST /v3/comment?c=5004]
```
该接口用于用户点赞评论，该接口调用的前提是用户登录。
接口名：setCommentZan，接口编号：5004
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| commentId | 主键ID，评论id | 是| string |
| commentType | 评论类型，1-一级评论，2-二级评论 | 是 | string |
| status | 是否点赞：<br>1-点赞；<br>2-取消点赞；| 是| string   |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| status | 0成功，1参数错误，2失败 | 是| string |

**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "commentType": "2",
        "commentId": "20102001020201"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "1000001", 
        "desc": "用户未登录",
        "biz": {}
    }

=========

## 5005-删除评论接口 [POST /v3/comment?c=5005]
```
该接口用于用户删除评论，该接口调用的前提是用户登录。
接口名：delComment，接口编号：5005
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| commentType | 评论类型，1为一级评论，2为二级评论 | 是| string |
| commentId | 评论id(查询评论下的二级评论)删除只需要填写commentId和commentType | 是| string |

**请求**
```
{
    "base" : {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "commentType": "2",
        "commentId": "20102001020201"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "1000001", 
        "desc": "用户未登录",
        "biz": {}
    }

=========




# 其他服务接口

## 8001-查询日志上报配置接口 [POST /v3/ext?c=8001]
```
该接口用于查询日志上报的周期。
接口名：LogStrategy，接口编号：8001
```
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|count | 上报的条数| int|
|content |上报周期，单位为秒| int|

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 20,
            "interval": 960
        }
    }

=========

## 8002-日志上报接口 [POST /v3/ext?c=8002]
```
该接口用于日志打点。
接口名：LogUpload，接口编号：8002
```
**请求参数**
| **字段名** | **说明**    | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| content | 上报的数组列表 | 是 | array |
| type | 上报的类型 | 是 | string |
| subType | 上报的子类型 | 是 | string |
| extData | 上报的数组，格式为key=value | 是 | array |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|status | 上报状态，1表示成功，其他表示失败 | int|

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "content":[
            {
                "type":"TEST",
                "subType":"TEST_SUB",
                "extData":[
                    "errmsg=no devices",
                    "errcode=4001"
                ]
            }
        ]
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 1
        }
    }

=========

## 8004-上传文件接口 [POST /v5/ext?c=8004]
```
该接口用于上传文件，注意，需要登录，需要用表单模式进行提示文件。
接口名：fileUpload，接口编号：8004
```
**请求参数**
| **字段名** | **说明**    | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| fileKey | 上传的文件的key | 是 | string |
| name | 文件名 | 否 | string |
| private | 是否加密，为1确定为加密，其他不加密 | 否 | string |
| * | fileKey作为key的文件 | 是| 文件类型|
|userId|用户id| 是| string|
|sid| 登录sid| 是| string|
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|path | 文件保存路径 | string|
|url| 访问路径 | string|

**请求**
```
请用表单方式提交
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "path": "tmp/dasdasd/dasdas.png",
            "url":"http://s7.tingdao.com//tmp/mgtj_dirs/1585299399217602600_4ca32329-f6c6-4bc1-9144-88290b8c8a51.png?e=1585342599&token=XvZht8mbK1lYkl27XjTG1JlgfdQFjmjaes05o4TH:aaricM0MxGBrLWCod0i-T32kGYI="
        }
    }

=========

## 6001-升级接口  [POST /v3/ext?c=6001]
```
该接口用于app升级。
接口名：VersionApp，接口编号：6001
```
**请求参数**
| **字段名**      | **说明**    | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| platform | 平台 | 是 | string |
| version | 版本信息 | 是 | string |
| channelId | 渠道号 | 是 | string |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|update | 更新版本标识，1.h5更新，2.h5跳转强制更新，3.应用内更新，4.应用内强制更新 | int|
|latestversionurl | 更新的url | string |
|latestversion | 更新的版本号 | string |
|latestversioninfo | 更新的版本信息 | string |
|md5 | apk的md5值 | string |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "platform": "android",
        "version": "3.0",
        "channelId": "1001"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "update": 1,
            "latestversionurl": "http://www.baidu.com/",
            "latestversion": "3.1",
            "latestversioninfo": "xxxx",
            "md5": "xxx"
        }
    }

=========

## 7001-获取H5Sid接口 [POST /v3/ext?c=7001]
```
该接口提供给H5使用。
接口名：GetH5Sid，接口编号：7001
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| h5Appid | 平台 | 是，固定为mgtj2019 | string |
| timestamp | 当前时间戳 | 是 | string |
| random | 随机数 | 是 | string |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| h5Sid | 获取用户信息的sid | 是 | string |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "h5Appid": "mgtj2019",
        "timestamp": 1,
        "random": 5
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "h5Sid": "xxx"
        }
    }

=========




# 第三方接口

## 9002-第三方请求代理接口（c位挑战赛） [POST /v3/ext?c=9002]
```
接口名：BossProxy，接口编号：9002
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| uri | 请求的url | 是| string   |
| body | 请求的body，可以填写json | 是| object   |
| query | 请求查询的参数 | 是| object   |
| method | 请求方法，GET或者POST | 是| string   |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|retcode | 对应的错误码 | int64 |
|desc | 返回码对应的值 | int |
|biz | 返回的结构信息 | object |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "uri": "http://sw.tthud.cn/api/activity/ranking",
        "body": {
            "context": "我也是醉了"
        },
        "query": {
            "act_id": "1",
            "mobile": "18207137391",
            "group_id": "1",
            "rows": "100",
            "page": "1"
        },
        "method": "GET"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "code": 1,
            "data": {
                "act_id": "1",
                "banners": [
                    {
                        "image": "https://qiniu.hnltou.com/sw_img/20180811/d6001e8d605f218d117b0f306be1122d.jpg",
                        "sort": "0",
                        "url": "#"
                    }
                ],
                "end_time": "1325260800",
                "group_id": "1",
                "groups": [],
                "left_free_times": 5,
                "max_count": "5",
                "players": [],
                "startTime": "1543593600"
            },
            "msg": "查询成功",
            "time": "1559703383"
        }
    }

=========

## 9003-第三方请求打CALL接口（c位挑战赛） [POST /v3/ext?c=9003]
```
接口名：BossCallProxy，接口编号：9003
```
**请求参数**
| **字段名** | **说明**    | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| uri | 请求的url | 是| string   |
| body | 请求的body，可以填写json | 是| object   |
| query | 请求查询的参数 | 是| object   |
| method | 请求方法，GET或者POST | 是| string   |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
|retcode | 对应的错误码 | int64 |
|desc | 返回码对应的值 | int |
|biz | 返回的结构信息 | object |

**请求**
```
{
    "base" : {
        "userid" : "1810232029531260",
        "caller" : "18514281314",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "7316877616488209201"
    },
    "param": {
        "uri": "https://testsw.tthud.cn/api/activity/prise",
        "body": {
        },
        "query": {
            "act_id": "45",
            "ub_id": "450530fb2b3f2bdb4e5d",
            "mobile": "18201872833",
            "group_id": "16",
            "mobile": "17724490919",
            "nickname": "aa",
            "headimgurl": "xxx"
        },
        "method": "GET"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "code": 1,
            "msg": "打call成功",
            "time": "1559295074",
            "data": {
                "eject": 0,
                "total": 29,
                "nickname": "aaa",
                "ub_id": "69277e7aff9e1071add2",
                "left_free_times": 3
            }
        }
    }

=========



# 支付接口

## 4101-生成订单接口 [POST /v3/pay?c=4101]
```
接口名：GetPayOrder，接口编号：4101
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| goodsId | 商品ID（没有商品ID，默认传0） | 是| string |
| payType | 付款类型 1.微信，2.支付宝，3.ios，4.果冻（非必填参数） | 否 | string |
| totalFee | 标价金额（对账，防止商品价格临时变动） | 是| string |
| timeStart | 交易起始时间 | 是 | string |
| goodsTag | 订单优惠标记 | 否 | string |
| realFee  | 订单总金额，单位为果冻，保留后两位小数 | 是| float  |
| signType | 签名类型（第一个版本都传1，类型aes-128-ECB-PKCS5Padding） | 是 | string |
| random | 随机字符串或者随机数 | 是 | string | 
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| outTradeNo  | 订单号,系统内部订单号，要求32个字符内，只能是数字、大小写字母 | 是| string  |
| subject | 商品的标题/交易标题/订单标题/订单关键字 | 是 | string |
| payToken | 支付的payToken，用于订单的校验 | 是 | string | 

```
注意：根据系统类型判断，并记录，ios退款无法直接在后台处理
注意：微信先调用接口在微信支付服务后台生成预支付交易单，
返回正确的预支付交易会话标识后再按Native、JSAPI、APP等不同场景生成交易串调起支付
```

**请求**
```
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52"
    },
    "param": {
        "signType": "1",
        "payBody": [
            {
                "goodsId": "1",
                "totalFee": "1",
                "realFee": "1",
                "timeStart": "",
                "random": "xxx"
            }
        ]
    }
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "subject": "测试-2117605368537088",
    "outTradeNo": "361273499970670592",
    "payToken": "361273500171997184-17794eb9-5ee8-4bb8-8a18-071fc5991784"
  }
}

=========

## 4102-查询支付状态接口 [POST /v3/pay?c=4102]
```
接口名：GetPayOrderStatus，接口编号：4102
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| payType | 付款类型1.微信，2.支付宝，3.ios，4.果冻 | 是 | string |
| signType | 签名类型（第一个版本都传1，类型aes-128-ECB-PKCS5Padding）| 是 | string |
| outTradeNo  | 订单号,系统内部订单号，要求32个字符内，只能是数字、大小写字母_- | 是| string  |
| platformContent  | 平台调起支付需要的参数（平台的object原样返回） | 是| object  |
| payToken  | 支付的听见后台的token | 是| string  |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| status  | 业务结果，0-待支付，1-成功，2-失败，3-过期，4-支付待确认 | 是| string  |
| msg  | 当前评论类型，错误原因，签名失败等 | 是| string  |

```
注意：根据系统类型判断，并记录，ios退款无法直接在后台处理
注意：无返回发起三次重试
```

**请求**
```
{
    "base": {
        "userid" : "326028317323026432",
        "caller" : "18514281314",
        "imei" : "a2c658275cf708690c350ec01b3f6e863db6627a112",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios", 
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "ead46602-77d7-45c2-a8b9-8b8adc5dad56"
    },
    "param": {
        "signType": "1",
        "outTradeNo": "1",
        "payToken": "2117605368537088",
        "payType": "1", 
        "transactionId": "2117605368537088"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": "1",
            "msg": "购买成功"
        }
    }

=========

## 4103-查询支持的购买类型 [POST /v3/pay?c=4103]
```
通过cid和type查询商品支持的购买类型
该接口调用的前提是用户登录。
接口名：PurchaseType，接口编号：4103
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| type  | <a href="#type">类型定义</a> | 是| string  |
| cid | 对应type的数据ID | 是| string |
| audioBeginId | 购买的开始位置 | 是| string |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| payType | 付款类型1.微信，2.支付宝，3.ios，4.果冻 | 是 | string |
| title  | 获取的支持的交易类型标题 | 是| string  |
| purchaseType  | 购买类型 1：单集购买，2：整本购买，3：后10集，4：后50集，5：自定义购买，6：已更新和待更新章节（其他字段继续扩展） | 是 | string  |
| goodsId  | 购买orderId，根据购买类型生成的购买id，避免非自定义情况频繁传cidLits | 是| string  |
| realFee  | 订单总金额，单位为果冻，保留后两位小数 | 是| float  |
| totalFee  | 显示支付的金额，可能和realPayVal不一样，保留后两位小数 | 是| float  |
| payDescription | 显示购买的描述 | 是 | string |
| paySmallText | 显示购买的文案列表 | 是 | array |
| supportList | 支持购买的list | 是 | array |
| surplusCount | 剩余集数，用户点击位置 | 是 | int |
| oneGuoDongPoint | 1果冻赠送积分数,为0代表不赠送 | 是 | int |
| payPointText | 消耗果冻得积分文案 | 是 | string |

```
注意：购买当前专辑所有音频和整本购买是有区别的，购买整本享受后续更新专辑，购买当前所有不享受更新专辑
```

**请求**
```
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52"
    },
    "param": {
        "cid": "11321321",
        "type": "1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "supportList":[
                {
                    "title":"本集",
                    "goodsId":"1213213",
                    "payType": "4",
                    "realFee":0.20,
                    "totalFee":0.30,
                    "purchaseType":"1",
                    "payDescription": "xxx集-xxx集"
                },
                {
                    "title":"整本",
                    "goodsId":"1213213",
                    "payType": "4",
                    "realFee":0.20,
                    "totalFee":0.30,
                    "purchaseType":"2",
                    "payDescription": "xxx集-xxx集"
                },
                {
                    "title":"自定义",
                    "goodsId":"1213213",
                    "payType": "4",
                    "realFee":0.20,
                    "totalFee":0.30,
                    "purchaseType":"5",
                    "payDescription": "xxx集-xxx集"
                },
                {
                    "title":"后5集",
                    "goodsId":"1213213",
                    "payType": "4",
                    "realFee":0.20,
                    "totalFee":0.30,
                    "purchaseType":"4",
                    "payDescription": "xxx集-xxx集"
                }
            ],
            "paySmallText":[
                "1、xxxx",
                "2、xxxx"
            ],
            "surplusCount":12,
            "oneGuoDongPoint":100,
            "payPointText":"购买专辑得积分，消耗1果冻币得100积分"
        }
    }

=========

## 4104-查询现金订单列表 [POST /v3/pay?c=4104]
```
接口名：GetCashOrderList，接口编号：4104
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| offset | 分页的第几页，type=1时可以为空，从1开始包含当前记录 | 否  | string  |
| count | 每次查询个数，分页查询时生效 | 否 | string |string  |
| signType | 签名类型（第一个版本都传1，类型aes-128-ECB-PKCS5Padding） | 是 | string |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| themeName  | 专辑名 | 是| string  |
| orderId  | 订单ID | 是| string  |
| payType  | 支付类型，1.微信，2.支付宝，3.ios，4.果冻支付 | 是| string  |
| goodsName  | 支付的名称，例如：整本 | 是| string  |
| createTime  | 订单的创建时间 | 是| string  |
| status  | 订单状态，0-待支付，1-成功，2-失败，3-过期，4-支付待确认，5-退款 | 是| int  |
| content | 支付订单的列表 | 是 | array |
| count | 支付订单的总数 | 是 | int |
| totalFee | 支付的金额 | 是 | float | 
| expireDate | 有效时间 | 是 | string | 

**请求**
```
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52"
    },
    "param": {
        "count": "10",
        "offset": "1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1,
            "content": [
                {
                    "themeName": "未知",
                    "orderId": "120",
                    "goodsName": "全集",
                    "createTime": "2019-06-30 11:11:11",
                    "status": 1,
                    "payType": "1",
                    "totalFee": -30
                }
            ]
        }
    }

=========

## 4105-查询果冻订单列表 [POST /v3/pay?c=4105]
```
接口名：GetGuodongOrderList，接口编号：4105
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| offset | 分页的第几页，type=1时可以为空，从1开始包含当前记录 | 否  | string  |
| count | 每次查询个数，分页查询时生效 | 否 | string |string  |
| signType | 签名类型（第一个版本都传1，类型aes-128-ECB-PKCS5Padding） | 是 | string |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| themeName  | 专辑名 | 是| string  |
| orderId  | 订单ID | 是| string  |
| payType  | 支付类型，1.微信，2.支付宝，3.ios，4.果冻支付,6.赠币支付,9.已过期订单 | 是| string  |
| goodsName  | 商品名，表示整本还是多少集 | 是| string  |
| createTime  | 订单的创建时间 | 是| string  |
| status  | 订单状态，0-待支付，1-成功，2-失败，3-过期，4-支付待确认，5-退款 | 是| int  |
| content | 支付订单的列表 | 是 | array |
| count | 支付订单的总数 | 是 | int |
| totalFee | 支付的金额 | 是 | float | 
| expireDate | 有效时间 | 是 | string | 
| freeFee | 赠送果冻 | 是 | float | 
| chargeFee | 充值果冻 | 是 | float | 
| source | 来源 | 是 | string | 

**请求**
```
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52"
    },
    "param": {
        "count": "10",
        "offset": "1"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "count": 1,
            "content": [
                {
                    "themeName": "未知",
                    "orderId": "120",
                    "goodsName": "全集",
                    "createTime": "2019-06-30 11:11:11",
                    "status": 1,
                    "payType": "1",
                    "totalFee": -30,
                    "freeFee": -15,
                    "chargeFee": -15,
                    "expireDate": "2019-12-12 12:12:12"
                }
            ]
        }
    }

=========

## 4106-果冻充值类型列表 [POST /v3/pay?c=4106]
```
接口名：GetPayMuchList，接口编号：4106
```
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| realFee | 真实金额 | 是| float  |
| guodongFee  | 果冻数目 | 是| float  |
| goodsId  | 购买的ID | 是| string  |
| status  | 状态，是否能购买，1-能购买，2-不能购买 | 是| int  |
| content | 支付订单的列表 | 是 | array |

**请求**
```
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "content": [
                {
                    "realFee": 10.11,
                    "guodongFee": 20.5,
                    "goodsId": "10001",
                    "status": 1
                },
                {
                    "realFee": 10.11,
                    "guodongFee": 20.5,
                    "goodsId": "10002",
                    "status": 1
                }
            ]
        }
    }

=========

## 4107-果冻支付接口 [POST /v3/pay?c=4107]
```
接口名：GuodongPayMoney，接口编号：4107
```
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| payBody | 发起订单流程以后，服务端给的支付的信息 | 是| string  |
| signType | 签名类型（第一个版本都传1，类型aes-128-ECB-PKCS5Padding） | 是 | string |
| outTradeNo | 订单号的信息 | 是 | string |

**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| status  | 状态，1-支付成功，2-支付失败，3-支付余额不足 | 是| int  |
| message | 支付返回的message信息，原样显示在客户端 | 是 | string |

**请求**
```
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52"
    },
    "param": {
        "payBody": "xaxxxsaaa-4b08-8b3e-50111c498d52ada=13133xadfjfakjf;dk;dahfka''xa",
        "outTradeNo": "xxx"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "status": 0,
            "message": "支付成功"
        }
    }

=========

## 4108-通过自定义的集数查询购买的商品ID [POST /v3/pay?c=4108]
```
接口名：GetPayGoodsId，接口编号：4103
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| type  | <a href="#type">类型定义</a> | 是| string  |
| cid | 对应type的数据ID | 是| string |
| audioCount | 购买的集数 | 是 | string |
| audioBeginId | 购买的开始位置 | 是 | string |
| signType | 签名类型（第一个版本都传1，类型aes-128-ECB-PKCS5Padding） | 是 | string |
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| payType | 付款类型：1.微信，2.支付宝，3.ios，4.果冻 | 是 | string |
| title  | 获取的支持的交易类型标题 | 是| string  |
| purchaseType  | 购买类型 1：单集购买，2：整本购买，3：系统设定购买模式，4：其他支付方式，5：自定义购买 | 是 | string  |
| goodsId  | 购买orderId，根据购买类型生成的购买id，避免非自定义情况频繁传cidLits | 是| string  |
| realFee  | 订单总金额，单位为果冻，保留后两位小数 | 是| float  |
| totalFee  | 显示支付的金额，可能和realPayVal不一样，保留后两位小数 | 是| float  |
| payDescription | 显示购买的描述 | 是 | string |

```
注意：购买当前专辑所有音频和整本购买是有区别的，购买整本享受后续更新专辑，购买当前所有不享受更新专辑
```

**请求**
```
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52"
    },
    "param": {
        "cid": "11321321",
        "type": "1",
        "audioCount": "10",
        "audioBeginId": "xxx"
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "title":"后5集",
            "goodsId":"1213213",
            "payType": "4",
            "realFee":0.20,
            "totalFee":0.30,
            "purchaseType":"2",
            "payDescription": "xxx集-xxx集"
        }
    }

=========

## 4109-通过订单获取支付所需的平台数据（发起支付前） [POST /v3/pay?c=4109]
```
接口名：GetPayPlatformData，接口编号：4109
```
**请求参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| payType | 付款类型：1.微信，2.支付宝，3.ios，4.果冻 | 是 | string |
| signType | 签名类型（第一个版本都传1，类型aes-128-ECB-PKCS5Padding） | 是 | string |
| outTradeNo  | 订单号，系统内部订单号，要求32个字符内，只能是数字、大小写字母_- | 是| string  |
| payToken  | 支付的听见后台的token | 是| string  |
**返回参数**
| **字段名** | **说明**  | **数据类型** |
| :-: | :-: | :-: |
| platformContent | 平台发起预订单的数据的内容，各个平台数据可能不一样 | 是 | object |

```
注意：根据系统类型判断，并记录，ios退款无法直接在后台处理
注意：微信先调用接口在微信支付服务后台生成预支付交易单，
返回正确的预支付交易会话标识后再按Native、JSAPI、APP等不同场景生成交易串调起支付
```

**微信请求**
```
{
    "base": {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "a2c658275cf708690c350ec01b3f6e863db6627a112",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios", 
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "SignType": "2117605368537088",
        "payBody":{
           "outTradeNo": "361521919465590784",
           "payToken": "1",
           "payType": "1"
        }
    }
}
```

**支付宝请求**
```
{
    "base": {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "a2c658275cf708690c350ec01b3f6e863db6627a112",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios", 
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "SignType": "2117605368537088",
        "payBody":{
           "outTradeNo": "361521919465590784",
           "payToken": "1",
           "payType": "2"
        }
    }
}
```

**果冻支付请求**
```
{
    "base": {
        "userid" : "1810232036463280",
        "caller" : "18514281314",
        "imei" : "a2c658275cf708690c350ec01b3f6e863db6627a112",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios", 
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "d8044ea4-e822-420a-ad71-63f15cfff4bd"
    },
    "param": {
        "SignType": "2117605368537088",
        "payBody":{
           "outTradeNo": "361521919465590784",
           "payToken": "1",
           "payType": "4"
        }
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "code": "",
            "msg": "",
            "platformContent": {
                "AppId": "wxfe2fa2f264353d7d3",
                "partnerId": "1494934532",
                "notifyUrl": "",
                "prepayId": "wx201802011023453926020588351720",
                "tradeType": "APP",
                "sign": "6F0B8C565AB6277E9EF9D3BB0D0240E5",
                "nonceStr": "daotXwHBdmgZfeR8YF9i8TXc9Wj4tTjn"
            },
            "bizContent": {
                "subject": "",
                "outTradeNo": "",
                "totalFee": ""
            }
        }
    }

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "code": "",
            "msg": "",
            "platformContent": {
                "tradeType": "APP",
                "orderInfo": "app_id=2015052600090779&biz_content=%7B%22timeout_express%22%3A%2230m%22%2C%22seller_id%22%3A%22%22%2C%22product_code%22%3A%22QUICK_MSECURITY_PAY%22%2C%22total_amount%22%3A%220.02%22%2C%22subject%22%3A%221%22%2C%22body%22%3A%22%E6%88%91%E6%98%AF%E6%B5%8B%E8%AF%95%E6%95%B0%E6%8D%AE%22%2C%22out_trade_no%22%3A%22314VYGIAGG7ZOYY%22%7D&charset=utf-8&method=alipay.trade.app.pay&sign_type=RSA2&timestamp=2016-08-15%2012%3A12%3A15&version=1.0&sign=MsbylYkCzlfYLy9PeRwUUIg9nZPeN9SfXPNavUCroGKR5Kqvx0nEnd3eRmKxJuthNUx4ERCXe552EV9PfwexqW%2B1wbKOdYtDIb4%2B7PL3Pc94RZL0zKaWcaY3tSL89%2FuAVUsQuFqEJdhIukuKygrXucvejOUgTCfoUdwTi7z%2BZzQ%3D"
            },
            "bizContent": {
                "subject": "",
                "outTradeNo": "",
                "totalFee": ""
            }
        }
    }

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "果冻支付返回操作成功",
        "biz": {
            "code": "1",
            "msg": "",
            "platformContent": {
                "payBody": "xxxxx",
            },
            "bizContent": {
                "subject": "电子书xxx购买",
                "outTradeNo": "20190806125346",
                "totalFee": "1"
            }
        }
    }

=========

## 4110-福利抽奖列表接口 [POST /v3/pay?c=4110]
```
接口名：GetLuckList，接口编号：4110
```
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| title | 奖品的主题 | 是| string  |
| fromText  | 来源 | 是| string  |
| description  | 描述信息，包括过期时间等 | 是| string  |
| status  | 状态，是否已经领取，1-未领取，2-已经领取，3-过期 | 是| int  |

**请求**
```
{
    "base" : {
        "userid" : "326028317323026432",
        "caller" : "18627556209",
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4",
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334",
        "version" : "2.1",
        "osid" : "ios",
        "apn" : "wifi",
        "df" : "22010000",
        "sid" : "99a3ac00-caaa-4b08-8b3e-50111c498d52"
    },
    "param": {
    }
}
```

+ Response 200 (application/json)
    {
        "retcode": "000000",
        "desc": "操作成功",
        "biz": {
            "content": [
                {
                    "title": "宝马一台",
                    "fromText": "xxx公司",
                    "description": "过期时间xxx",
                    "status": 1
                },
                {
                    "title": "宝马一台",
                    "fromText": "xxx公司",
                    "description": "过期时间xxx",
                    "status": 2
                }
            ]
        }
    }

=========

## 4142-发送红包接口 [POST /v4/pay?c=4142]
```
接口名：GetRedPacketsData，接口编号：4142
```
**返回参数**
| **字段名** | **说明** | **是否必填** | **数据类型** |
| :-: | :-: | :-: | :-: |
| userid | 用户userId，可不传，只用来记录 | 否| string  |
| reOpenid  | 接受红包的用户openid  | 是| string  |
| total_amount  | 付款金额，单位分 | 是| string  |
| wishing  | 红包祝福语 | 是| string  |
| actName  | 活动名称 | 是| string  |
| remark  | 备注 （猜越多得越多，快来抢！）| 是| string  |
| sceneId  | 发放红包使用场景，红包金额大于200或者小于1元时必传 | 是| string  |
| outTradeNo  | 商户订单号，接口根据商户订单号支持重入，如出现超时可再调用。每笔中奖唯一 | 是| string  |
| sendName  | 红包发送者名称 | 是| string  |
| status  | 1:成功，2：失败 | 是| string  |
```
当状态为FAIL时，存在业务结果未明确的情况。所以如果状态是FAIL，请务必再请求一次查询接口
sceneId参数：
PRODUCT_1:商品促销
PRODUCT_2:抽奖
PRODUCT_3:虚拟物品兑奖 
PRODUCT_4:企业内部福利
PRODUCT_5:渠道分润
PRODUCT_6:保险回馈
PRODUCT_7:彩票派奖
PRODUCT_8:税务刮奖
```

**请求**
```
{ 
    "base":{ 
        "userid" : "1810232029531260", 
        "caller" : "18514281314", 
        "imei" : "db658275cf708690c350ec01b3f6e863db6627a4", 
        "ua" : "apple|iPhone|iPhone9,1|12.0.1|750*1334", 
        "version" : "2.1", 
        "osid" : "ios", 
        "apn" : "wifi", 
        "df" : "22010000", 
        "sid" : "7316877616488209201" 
    }, 
    "param":{ 
        "userid": "190145212352512",
        "reOpenid": "oiFlq6BcI2M5711oE1qmZ9_xzh2A",
        "totalAmount": "30", 
        "wishing": "1", 
        "actName": "2", 
        "remark": "3", 
        "sceneId": "PRODUCT_2", 
        "outTradeNo": "1000009820141111123456789011", 
        "sendName": "芒果动听" 
    } 
}
```

+ Response 200 (application/json)
{
  "retcode": "000000",
  "desc": "操作成功",
  "biz": {
    "status": "1",
    "text": ""
  }
}

=========
