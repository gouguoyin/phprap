<?php

function smarty_function_STATIC_URL($params, &$smarty)
{

    return Yii::getAlias("@web") . '/static';
    
}
