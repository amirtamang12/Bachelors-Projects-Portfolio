***

### 2. Software Engineering Final Project (Full-Stack / Docker) README

***

```markdown
# 🛒 Containerized Full-Stack E-Commerce Architecture

![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)
![MySQL](https://img.shields.io/badge/MySQL-Database-blue)
![Docker](https://img.shields.io/badge/Docker-Containerized-2496ED)
![JavaScript](https://img.shields.io/badge/JavaScript-Vanilla-F7DF1E)

A robust, full-stack e-commerce web application engineered for my final year Software Engineering project. This architecture utilizes Docker Compose to ensure seamless, isolated environment replication across development and production servers.

## 📖 Overview

This project was built to demonstrate end-to-end software engineering principles. It features a custom-built PHP backend, a relational MySQL database for inventory and user management, and a dynamic frontend. By containerizing the application with Docker, it completely bypasses local dependency issues, allowing anyone to spin up the entire infrastructure with a single command.

## ✨ Features

*   **Isolated Environments:** Uses Docker containers to separate the web server (Apache/PHP) and the database (MySQL).
*   **Secure Authentication:** User login and registration system with secure session management.
*   **Dynamic Inventory Routing:** Fetches and displays products dynamically from the MySQL database.
*   **Shopping Cart Logic:** Custom implementation of cart sessions and checkout procedures.
*   **Responsive UI:** Frontend designed to work flawlessly across desktop and mobile devices.

## 🛠️ Technologies Used

*   **Backend:** PHP (Vanilla)
*   **Database:** MySQL
*   **Frontend:** HTML5, CSS3, Vanilla JavaScript
*   **DevOps/Infrastructure:** Docker, Docker Compose
*   **Version Control:** Git

## 🚀 Installation & Setup

Because this project is containerized, you do not need to install PHP or MySQL locally. You only need Docker.

### Prerequisites
*   [Docker Desktop](https://www.docker.com/products/docker-desktop) installed and running.

### Steps

1.  **Navigate to the project directory:**
    ```bash
    cd Bachelors-Projects-Portfolio/Software-Engineering-Final-year-Project
    ```

2.  **Spin up the containers:**
    ```bash
    docker-compose up -d --build
    ```

3.  **Access the Application:**
    Open your web browser and navigate to `http://localhost:8000` (or whichever port is defined in the `docker-compose.yml`).

4.  **Shut down the environment:**
    When finished, you can safely spin down the containers without losing database data:
    ```bash
    docker-compose down
    ```
