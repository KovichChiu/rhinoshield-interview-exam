// 全域變數
var taskList;
var paginate;

$(document).ready(function(){
    // 寫全域變數
    taskList = new Array();
    paginate = "All"; // 預設全查

    // 進入畫面先取data
    getData();

    // 更新task列表
    updateTaskList();
});

// 依據是否完成顯示
function show(type) {
    // 若有帶入type 更新paginate
    if (type !== "") {
        paginate = type;
    }

    // 更新task列表
    updateTaskList();
}

// 取當前data
function getData() {
    task = localStorage.getItem("taskList");
    if (task === null) {
        taskList = [];
    } else {
        taskList = JSON.parse(task);
    }
}

// 新增資料
function add(taskData) {
    var type = 0; // active
    var content = taskData;

    // 清空input box
    $('#newTask').val("");

    // 組合資料
    var taskItem = new Array();
    taskItem = {
        "type": type,
        "content": content
    };
    taskList.push(JSON.stringify(taskItem));

    // 更新localstorage
    localStorage.setItem("taskList", JSON.stringify(taskList));

    // 更新task列表
    updateTaskList();
}

// 更新task列表
function updateTaskList() {
    // 淨空
    $("#taskList").empty();

    // 重取data
    getData();

    $.each(taskList, function(key, value) {
        var taskItem = JSON.parse(value);
        // 是否顯示
        switch(paginate) {
            case 'Active':
                if (taskItem['type'] !== 0) {
                    return;
                }
                break;
            case 'Completed':
                if (taskItem['type'] !== 1) {
                    return;
                }
                break;
            default:
                break;
        }

        // 是否已完成
        var checked = "";
        if (taskItem['type'] == 1) {
            checked = "checked";
        }

        // 更新畫面
        $("#taskList").append(`
            <li class="list-group-item">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" ` + checked + ` id="cb` + key + `" onchange="updateTaskType(` + key + `)">
                    <label class="form-check-label" style="" for="cb` + key + `" id="lb` + key + `">
                    ` + taskItem['content'] + `
                    </label>
                    <button class="btn btn-outline-secondary" type="button" onclick="delTask(` + key + `)")">X</button>
                </div>
            </li>
        `);

        // 依據狀態畫刪除線
        if (checked == "checked") {
            $("#lb" + key).css({"text-decoration": "line-through","color": "#a0a0a0"});
        }
    });
}

// 更新task狀態
function updateTaskType(taskId) {
    // 畫面更新
    var type = 0;
    $("#lb" + taskId).css({"text-decoration": "none","color": "black"});
    if($("#cb" + taskId).prop("checked") === true) {
        $("#lb" + taskId).css({"text-decoration": "line-through","color": "#a0a0a0"});
        type = 1;
    }

    // 資料更新
    var taskItem = JSON.parse(taskList[taskId]);
    taskItem['type'] = type;
    taskList[taskId] = JSON.stringify(taskItem);

    // 更新localstorage
    localStorage.setItem("taskList", JSON.stringify(taskList));
}

// 清除已完成task
function clearCompletedTask() {
    // 重取data
    getData();

    // 移除已完成資料
    var clearData = new Array();
    $.each(taskList, function(key, value) {
        var taskItem = JSON.parse(value);
        if (taskItem['type'] !== 1) {
            clearData.push(value);
        }
    });

    // 更新localstorage
    localStorage.setItem("taskList", JSON.stringify(clearData));

    // 更新task列表
    updateTaskList();
}

// 移除task
function delTask(taskId) {
    taskList.splice(taskId, 1);

    // 更新localstorage
    localStorage.setItem("taskList", JSON.stringify(taskList));

    // 更新task列表
    updateTaskList();
}
