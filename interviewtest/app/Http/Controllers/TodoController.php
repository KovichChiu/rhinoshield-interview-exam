<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Services\TodoServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function __construct(){}

    // 取資料
    public function getTodoList(Request $request)
    {
        // 驗證參數
        $v = Validator::make($request->all(), [
            'page' => 'required|integer',
            'count' => 'integer',
            'type' => 'integer|in:0,1',
        ]);
    
        if ($v->fails())
        {
            return $this->errorResponse($v->errors(), 10001);
        }

        $todoServices = new TodoServices();
        $todoList = $todoServices->getTodoList($request->type, $request->count);

        return $this->successResponse($todoList);
    }

    // 新增資料
    public function addTodoList(Request $request)
    {
        // 驗證參數
        $v = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);
    
        if ($v->fails())
        {
            return $this->errorResponse($v->errors(), 10002);
        }

        $todoServices = new TodoServices();
        $todoList = $todoServices->addTodoList($request->content);

        if (!$todoList) {
            return $this->errorResponse([], 10003);
        }

        return $this->successResponse($todoList);
    }

    // 更新資料
    public function modifyTodoList(Request $request)
    {
        // 驗證參數
        $v = Validator::make($request->all(), [
            'id' => 'required|integer',
            'type' => 'required|integer|in:0,1',
        ]);
    
        if ($v->fails())
        {
            return $this->errorResponse($v->errors(), 10004);
        }

        $todoServices = new TodoServices();
        $todoList = $todoServices->modifyTodoList($request->id, $request->type);

        return $this->successResponse([]);
    }

    // 刪除資料
    public function delTodoList(Request $request)
    {
        // 驗證參數
        $v = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
    
        if ($v->fails())
        {
            return $this->errorResponse($v->errors(), 10005);
        }

        $todoServices = new TodoServices();
        $todoList = $todoServices->delTodoList($request->id);

        return $this->successResponse([]);
    }

    // 刪除已完成資料
    public function delCompleted(Request $request)
    {
        $todoServices = new TodoServices();
        $todoList = $todoServices->delCompleted($request->id);

        return $this->successResponse([]);
    }

    // 成功回傳
    private function successResponse($data)
    {
        return json_encode([
            "status" => "Y",
            "data" => $data,
        ]);
    }

    // 失敗回傳(含 errorcode)
    private function errorResponse($data, $errCode)
    {
        return json_encode([
            "status" => "N",
            "data" => [],
            "errCode" => $errCode,
        ]);
    }
}
