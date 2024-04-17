# ToDo List SQL+PHP

## Overview
This project is a web application designed to manage a to-do list, providing users with a platform to organize tasks efficiently. It allows users to create, edit, and mark tasks as completed, as well as categorize tasks for better organization. The application offers various views and reports to enhance user experience and productivity.

## Basic Characteristics
1. No user identification needed.
2. Users can see all tasks without authentication.

## Data
### Tasks
- **Task Description**: Required field describing the task.
- **Due Date**: Required field indicating when the task is due.
- **Task Category**: Optional field for categorizing tasks.
- **Priority Level**: Optional field specifying the priority of the task (Values: 1-4, where 1 is the highest priority).
- **Status**: Indicates whether the task is active or completed.

### Categories
- **Name**: Name of the category.
- **Parent Category**: Another existing category which serves as the parent category.

## Functionalities
1. Users can create tasks.
2. Users can mark tasks as completed.
3. Users can create categories.
4. Users can edit categories (including subcategories).
5. Categories can have parent categories, creating subcategories.

## Views or Reports
1. **Default View**: Displays overdue tasks and tasks due today, sorted by priority.
2. **Completed Tasks View**: Allows users to view completed tasks for a specific day, sorted by due date.
3. **Weekly Report**: Provides a report for a specific week, showing the number of tasks completed each day and in total.

## Technologies Used
- Frontend: HTML, CSS, JavaScript
- Backend: Node.js, Express.js
- Database: MongoDB
- Other: Bootstrap (for UI design)

## Setup Instructions
1. Clone this repository.
2. Install dependencies using `npm install`.
3. Set up MongoDB database.
4. Configure environment variables.
5. Run the application using `npm start`.

## Contributors
- [Your Name](https://github.com/yourusername)

## License
This project is licensed under the [MIT License](LICENSE).
