<?php
/**
 * Created by shaofeng
 * Date: 2020/12/11 14:12
 */

namespace App\Dao;

class ArticleModel extends BaseModel
{
    protected $table = 'tp_article';

    protected function dbMapping(): array
    {
        if (empty($this->mappingArray)) {
            $this->mappingArray = require 'mapping/article.php';
            return $this->mappingArray;
        }
        return $this->mappingArray;
    }

}