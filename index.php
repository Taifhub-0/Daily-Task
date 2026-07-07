<?php
require_once __DIR__ . '/db/DBConnection.php';

$db = DBConnection::getConnection();

//Create Table
$db->exec("
    CREATE TABLE IF NOT EXISTS tasks (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        task_name TEXT NOT NULL,
        status TEXT NOT NULL
    )
")

//Add Task
if (isset($_POST['add'])) {
    $taskName = $_POST['task_name'];
    $status = $_POST['status'];

    $stmt = $db->prepare("INSERT INTO tasks (task_name, status) VALUES (?, ?)");
    $stmt->execute([$taskName, $status]);

    header("Location: index.php");
    exit;
}

//update Task
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $taskName = $_POST['task_name'];
    $status = $_POST['status'];

    $stmt = $db->prepare("UPDATE tasks SET task_name=?, status=? WHERE id=?");
    $stmt->execute([$taskName, $status, $id]);

    header("Location: index.php");
    exit;
}

//delete Task
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $db->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
    exit;
}

//Select task to edit
$editTask = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $db->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    $editTask = $stmt->fetch(PDO::FETCH_ASSOC);
}

//view all Task
$stmt = $db->query("SELECT * FROM tasks");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container justify-content-center">
        <span class="navbar-brand fw-bold display-5">
            Daily Tasks
        </span>
    </div>
</nav>

<!-- Main Content -->
<main class="flex-fill py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <!-- Add / Edit Task Card -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <?= $editTask ? 'Edit Task' : 'Add New Task' ?>
                        </h5>

                        <form method="post" class="row g-3">
                            <input type="hidden" name="id" value="<?= $editTask['id'] ?? '' ?>">

                            <div class="col-md-6">
                                <input type="text"
                                       name="task_name"
                                       class="form-control"
                                       placeholder="Task name"
                                       value="<?= $editTask['task_name'] ?? '' ?>"
                                       required>
                            </div>

                            <div class="col-md-4">
                                <select name="status" class="form-select">
                                    <option value="Pending"
                                            <?= (isset($editTask) && $editTask['status'] == 'Pending') ? 'selected' : '' ?>>
                                        Pending
                                    </option>
                                    <option value="Done"
                                            <?= (isset($editTask) && $editTask['status'] == 'Done') ? 'selected' : '' ?>>
                                        Done
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 d-grid">
                                <?php if ($editTask): ?>
                                    <button type="submit" name="update" class="btn btn-primary">
                                        Update
                                    </button>
                                <?php else: ?>
                                    <button type="submit" name="add" class="btn btn-success">
                                        Add
                                    </button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tasks Table -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-striped table-hover text-center align-middle">
                            <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if (count($tasks) == 0): ?>
                                <tr>
                                    <td colspan="4">No tasks found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tasks as $task): ?>
                                    <tr>
                                        <td><?= $task['id'] ?></td>
                                        <td><?= $task['task_name'] ?></td>
                                        <td>
                                            <?php if ($task['status'] == 'Done'): ?>
                                                <span class="badge bg-success">Done</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="?edit=<?= $task['id'] ?>" class="btn btn-primary btn-sm">
                                                Edit
                                            </a>
                                            <a href="?delete=<?= $task['id'] ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure?')">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-3">
    Web Technologies 2 – Daily Tasks | Student ID: 443038092
</footer>

</body>
</html>
