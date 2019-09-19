<?php
namespace app\models;

use Yii;

class Tongji
{
    /**
     * 获取全部会员
     * @return Account|null
     */
    public function getTotalAccount($status = null, $type = null)
    {
        return Account::findModel()->search(['status' => $status, 'type' => $type]);
    }

    /**
     * 获取当天新增会员
     * @return Account|null
     */
    public function getTodayAccount($status = null, $type = null)
    {
        return Account::findModel()->search([
            'type'       => $type,
            'status'     => $status,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部项目
     * @param null $type
     * @return Project|null
     * @throws \Exception
     */
    public function getTotalProject($status = null, $type = null)
    {
        return Project::findModel()->search(['type' => $type, 'status' => $status]);
    }

    /**
     * 获取当天新增项目
     * @param null $type
     * @return Project|null
     * @throws \Exception
     */
    public function getTodayProject($status = null, $type = null)
    {
        return Project::findModel()->search([
            'type'       => $type,
            'status'     => $status,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部模块
     * @return mixed
     */
    public function getTotalModule($status = null)
    {
        return Module::findModel()->search(['status' => $status]);
    }

    /**
     * 获取当天新增模块
     * @return Project|null
     * @throws \Exception
     */
    public function getTodayModule($status = null)
    {
        return Module::findModel()->search([
            'status'     => $status,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部接口
     * @return mixed
     */
    public function getTotalApi($status = null)
    {
        return Api::findModel()->search(['status' => $status]);
    }

    /**
     * 获取当天新增接口
     * @return mixed
     */
    public function getTodayApi($status = null)
    {
        return Api::findModel()->search([
            'status'     => $status,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

}
