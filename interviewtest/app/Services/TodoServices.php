<?php
/**
 * TodoServices
 * 存取 todolist相關 邏輯
 */

namespace App\Services;

use App\Repositories\TodoRepositories;

class TodoServices
{
    public function __construct(){}

    /**
     * 取todo列表 getTodolist
     * @param count int 每頁顯示數量
     * @param type mixed 狀態 (null, 0, 1)
     * 
     * @return array
     */
    public function getTodoList($type, $count)
    {
        $todoRepositories = new TodoRepositories;

        // 取 list
        $todoList = $todoRepositories->getTodoList($type, $count);

        // 取 todoListId 列表
        $idList = collect($todoList)->pluck('id')->all();

        // 取 content
        $todoContent = $todoRepositories->getTodoContent($idList);

        // 組合資料
        $data = [];
        foreach ($todoList as $val) {
            $data[] = [
                'todoListId' => $val['id'],
                'content' => $todoContent[$val['id']],
                'completed' => $val['completed'],
            ];
        }

        return $data;
    }

    /**
     * 新增一筆list addTodoList
     * @param content string
     * 
     * @return bool
     */
    public function addTodoList($content)
    {
        $todoRepositories = new TodoRepositories;

        // 取 listId
        $listId = $todoRepositories->addTodolist();

        // 寫入 content
        return $todoRepositories->addTodoContent($listId, $content);

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
        // 更新list
        $todoRepositories = new TodoRepositories;
        $todoRepositories->modifyTodoList($id, $type);
    }

    /**
     * 刪除資料 delTodoList
     * @param id int
     * 
     * @return void
     */
    public function delTodoList($id)
    {
        // 刪除list
        $todoRepositories = new TodoRepositories;
        $todoRepositories->delTodoList($id);
    }

    /**
     * 刪除已完成資料 delCompleted
     * 
     * @return void
     */
    public function delCompleted()
    {
        // 刪除已完成資料
        $todoRepositories = new TodoRepositories;
        $todoRepositories->delCompleted();
    }
}
