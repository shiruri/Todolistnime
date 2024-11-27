<?php
session_start();

// Initialize the task array if not already set
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Add a new task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['add-task'])) {
    $new_task = trim($_POST['add-task']);
    if (!empty($new_task)) {
        $_SESSION['tasks'][] = $new_task; 
    }
}

// Remove a task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove-task'])) {
    $task_index = (int)$_POST['remove-task'];
    if (isset($_SESSION['tasks'][$task_index])) {
        unset($_SESSION['tasks'][$task_index]);
        // Re-index the array to prevent gaps
        $_SESSION['tasks'] = array_values($_SESSION['tasks']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todonime</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .task-input {
            display: flex;
            margin-bottom: 1rem;
        }

        .task-input input {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            font-size: 1rem;
            margin-right: 0.5rem;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.2s;
        }

        .task-input input:focus {
            border-color: #007bff;
        }

        .task-input button {
            padding: 0.5rem 1rem;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.2s;
        }

        .task-input button:hover {
            background-color: #0056b3;
        }

        .task-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .task-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .task-list li .task {
            flex: 1;
            font-size: 1rem;
            color: #333;
            text-decoration: none;
        }

        .task-list li .task.completed {
            text-decoration: line-through;
            color: #888;
        }

        .task-list li button {
            background: none;
            border: none;
            color: #d9534f;
            cursor: pointer;
            font-size: 1rem;
        }

        .task-list li button:hover {
            color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Todonime</h1>
        <div class="task-input">
            <form action="index.php" method="POST">
                <input type="text" placeholder="Add a new task..." name="add-task">
                <button>Add</button>
            </form>
        </div>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['add-task'])): ?>
            <div class="notification" style="color: red; text-align: center; margin-bottom: 1rem;">
                Warning: Blank TodoList
            </div>
        <?php endif; ?>

        <ul class="task-list">
            <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                <li>
                    <span class="task"><?php echo htmlspecialchars($task); ?></span>
                    <form action="index.php" method="POST" style="display: inline;">
                        <input type="hidden" name="remove-task" value="<?php echo $index; ?>">
                        <button type="submit">❌</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
