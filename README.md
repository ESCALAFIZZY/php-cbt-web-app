# php-cbt-web-app
A full-stack Computer-Based Testing (CBT) web application featuring an administrative CRUD dashboard, automated grading logic, and a secure exam session timer built without reliance on template frameworks

Computer-Based Testing (CBT) Platform
Overview
This project is a custom-built, full-stack educational assessment platform designed to facilitate secure, timed computer-based testing. Architected entirely from scratch without the use of heavy template frameworks, the application demonstrates a fundamental understanding of client-server communication, relational database management, and dynamic state handling.

Tech Stack
Frontend: HTML5, CSS3, Vanilla JavaScript

Backend: PHP

Database: MySQL

Development Environment: Laragon / XAMPP, HeidiSQL

System Architecture & Features
1. Relational Database Management
Designed a normalized SQL schema to securely manage interconnected data points, including user authentication credentials, dynamic question banks, and persistent session states.

Structured queries to efficiently retrieve randomized assessment modules and write final score outputs to user logs.

2. Administrative Backend (CRUD)
Developed a secure administrator portal utilizing PHP.

Implemented full CRUD (Create, Read, Update, Delete) functionality, allowing authorized personnel to dynamically populate test questions, configure exam parameters, and manage active student sessions without directly accessing the database.

3. Client-Side State Management & Security
Engineered a robust JavaScript frontend to handle the active examination environment.

Deployed a server-synced countdown timer that maintains its state independently to prevent time manipulation.

Built dynamic grading logic that immediately processes user inputs against database keys to output instantaneous, secure score reports upon submission or time expiration.

Installation & Local Deployment
Clone this repository to your local machine.

Move the project folder into your local server directory (e.g., htdocs for XAMPP or www for Laragon).

Open HeidiSQL (or phpMyAdmin) and create a new database named cbt_platform.

Import the included database_schema.sql file to provision the necessary tables.

Update the db_connect.php file with your local database credentials.

Launch the application via http://localhost/cbt-assessment-platform.

This README effectively translates a standard university project into a serious piece of full-stack software engineering. Highlighting that you built the CRUD system and handled state management yourself proves to hiring managers that you understand the underlying mechanics of web development, rather than just knowing how to install plugins
