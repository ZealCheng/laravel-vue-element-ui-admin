<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class AdminController extends Controller
{
    protected $templetePrefix = 'admin.';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * 每个继承admin控制器的方法需要声明该控制器的服务处理者
     * @return \App\Repositories\Admin\InterAdminRepository
     */
    abstract protected function getServiceRepositories();

    /**
     * 获取用好列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $this->getServiceRepositories()->getPaginateData($request);

        if ($request->ajax()) {
            return $this->successForAjax('获取数据列表成功', $data->toArray());
        }

        return view($this->templetePrefix.'index', ['data'=>$data]);
    }

    /**
     * 添加数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd(Request $request)
    {
        try {
            $this->getServiceRepositories()->add($request);

        } catch (\Exception $exception) {
            return $this->errorForAjax($exception->getMessage(), []);
        }

        return $this->successForAjax($this->getServiceRepositories()->getMsg());
    }

    /**
     * 更新数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEdit(Request $request)
    {
        try {
            $this->getServiceRepositories()->edit($request);

        } catch (\Exception $exception) {
            return $this->errorForAjax($exception->getMessage());
        }

        return $this->successForAjax($this->getServiceRepositories()->getMsg());
    }

    /**
     * 批量删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRemove(Request $request)
    {
        $params = $request->input('params', []);
        $ids = isset($params['ids']) ? $params['ids'] : 0;
        $ids = is_string($ids) || is_numeric($ids) ? explode(',', $ids) : $ids;
        
        if ($this->getServiceRepositories()->removeByIds($ids)) {
            return $this->successForAjax('删除编号为['.implode(',', $ids).']的数据成功', []);
        }
        return $this->errorForAjax('删除编号为['.implode(',', $ids).']的数据失败', []);
    }

    /**
     * @param array $data
     * @param int $code
     * @param string $msg
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    protected function outPut(array $data = [], $code = 0, $msg = '', $type = 'success')
    {
        return response()->json([
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'type' => $type
        ]);
    }

    /**
     * 成功返回数据
     * @param string $msg
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successForAjax($msg = '', $data = [])
    {

        return $this->outPut($data, 0, $msg ? $msg : '操作成功', 'success');
    }

    /**
     * 失败返回数据
     * @param string $msg
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorForAjax($msg = '', $data = [])
    {
        return $this->outPut($data, -1, $msg ? $msg : '操作失败', 'error');
    }
}
