# rhinoshield-interview-exam
 愛進化科技面試前測

## Question
- TodoMVC.
- Use Git for version control.
- Planning database.
- Develop the following API:
    + Add task.
    + Delete task.
    + Update task.
    + Search & paging task data.
    
## Implementation process
- 安裝 XAMPP 並確認可以正確執行
- 安裝 Composer 並確認安裝是否正確
- 安裝 Laravel 至 `xampp/htdocs`
- 瀏覽器開啟 `http://localhost/projectName/public` 確認是否可以正確開啟Laravel起始畫面
- 關閉apache並更改 `httpd.conf` 內容

```
原內容
DocumentRoot "D:/xampp/htdocs"
<DocumentRoot "D:/xampp/htdocs">

更改為
DocumentRoot "D:/xampp/htdocs/projectName/public/"
<Directory "D:/xampp/htdocs/projectName/public/">
```

- 啟動apache並確認`http://localhost`是否為Laravel起始畫面
- 開始開發~

## 前端程式
`resources\views\todolist.blade.php` 主畫面
`public\core.js` js邏輯

## 資料庫
```sql
CREATE TABLE `todolist` (
    `id` int(11) NOT NULL,
    `completed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `todolist`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `todolist`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;


CREATE TABLE `todocontent` (
    `id` int(11) NOT NULL,
    `content` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
    `todolistId` int(11) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
ALTER TABLE `todocontent`
    ADD PRIMARY KEY (`id`);
ALTER TABLE `todocontent`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;
```

### 設計理念
表`todolist` 紀錄任務狀態
表`todocontent` 紀錄任務內容

僅操作 `todolist` 進行增修，`todocontent` 作為永久保留資料方便備查，若需要更進一步的設計(Ex. 增加時間戳、user等資料)，也是新增在`todolist`中方便資料查找與操作。

## 後端程式

### 設計架構概述
- Controller 做為入口，進行資料驗證與判斷api是否成功執行
- Services 做為邏輯整理，進行後端邏輯控制、計算等
- Repositories 做為資料存取，原設計預想作為取API及DB資料後整理成可用資料處。不過本次專案僅需存取DB資料，故不另外製作取API程式

### 程式概述
本次製作五組API(詳情可參閱 `routes/api.php`)，分別內容如下:
- 取資料
- 新增資料
- 更新資料
- 刪除資料
- 清除已完成資料

API皆由Postman進行運作測試，皆可正確運作。

#### 取資料
GET `http://localhost/api/todolist`
- input:
    + page | int | 必填 | 分頁第幾頁
    + count | int | 必填 | 每頁顯示幾筆
    + type | int | 非必填 | 完成狀態(0:未完成, 1:已完成)
- output(json):
    + status | string | api執行狀態(Y/N)
    + data | array | 執行結果
    + data.[].todoListId | int
    + data.[].content | string
    + data.[].completed | int

#### 新增資料
POST `http://localhost/api/todolist`
- input:
    + content | string | 必填 | 任務內容
- output(json):
    + status | string | api執行狀態(Y/N)
    + data | bool | 執行結果

#### 更新資料
PUT `http://localhost/api/todolist`
- input:
    + id | int | 必填 | 任務id
    + type | int | 必填 | 完成狀態(0:未完成, 1:已完成)
- output(json):
    + status | string | api執行狀態(Y/N)
    + data | bool | 執行結果

#### 刪除資料
DELETE `http://localhost/api/todolist`
- input:
    + id | int | 必填 | 任務id
- output(json):
    + status | string | api執行狀態(Y/N)
    + data | bool | 執行結果

#### 清除已完成資料
DELETE `http://localhost/api/todolist/completed`
- noInput
- output(json):
    + status | string | api執行狀態(Y/N)
    + data | bool | 執行結果

----

> Produced by Windows, XAMPP, Laravel, Postman.