<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 17-9-1
 * Time: 下午3:05
 */

namespace App\Repositories\Admin;


use Illuminate\Http\Request;

interface InterAdminRepository
{
    /**
     * 获取提示信息
     * @return mixed
     */
    public function getMsg();

    /**
     * 各个服务需实现自己的分页方法
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginateData(Request $request) : \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * 根据id号批量删除
     * @param array $ids
     * @return mixed
     */
    public function removeByIds(array $ids = []);

    /**
     * 添加数据
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request);

    /**
     * 更新数据
     * @param Request $request
     * @return mixed
     */
    public function edit(Request $request);

}