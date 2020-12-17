<?php
/**
 * Created by shaofeng
 * Date: 2020/12/08 20:49
 */

namespace App\Http\Controllers;


use App\Common\entity\Article;
use App\Common\Exception\ExampleException;
use App\Common\Query\QueryParam;
use App\Common\Util\JsonUtil;
use App\Dao\ArticleModel;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ArticleController extends Controller
{
    public function welcome(Request $request)
    {

        $paramFiles=$request->files;
        foreach ($paramFiles as $singleFile){
            $singleObject=(object)$singleFile;
            echo 'hello 123';
        }
        echo 'hello';
//        throw new ExampleException("this is exception from ArticleController");
//        $request->toArray();
//        $article=new Article();
//        $article->setId(1);
//        $article->setAge(20);
//        $article->setName('邵锋23');
//        $article->setFirstName('shao');
//        $articleJson=JsonUtil::toJson($article);
//        echo $articleJson;
//        $arr=JsonUtil::toArray($articleJson);
//        $articleModel=new ArticleModel();
//        $articleModel->updateModelById($article);
//        $queryParam=new QueryParam();
//        $queryParam->setPageNo(1);
//        $queryParam->setPageSize(3);
//        $queryParam->setOrderColumn("id");
//        $pageQuerydata=JsonUtil::toJson($articleModel->pageQuery($queryParam));
//        echo $pageQuerydata;
    }
}