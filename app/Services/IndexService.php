<?php

namespace App\Services;

use App\Repositories\RecordRepository;
use Exception;

class IndexService
{
    protected $record;

    public function __construct(RecordRepository $record)
    {
        $this->record = $record;
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
        $first = $this->record->first($id);

        throw_if(empty($first), Exception::class, '未找到该记录！', 404);

        return $first;
    }

    /**
     * 获取需要的数据
     *
     * @param int $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($num = 10000)
    {
        return $this->record->get($num);
    }

    public function getSearch($post)
    {
        return $this->record->getSearch($post);
    }

    /**
     * 获取需要的数据
     *
     * @param array ...$select
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSimple(...$select)
    {
        return $this->record->getSimple(...$select);
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
     * 更新或编辑
     *
     * @param $post
     * @param null $id
     * @return mixed
     */
    public function updateOrCreate($post, $id = null)
    {
        //常规字段
        $data['train'] = $post['train'];
        $data['track'] = $post['track'];
        $data['arrival_time'] = $post['arrival_time'];
        $data['locomotive'] = $post['locomotive'];
        $data['departure_time'] = $post['departure_time'];

        //预留字段
        for ($i = 1; $i <= 5; $i++) {
             if (isset($post['reserve_'.$i]) && !empty($post['reserve_'.$i])) {
                 $data['reserve_'.$i] = $post['reserve_'.$i];
             }
        }

        //执行插入或更新
        return empty($id) ? $this->record->create($data) : $this->record->update($id, $data);
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
        $this->validata($id)->toArray();

        //执行删除
        return $this->record->destroy($id);
    }
}