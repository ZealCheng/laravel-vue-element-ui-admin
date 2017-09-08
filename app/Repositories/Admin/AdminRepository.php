<?php
/**
 * 后台基础服务基类
 * User: fengyan
 * Date: 2017/8/27
 * Time: 上午1:40
 */

namespace App\Repositories\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class AdminRepository implements InterAdminRepository
{
    /**
     * 错误信息
     * @var string
     */
    protected $msg = '';

    protected $model;

    public function __construct()
    {

    }

    /**
     * 获取当前对象
     * @return $this
     */
    public function getInstance() {
        return $this;
    }

    /**
     * 根据id号批量删除
     * @param array $ids
     * @return mixed
     */
    public function removeByIds(array $ids = [])
    {
        return $this->model->whereIn('id', $ids)->delete($ids);
    }

    /**
     * 添加数据
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function add(Request $request)
    {
        $params = $request->input('params', []);

        foreach ($params as $key=>$value) {
            $this->model->$key = $value;
        }

        $re = $this->model->save();

        if (!$re) {
            throw new \Exception("添加数据失败");
        }

        $this->msg = "添加数据成功";

        return true;

    }

    /**
     * 更新数据
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        $params = $request->input('params', []);

        $model = $this->model->find($params['id']);

        foreach ($params as $key=>$value) {
            if ($key == 'updated_at' || $key == 'deleted_at') {
                continue;
            }
            $model->$key = $value;
        }

        $re = $model->save();

        if (!$re) {
            throw new \Exception("更新数据失败");
        }

        $this->msg = "更新数据成功";

        return true;
    }

    /**
     * 返回错误信息
     * @return string
     */
    public function getMsg()
    {
        return $this->msg;
    }
}