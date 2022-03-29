<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- jquery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script type="text/javascript" src="http://localhost/core.js"></script>

</head>
<body>
    <div class="container">
    <!-- top -->
    <div class="center"><h1>todos</h1></div>
    <hr>

    <!-- input -->
    <div class="input-group mb-3">
        <input type="text" class="form-control" id="newTask">
        <button class="btn btn-outline-secondary" type="button" onclick="add($('#newTask').val())">Add</button>
    </div>

    <!-- data -->
    <ul class="list-group" id="taskList"></ul>
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary" onclick="show('All')">All</button>
        <button type="button" class="btn btn-success" onclick="show('Active')">Active</button>
        <button type="button" class="btn btn-warning" onclick="show('Completed')">Completed</button>
        <button type="button" class="btn btn-outline-secondary" onclick="clearCompletedTask()">clear Completed</button>
    </div>
</body>
</html>