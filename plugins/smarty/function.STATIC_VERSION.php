<?php
/**
 * 静态资源版本号
 * @param $params
 * @param $smarty
 * @return mixed
 */
function smarty_function_STATIC_VERSION($params, &$smarty)
{
    return Yii::$app->params['static_version'];
}
