<?php
/**
 * Created by shaofeng
 * Date: 2020/12/11 14:16
 */

namespace App\Dao;


use App\Common\Exception\ExampleException;
use App\Common\Query\QueryParam;
use App\Common\Query\QueryResponse;
use App\Common\Util\CommonUtil;
use App\Common\Util\JsonUtil;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * @var array 存放数据列与bean的映射关系
     */
    protected $mappingArray = [];

    /**
     * @var bool 忽略新增更新时间处理
     */
    public $timestamps = false;

    /**
     * @param $id
     * @return array
     * 根据主键查询
     */
    public function queryById($id): array
    {
        $queryResult = $this->newQuery()->find($id);
        if (CommonUtil::isNull($queryResult)) {
            return null;
        }
        $resultArray = $queryResult->toArray();
        echo $resultArray;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     * 根据主键删除
     */
    public function deleteById($id): bool
    {
        if (CommonUtil::isNull($id)) {
            throw new ExampleException("deleteById id should not be null");
        }
        $queryResult = $this->newQuery()->find($id);
        if ($queryResult == null) {
            throw new ExampleException("id=" . $id . ' not exist');
        }
        $queryResult->delete();
        return true;
    }

    /**
     * @param BaseDao $baseDao
     * 新增数据
     */
    public function insertModel(BaseDao $baseDao)
    {
        $modelArray = $this->buildModelArray($baseDao);
        $this->insertData($modelArray);
    }

    /**
     * @param BaseDao $baseDao
     * 根据id更新数据
     */
    public function updateModelById(BaseDao $baseDao)
    {
        $modelArray = $this->buildModelArray($baseDao);
        $this->updateDataById($modelArray);
    }

    /**
     * @param BaseDao $baseDao
     * @return array
     * 将对象转换为数组
     */
    private function buildModelArray(BaseDao $baseDao): array
    {
        $this->dbMapping();
        $dataArray = [];
        if (CommonUtil::isNull($baseDao)) {
            $articleArray = JsonUtil::toArray(JsonUtil::toJson($baseDao));
            foreach ($articleArray as $key => $value) {
                foreach ($this->mappingArray as $mappingKey => $mappingValue) {
                    if ($key == $mappingValue) {
                        $dataArray[$mappingKey] = $value;
                    }
                }
            }
        }
        return $dataArray;
    }

    private function insertData(array $options = [])
    {
        if (CommonUtil::isNull($options)) {
            throw new ExampleException("addModel data should not be null");
        }
        $getId = $this->newQuery()->insertGetId($options);
        return $getId;
    }

    private function updateDataById(array $options = [])
    {
        if (CommonUtil::isNull($options)) {
            throw new ExampleException("updateModel data should not be null");
        }
        $updateLines = $this->newQuery()->where('id', $options['id'])->update($options);
        return $updateLines;
    }

    /**
     * @param QueryParam $queryParam
     * @return QueryResponse
     * 分页查询数据
     */
    public function pageQuery(QueryParam $queryParam): QueryResponse
    {
        $this->pageQueryParamCheck($queryParam);
        $builder = $this->newQuery();
        $wheres = $queryParam->getWhere();
        if (CommonUtil::isNull($wheres)) {
            foreach ($wheres as $key => $value) {
                $builder->where($key, $value);
            }
        }
        $total = $builder->count();
        $pageNo = $queryParam->getPageNo();
        $pageSize = $queryParam->getPageSize();
        if ($total < (($pageNo - 1) * $pageSize + 1)) {
            $queryResponse = new QueryResponse();
            $queryResponse->setTotal($total);
            return $queryResponse;
        }
        $queryResult = $builder->orderBy($queryParam->getOrderColumn(), $queryParam->getOrderType())
            ->forPage($queryParam->getPageNo(), $queryParam->getPageSize())->get();
        $queryResponse = new QueryResponse();
        $queryResponse->setTotal($total);
        $dataArray = $queryResult->toArray();
        $queryResponse->setData($this->convert2Object($dataArray));
        return $queryResponse;
    }

    private function convert2Object(array $data = [])
    {
        if (CommonUtil::isEmpty($data)) {
            return [];
        }
        $this->dbMapping();
        $length = count($data);
        $result = [];
        for ($i = 0; $i < $length; $i++) {
            $currentArray = [];
            foreach ($data[$i] as $key => $value) {
                $mappingValue = $this->mappingArray[$key];
                if (CommonUtil::isNotEmpty($mappingValue)) {
                    $currentArray[$mappingValue] = $value;
                }
            }
            $result[$i] = $currentArray;
        }
        return $result;
    }

    private function pageQueryParamCheck(QueryParam $queryParam)
    {
        if ($queryParam->getPageNo() < 1) {
            throw new ExampleException("pageQueryParamCheck failed pageNo= " . $queryParam->getPageNo());
        }
        if ($queryParam->getPageSize() < 1 || $queryParam->getPageSize() > 1000) {
            throw new ExampleException("pageQueryParamCheck failed pageSize= " . $queryParam->getPageSize());
        }
    }

    protected abstract function dbMapping(): array;
}