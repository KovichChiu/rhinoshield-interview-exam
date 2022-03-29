<?php
/**
 * TodoRepositories
 * 存取 todolist相關 db資料入口
 */

namespace App\Repositories;

use App\Models\Todolist;
use App\Models\Todocontent;

class TodoRepositories
{
    public function __construct(){}

    /**
     * 取todolist getTodolist
     * @param type mixed 狀態(null, 0, 1)
     * @param count int // 每頁數量
     * 
     * @return array
     */
    public function getTodoList($type, $count)
    {
        $todoList = Todolist::paginate($count);
        if ($type != null) {
            $todoList = Todolist::where('completed', $type)->paginate($count);
        }

        $todoList = $todoList->toArray();

        return $todoList['data'];
    }

    /**
     * 新增任務 addTodolist
     * 
     * @return int
     */
    public function addTodolist()
    {
        // 新增一筆list
        $todoList = new Todolist;
        $todoList->save();

        return $todoList->id;
    }

    /**
     * 新增TodoContent addTodoContent
     * @param listId int
     * @param content string
     * 
     * @return bool
     */
    public function addTodoContent($listId, $content)
    {
        // 寫入 todocontent
        $todoContent = new Todocontent;
        $todoContent->todoListId = $listId;
        $todoContent->content = $content;

        return $todoContent->save();
    }

    /**
     * 更新任務狀態 updateTodolistType
     * @param id int
     * @param type int
     * 
     * @return void
     */
    public function updateTodolistType($id, $type)
    {
        $todoListData = Todolist::find($id);

        $todoListData->completed = $type;

        $todoListData->save();
    }

    /**
     * 取task內容 getTodoContent
     * @param todoListId array
     * 
     * @return array
     */
    public function getTodoContent($todoListId)
    {
        $todoContent = Todocontent::whereIn('todolistId', $todoListId)->orderBy('id', 'ASC')->get()->toArray();
        
        $data = [];
        foreach ($todoContent as $val) {
            $data[$val['todolistId']] = $val['content'];
        }

        return $data;
    }

    /**
     * 更新list modifyTodoList
     * @param id int
     * @param type int
     * 
     * @return void
     */
    public function modifyTodoList($id, $type)
    {
        // 更新狀態
        $todoList = Todolist::where('id', $id)->update(['completed' => $type]);
    }

    /**
     * 刪除資料 delTodoList
     * @param id int
     * 
     * @return void
     */
    public function delTodoList($id)
    {
        // 刪除資料
        $todoList = Todolist::where('id', $id)->delete();
    }

    /**
     * 刪除已完成資料 delCompleted
     * 
     * @return void
     */
    public function delCompleted()
    {
        // 刪除已完成資料
        $todoList = Todolist::where('completed', 1)->delete();
    }
}
