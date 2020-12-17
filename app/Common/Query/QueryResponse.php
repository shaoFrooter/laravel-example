<?php
/**
 * Created by PhpStorm.
 * User: Shaof
 * Date: 2020/12/15
 * Time: 17:19
 * 分页查询响应
 */

namespace App\Common\Query;


class QueryResponse
{
    public $total;

    public $data;

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }



}