<?php

namespace App\Repositories;

use App\Record;
use Carbon\Carbon;

class RecordRepository
{
    protected $record;

    public function __construct(Record $record)
    {
        $this->record = $record;
    }

    /**
     * 创建记录
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->record->create($data);
    }

    /**
     * 获取所有显示记录（带分页）
     *
     * @param $page
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($num)
    {
        return $this->record
            ->orderBy('id', 'desc')
            ->paginate($num);
    }

    /**
     * 获取所有显示记录(不带分页)
     *
     * @param array ...$select
     * @return mixed
     */
    public function getSimple(...$select)
    {
        return $this->record
            ->select($select)
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * 获取显示的搜索结果
     *
     * @param $num
     * @param $keyword
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSearch($post)
    {
        $start = Carbon::parse($post['start_time'])->toDateTimeString();
        $end = Carbon::parse($post['end_time'])->addDay(1)->toDateTimeString();

        return $this->record
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
            ->orderBy('id', 'desc')
            ->paginate(config('site.list_num'));
    }

    /**
     * 获取单条记录
     *
     * @param $id
     * @return mixed
     */
    public function first($id)
    {
        return $this->record->find($id);
    }

    /**
     * 删除记录
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->record
            ->where('id', $id)
            ->delete();
    }

    /**
     * 获取单条记录（带where和select）
     *
     * @param $where
     * @param array ...$select
     * @return mixed
     */
    public function selectFirst($where, ...$select)
    {
        return $this->record
            ->select($select)
            ->where($where)
            ->first();
    }

    /**
     * 更新记录
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->record
            ->where('id', $id)
            ->update($data);
    }
}