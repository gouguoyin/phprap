<?php
/**
 * 静态资源WEB地址
 * @param $params
 * @param $smarty
 * @return string
 */
function smarty_function_STATIC_URL($params, &$smarty)
{
    return Yii::getAlias("@web") . '/static';
}
