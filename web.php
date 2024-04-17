<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ToDo List</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
</head>
<body>
<header>
    <h1><span class="icon progress-icon">&#128202;</span> ToDo List</h1> 
</header>

<main>
    <section>
        <h2><span class="icon progress-icon">&#128202;</span> Project Progress</h2>
        <p>The ToDo List is a web application designed to help users manage their tasks effectively.</p>
        <p class="bold-text">Current Features:</p>
        <ul>
            <li>
                <input type="checkbox" id="task1">
                <label for="task1">Create tasks with descriptions, due dates, categories, and priority levels.</label>
                <span class="priority high">High</span>
                <button class="edit-btn">Edit</button>
            </li>
            <li>
                <input type="checkbox" id="task2">
                <label for="task2">Mark tasks as completed.</label>
                <span class="priority medium">Medium</span>
                <button class="edit-btn">Edit</button>
            </li>
            <li>
                <input type="checkbox" id="task3">
                <label for="task3">Create task categories and subcategories.</label>
                <span class="priority low">Low</span>
                <button class="edit-btn">Edit</button>
            </li>
            <li>
                <input type="checkbox" id="task4">
                <label for="task4">Edit categories and subcategories.</label>
                <span class="priority high">High</span>
                <button class="edit-btn">Edit</button>
            </li>
        </ul>
        <p class="bold-text">Upcoming Features:</p>
        <ul>
            <li>
                <input type="checkbox" id="task5">
                <label for="task5">User authentication to allow multiple users to manage their tasks independently.</label>
                <span class="priority medium">Medium</span>
                <button class="edit-btn">Edit</button>
            </li>
            <li>
                <input type="checkbox" id="task6">
                <label for="task6">Enhanced sorting and filtering options for tasks.</label>
                <span class="priority low">Low</span>
                <button class="edit-btn">Edit</button>
            </li>
            <li>
                <input type="checkbox" id="task7">
                <label for="task7">Integration with external calendars or notification systems.</label>
                <span class="priority high">High</span>
                <button class="edit-btn">Edit</button>
            </li>
        </ul>
        <p>We are continuously working on improving the app and adding new features to enhance user experience.</p>
    </section>
    <!-- Just tasks for now, they are not functional but working to make them functional within the next few weeks-->
    <section id="createTaskSection">
        <h2>Create Task</h2>
        <form id="taskForm">
            <div class="input-group">
                <label for="taskDescription">Task Description:</label><br>
                <input type="text" id="taskDescription" name="taskDescription" required>
            </div>

            <div class="input-group">
                <label for="dueDate">Due Date:</label><br>
                <input type="date" id="dueDate" name="dueDate" required>
            </div>

            <div class="input-group">
                <label for="category">Category:</label><br>
                <input type="text" id="category" name="category">
            </div>

            <div class="input-group">
                <label for="priority">Priority:</label><br>
                <select id="priority" name="priority">
                    <option value="1">High</option>
                    <option value="2">Medium</option>
                    <option value="3">Low</option>
                </select>
            </div>

            <button type="submit" class="btn-create">Create Task</button>
        </form>
    </section>
    <section>
        <h2><span class="icon navigation-icon">&#128506;</span> Navigation</h2> 
        <ul class="navigation-list">
            <li class="navigation-item"><a href="authors.php" class="navigation-link">Authors Page</a></li>
        </ul>
    </section>
    
       <!-- <section>
        <h2>Categories</h2>
        <form id="categoryForm">
            <label for="categoryName">Category Name:</label>
            <input type="text" id="categoryName" name="categoryName" required><br>
            <label for="parentCategory">Parent Category:</label>
            <select id="parentCategory" name="parentCategory">
                <option value="">None</option>
              
            </select><br>
            <button type="submit">Add Category</button>
        </form>
    </section>>
    -->
    <section>
        <h2>Functionalities</h2>
        <ol>
            <li>Current user can create tasks.</li>
            <li>Current user can mark a task as completed.</li>
            <li>Current user can create categories.</li>
            <li>Current user can edit categories (and subcategories).</li>
            <li>A category may have a parent category. A category with a parent category is called a subcategory.</li>
        </ol>
    </section>
</main>
<footer>
    <p>&copy; 2024 ToDo List App. All rights reserved.</p>
</footer>
<div id="editTaskModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h2>Edit Task</h2>
        <label for="taskName">Task Name:</label>
        <input type="text" id="taskName" name="taskName" required><br>
        
        <button id="saveTaskBtn">Save Changes</button>
        <button id="cancelEditBtn">Cancel</button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('taskForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var taskDescription = document.getElementById('taskDescription').value;
            var dueDate = document.getElementById('dueDate').value;
            var category = document.getElementById('category').value;
            var priority = document.getElementById('priority').value;
            var task = {
                description: taskDescription,
                dueDate: dueDate,
                category: category,
                priority: priority
            };
            addTaskToList(task);
            document.getElementById('taskForm').reset();
        });

        function addTaskToList(task) {
            var taskItem = document.createElement('li');
            taskItem.innerHTML = `
                <input type="checkbox" id="task${taskId}">
                <label for="task${taskId}">${task.description}</label>
                <span class="priority">${task.priority}</span>
                <button class="edit-btn">Edit</button>
            `;
            var taskList = document.getElementById('taskList');
            taskList.appendChild(taskItem);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        function handleTaskCompletion(event) {
            var checkbox = event.target;
            var taskDescription = checkbox.parentElement.querySelector('label').innerText;
            if (checkbox.checked) {
                console.log('Task completed:', taskDescription);
                checkbox.parentElement.querySelector('label').classLisst.add('completed');
            } else {
                console.log('Task marked as incomplete:', taskDescription);
                checkbox.parentElement.querySelector('label').classList.remove('completed');
            }
        }
        document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', handleTaskCompletion);
        });
    });
</script>
</body>
</html>
