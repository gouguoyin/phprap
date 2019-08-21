<?php
namespace app\models;

class Field extends Api
{
    /**
     * 字段类型标签
     * @var array
     */
    public $fieldTypeLabels = [
        'string' => '字符串',
        'integer' => '整数',
        'float'   => '小数',
        'boolean' => '布尔',
        'object'  => '对象',
        'array'   => '数组',
    ];

    /**
     * 是否必须标签
     * @var array
     */
    public $requiredLabels = [
        '10' => '是',
        '20' => '否',
    ];

    /**
     * 默认header参数
     * @var array
     */
    public $defaultHeaderParams = [
        'Accept','Accept-Charset','Accept-Encoding','Accept-Language','Accept-Datetime','Accept-Ranges','Authorization',
        'Cache-Control','Connection','Cookie','Content-Disposition','Content-Length','Content-Type','Content-MD5',
        'Referer',
        'User-Agent',
        'X-Requested-With','X-Forwarded-For','X-Forwarded-Host','X-Csrf-Token'
    ];

    /**
     * 获取字段更新内容
     * @return string
     */
    public function getUpdateContent()
    {
        $content = '';
        foreach ($this->dirtyAttributes as $name => $value) {

            if(isset($this->attributes[$name])){
                $content = '更新了 <strong>' .$this->module->title . '->' . $this->title . '->接口字段->' . $this->getAttributeLabel($name). '</strong>';
            }

        }

        return trim($content, ',');
    }
    
    /**
     * 判断字段是否是复合类型
     * @param $field
     * @return bool
     */
    public function isCompositeType($type)
    {
        return in_array($type, ['array', 'object']) ? true : false;
    }

}
