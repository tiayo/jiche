<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;

class UserService
{
    protected $user, $commodity;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * 通过id验证记录是否存在以及是否有操作权限
     * 通过：返回该记录
     * 否则：抛错
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function validata($id)
    {
        $salesman = $this->user->first($id);

        throw_if(empty($salesman), Exception::class, '未找到该记录！', 404);

        return $salesman;
    }

    /**
     * 获取需要的数据
     *
     * @return mixed
     */
    public function get($num = 10000, $keyword = null)
    {
        if (!empty($keyword)) {
            return $this->user->getSearch($num, $keyword);
        }

        return $this->user->get($num);
    }

    /**
     * 获取商户
     *
     * @return mixed
     */
    public function getBusiness()
    {
        return $this->user->selectGet([
            ['type', 2],
        ], '*');
    }

    /**
     * 更新
     *
     * @param $post
     * @param null $id
     * @return mixed
     */
    public function update($post, $id)
    {
        $data['name'] = $post['name'];

        empty($post['password']) ? true : $data['password'] = bcrypt($post['password']);

        //执行插入或更新
        return empty($id) ? $this->user->create($data) : $this->user->update($id, $data);
    }

    /**
     * 查找指定id的用户
     *
     * @param $id
     * @return mixed
     */
    public function first($id)
    {
        return $this->validata($id);
    }

    /**
     * 删除管理员
     *
     * @param $id
     * @return bool|null
     */
    public function destroy($id)
    {
        //验证是否可以操作当前记录
        $user = $this->validata($id)->toArray();

        //验证商户下是否有商品
        if ($user['type'] == 2) {
            throw_if($this->commodity->selectCount([
                ['user_id', $id]
            ]) > 0, Exception::class, '该商户还有商品，先删除商品。', 403);
        }

        //执行删除user表
        return $this->user->destroy($id);
    }

    /**
     * 按需求统计
     *
     * @param $where
     * @return mixed
     */
    public function count($where){
        return $this->user->count($where);
    }
}