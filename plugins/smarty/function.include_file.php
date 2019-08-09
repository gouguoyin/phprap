<?php
/**
 * 引入文件
 * @param $params
 * @param $smarty
 * @return mixed
 */
function smarty_function_include_file($params, &$smarty)
{

    // 获取默认视图文件后缀
    $suffix = 'html';

    $file   =  '@app/views/'. $params['name'] . '.' . $suffix;

    $smarty->assign($params);

    return $smarty->fetch($file);

}
