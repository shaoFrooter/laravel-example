<?php
/**
 * Created by PhpStorm.
 * User: Shaof
 * Date: 2020/12/16
 * Time: 14:22
 */

namespace App\Http\Controllers;


class ArticleController2 extends Controller

{
    public function testPost(){
        return 'hello testPost';
    }

    public function testPut(){
        return 'hello testPut';
    }
}