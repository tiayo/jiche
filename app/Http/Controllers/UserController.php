<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    protected $request;

    public function __construct(UserService $user, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * 管理员列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listView($keyword = null)
    {
        $num = config('site.list_num');

        $users = $this->user->get($num, $keyword);

        return view('user.list', [
            'lists' => $users,
        ]);
    }

    /**
     * 更新 视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateView($id)
    {
        try {
            $old_input = $this->request->session()->has('_old_input') ?
                session('_old_input') : $this->user->first($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), $e->getCode());
        }

        return view('user.add_or_update', [
            'old_input' => $old_input,
            'url' => Route('user_update', ['id' => $id]),
            'sign' => 'update',
        ]);
    }

    /**
     * 添加 视图
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addView()
    {
        return view('user.add_or_update', [
            'old_input' => $this->request->session()->get('_old_input'),
            'url' => Route('user_add'),
            'sign' => 'add',
        ]);
    }

    /**
     * 添加/更新提交
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($id = null)
    {
        $this->validate($this->request, [
            'name' => 'required',
            'password' => 'min:6',
        ]);

        //添加时补充验证
        if (empty($id)) {
            $this->validate($this->request, [
                'name' => 'required|unique:users',
                'password' => 'required',
            ]);
        }

        try {
            $this->user->update($this->request->all(), $id);
        } catch (\Exception $e) {
            return response($e->getMessage());
        }

        return redirect()->route('user_list');
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
            $this->user->destroy($id);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return redirect()->route('user_list');
    }
}