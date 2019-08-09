<?php
/**
 * 生成url
 * string $route 路由
 * array $param 参数
 * boolean $scheme 是否展示完整url
 */
if (!function_exists('url')){
    function url($route = '', $param = [], $scheme = false)
    {
        if(!$route){
            return \yii\helpers\Url::current($param, $scheme);
        }
        $param[] = $route;
        return  \yii\helpers\Url::toRoute($param, $scheme);
    }
}

/**
 * 友好的打印调试
 */
if (!function_exists('dump'))
{
    function dump()
    {
        if(func_num_args() < 1){
            var_dump(null);
        }
        //获取参数列表
        $args_list = func_get_args();
        echo '<pre>';
        foreach ($args_list as $arg) {
            $type = gettype($arg);
            if(!$arg){
                var_dump($arg);
            }elseif($type == 'array'){
                print_r($arg);
            }elseif(in_array($type, ['object', 'resource', 'boolean', 'NULL', 'unknown type'])){
                var_dump($arg);
            }else{
                echo $arg . '<br>';
            }
        }
        echo "</pre>";
    }

}

/**
 * 获取系统配置信息
 */
if (!function_exists('config')){
    function config($name, $type='app')
    {
        $name = trim($name);
        if(strpos($name, '.') !== false){
            list($type, $field) = explode('.', $name);
        }else{
            $field = $name;
        }

        return \app\models\Config::findModel(['type' => $type])->$field;
    }
}

/**
 * 生成CSRF口令
 */
if (!function_exists('csrf_token')){
    function csrf_token()
    {
        return Yii::$app->request->csrfToken;
    }
}

/**
 * 数组转对象
 */
if (!function_exists('array2object')){
    function array2object($array) {
        if(!is_array($array)){
            return null;
        }
        return json_decode(json_encode($array, JSON_UNESCAPED_UNICODE));
    }
}






