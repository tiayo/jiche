<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($data)
    {
        return $this->user->create($data);
    }

    /**
     * 获取所有显示记录
     *
     * @param $page
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($num)
    {
        return $this->user
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取显示的搜索结果
     *
     * @param $num
     * @param $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearch($num, $keyword)
    {
        return $this->user
            ->where(function ($query) use ($keyword) {
                $query->where('users.name', 'like', "%$keyword%")
                    ->orwhere('users.email', 'like', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    public function first($id)
    {
        return $this->user->find($id);
    }

    public function destroy($id)
    {
        //删除user表
        return $this->user
            ->where('id', $id)
            ->delete();
    }

    public function selectFirst($where, ...$select)
    {
        return $this->user
            ->select($select)
            ->where($where)
            ->first();
    }

    public function selectGet($where, ...$select)
    {
        return $this->user
            ->select($select)
            ->where($where)
            ->get();
    }

    public function getStore($group)
    {
        if ($group == 'discover') {
            return $this->user
                ->where('type', 2)
                ->limit(20)
                ->inRandomOrder()
                ->get();
        }

        return $this->user
            ->where('type', 2)
            ->where(function ($query) use ($group) {
                $query->where('group', 0)
                    ->orwhere('group', $group);
            })
            ->get();
    }

    public function getSearchStore($keyword)
    {
        return $this->user
            ->where('type', 2)
            ->where('name', 'like', "%$keyword%")
            ->get();
    }

    public function update($id, $data)
    {
        return $this->user
            ->where('id', $id)
            ->update($data);
    }

    public function count($where)
    {
        return $this->user
            ->where($where)
            ->count();
    }
}