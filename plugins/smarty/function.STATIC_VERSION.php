<?php

function smarty_function_STATIC_VERSION($params, &$smarty)
{

    return Yii::$app->params['static_version'];
    
}
