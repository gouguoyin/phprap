<?php

namespace app\models;

use Yii;

class Tongji
{

    /**
     * 获取全部会员
     * @return Account|null
     */
    public function getTotalAccount()
    {
        return Account::findModel()->search(['status' => Account::ACTIVE_STATUS, 'type' => Account::USER_TYPE]);
    }

    /**
     * 获取当天新增会员
     * @return Account|null
     */
    public function getTodayAccount()
    {
        return Account::findModel()->search([
            'type'       => Account::USER_TYPE,
            'status'     => Account::ACTIVE_STATUS,
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
    public function getTotalProject($type = null)
    {
        return Project::findModel()->search(['type' => $type, 'status' => Project::ACTIVE_STATUS]);
    }

    /**
     * 获取当天新增项目
     * @param null $type
     * @return Project|null
     * @throws \Exception
     */
    public function getTodayProject($type = null)
    {
        return Project::findModel()->search([
            'type'       => $type,
            'status'     => Project::ACTIVE_STATUS,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部模块
     * @return mixed
     */
    public function getTotalModule()
    {
        return Module::findModel()->search(['status' => Module::ACTIVE_STATUS]);
    }

    /**
     * 获取当天新增模块
     * @return Project|null
     * @throws \Exception
     */
    public function getTodayModule()
    {
        return Module::findModel()->search([
            'status'     => Module::ACTIVE_STATUS,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

    /**
     * 获取全部接口
     * @return mixed
     */
    public function getTotalApi()
    {
        return Api::findModel()->search(['status' => Api::ACTIVE_STATUS]);
    }

    /**
     * 获取当天新增接口
     * @return mixed
     */
    public function getTodayApi()
    {
        return Api::findModel()->search([
            'status'     => Api::ACTIVE_STATUS,
            'start_date' => date('Y-m-d'),
            'end_date'   => date('Y-m-d'),
        ]);
    }

}
