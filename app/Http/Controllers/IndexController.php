<?php

namespace App\Http\Controllers;

use App\Services\IndexService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $index;
    protected $request;

    public function __construct(IndexService $index, Request $request)
    {
        $this->index = $index;
        $this->request = $request;
    }

    /**
     * 记录列表
     *
     * @param null $keyword
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $num = config('site.list_num');

        $lists = $this->index->get($num);

        return view('index.list', [
            'lists' => $lists,
        ]);
    }

    /**
     * 搜索
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $this->validate($this->request, [
            'end_time' => 'required',
            'start_time' => 'required',
        ]);

        $lists = $this->index->getSearch($this->request->all());

        return view('index.list', [
            'lists' => $lists,
        ]);
    }

    /**
     * 添加视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        return view('index.add_or_update', [
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('add'),
            'sign' => 'add',
        ]);
    }

    /**
     * 修改管理员视图
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function updateView($id)
    {
        try {
            $old_input = $this->request->session()->has('_old_input') ?
                session('_old_input') : $this->index->first($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view('index.add_or_update', [
            'old_input' => $old_input,
            'url' => Route('update', ['id' => $id]),
            'sign' => 'update',
        ]);
    }

    /**
     * 添加/更新提交
     *
     * @param null $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function post($id = null)
    {
        $this->validate($this->request, [
            'train' => 'required',
            'track' => 'required|integer',
            'arrival_time' => 'required',
            'locomotive' => 'required',
            'departure_time' => 'required',
        ]);

        try {
            $this->index->updateOrCreate($this->request->all(), $id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('index');
    }

    /**
     * 删除记录
     *
     * @param $id
     * @return bool|null
     */
    public function destroy($id)
    {
        try {
            $this->index->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return redirect()->route('index_list');
    }
}