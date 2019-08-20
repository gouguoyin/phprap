<?php
/**
 * 静态系统版本号
 * @param $params
 * @param $smarty
 * @return mixed
 */
function smarty_function_APP_VERSION($params, &$smarty)
{
    return Yii::$app->params['app_version'];
}
