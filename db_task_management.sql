CREATE DATABASE db_task_management;
USE db_task_management;

CREATE TABLE tbl_task (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title TEXT(255) NOT NULL,
    description TEXT NOT NULL,
    status TEXT(255) NOT NULL,
    due_date DATE NOT NULL
);

INSERT INTO tbl_task (id, title, description, status, due_date)
VALUES 
    (1, 'Task 1', 'Complete project documentation', 'Pending', '2024-09-30'),
    (2, 'Task 2', 'Develop login feature', 'In Progress', '2024-10-05'),
    (3, 'Task 3', 'Test user registration module', 'Completed', '2024-09-25'),
    (4, 'Task 4', 'Fix bug in payment gateway', 'Pending', '2024-10-10'),
    (5, 'Task 5', 'Create database schema', 'Completed', '2024-09-15'),
    (6, 'Task 6', 'Design landing page', 'In Progress', '2024-10-08'),
    (7, 'Task 7', 'Set up CI/CD pipeline', 'Pending', '2024-10-12'),
    (8, 'Task 8', 'Optimize SQL queries', 'Completed', '2024-09-20'),
    (9, 'Task 9', 'Write unit tests for API', 'Pending', '2024-10-06'),
    (10, 'Task 10', 'Review frontend code', 'In Progress', '2024-10-02'),
    (11, 'Task 11', 'Prepare marketing materials', 'Pending', '2024-10-09'),
    (12, 'Task 12', 'Set up cloud infrastructure', 'Completed', '2024-09-18'),
    (13, 'Task 13', 'Integrate third-party API', 'In Progress', '2024-10-04'),
    (14, 'Task 14', 'Fix UI bugs in dashboard', 'Pending', '2024-10-11'),
    (15, 'Task 15', 'Update user guide', 'Completed', '2024-09-27'),
    (16, 'Task 16', 'Analyze user feedback', 'Pending', '2024-10-03'),
    (17, 'Task 17', 'Prepare for client meeting', 'In Progress', '2024-10-07'),
    (18, 'Task 18', 'Backup database', 'Pending', '2024-10-14'),
    (19, 'Task 19', 'Refactor legacy code', 'Completed', '2024-09-22'),
    (20, 'Task 20', 'Improve app security', 'Pending', '2024-10-15');
