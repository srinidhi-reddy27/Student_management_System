# Student_management_System
This is a web-based Student Management System built using PHP, MySQL, HTML, CSS, and JavaScript. The system allows users to register, log in, manage student records (add, update, delete), and upload files. It includes features like user authentication, session management, and a responsive design.
## Features
- User registration and login with password hashing.
- Add, update, and delete student records.
- Upload and download student files (PDF, DOCX).
- Pagination for student records.
- Responsive design with a modern UI.
- Session-based authentication to secure access.
## Prerequisites
- **XAMPP** (or equivalent) with Apache and MySQL installed.
- A web browser (Chrome, Firefox, etc.).
- Basic knowledge of PHP, MySQL, and web development.
# Installation

### Step 1: Download and Setup
1. Clone or download this repository to your local machine.
   ```bash
   git clone https://github.com/your-username/Student-Management-System.git
### Step 2: Start XAMPP
- Open the XAMPP Control Panel.
- Start the Apache and MySQL modules.
- Ensure no port conflicts (default ports are 80 for Apache and 3306 for MySQL).
### Step 3: Access the Project
- Open your web browser and navigate to:
  http://localhost/Student_Management-main/login.html
### Database Setup
- Create the Database:
- Open phpMyAdmin (http://localhost/phpmyadmin).
- Click "New" and create a database named Students_for_Assesment.
- Use the default collation (utf8mb4_general_ci).
- Create Tables:
-Select the Students_for_Assesment database.
- Run the following SQL commands in the SQL tab

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    roll_no VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    file_path VARCHAR(255)
);

### Few output Images
![image](https://github.com/user-attachments/assets/45847def-70a6-48d6-984f-528af0791ed5)
![image](https://github.com/user-attachments/assets/0dc0e3e7-d0bb-40f9-b7e7-bc48aac69864)
![image](https://github.com/user-attachments/assets/f280b77d-695d-420d-9808-f617148abd0c)
![image](https://github.com/user-attachments/assets/14f2bb0e-974b-49d0-82d8-ad584003f8b7)
![image](https://github.com/user-attachments/assets/f7ca5627-0956-48f3-a218-ac1df9d04e1d)




