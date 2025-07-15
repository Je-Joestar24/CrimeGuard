# CrimeGuard: Crime Mapping and Incident Management System

[Project Repository](https://github.com/Je-Joestar24/CG-Lmix)

CrimeGuard is a Single Page Application (SPA) designed to modernize the process of crime reporting and monitoring. It empowers law enforcement and civilians with tools for real-time incident reporting, heatmap visualization, predictive analytics, and streamlined coordination across police stations. Built with Laravel and Vue.js, the system follows the MVC and DTO architecture for efficient and secure data handling.

---

## Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [Architecture](#architecture)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Contributing](#contributing)
- [License](#license)
- [Credits](#credits)

---

## Project Overview

CrimeGuard bridges the gap between citizens and police through a centralized crime reporting and analysis platform. Users can report incidents by pinpointing locations via Google Maps, which are then automatically routed to the nearest police station. Police can monitor real-time reports, track active users and officers on the map, and analyze crime trends with dynamic graphs.

---

## Features

- **Centralized Crime Reporting**: Citizens and officers submit incident reports to a unified system.
- **Google Maps Integration**: Report exact crime locations through interactive map.
- **Real-Time Notifications**: Officers receive immediate alerts when a new report is filed.
- **Heatmap and Monitoring Map**: Visualizes active and historical crimes.
- **Report Assignment**: Incidents are automatically routed to the nearest police station.
- **Incident & User Tracking**: Police can track active reporters and their fellow officers on the map.
- **Predictive Analytics**: View monthly and seasonal crime trends.
- **Dashboard Analytics**: Charts and graphs for tracking crime frequency, victim/suspect demographics, and location-based data.
- **Account Registration & Approval**: Only verified users (via valid ID) can report.
- **Role-Based Access**: Admin, Officer, and Citizen dashboards with unique features.
- **Activity Logs & Archives**: Full access logs and archive system for admin auditing.
- **Secure REST API**: Built using DTOs and Laravel Sanctum for authentication.

---

## Architecture

### SPA (Single Page Application)
- Built with Vue 3 for a smooth, reload-free user experience.

### MVC (Model-View-Controller)
- Laravel is used to enforce the separation of backend logic (Models), data handling (Controllers), and API endpoints (Views for SPA).

### DTO (Data Transfer Object)
- Every data exchange between frontend and backend uses DTOs to ensure efficiency and data security.

---

## Technology Stack

- **Backend**: Laravel 10, PHP 8.1+, MySQL, Laravel Sanctum
- **Frontend**: Vue 3, Tailwind CSS, Vue Router, Axios, V-Motion
- **Analytics & Visualization**: Highcharts
- **Maps & Location**: Google Maps API
- **Face Verification** *(optional)*: Face++ API
- **Local Testing**: XAMPP
- **Version Control**: Git & GitHub

---

## Project Structure

```

/app
/Http
/Controllers
/Requests
/Middleware
/Models
/resources
/js
/components
/maps
/Analytics
/public
/build
/routes
api.php
web.php

````

---

## Installation

### Requirements

- PHP 8.1+
- Composer
- Node.js & npm
- MySQL

### Steps

```bash
git clone https://github.com/Je-Joestar24/CG-Lmix.git
cd CG-Lmix
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
````

---

## Usage

* Launch: [http://localhost:8000](http://localhost:8000)
* Citizens: Register with valid ID → wait for approval → report incidents
* Officers: Monitor map → receive reports → respond
* Admin: Manage users, analytics, logs, and reports

---

## API Endpoints (Examples)

* `POST /api/login`
* `POST /api/incidents/heat/map/marker/Display`
* `POST /api/incidentNames/search/Display`
* `POST /api/citizenusers/add/item/request`
* `POST /api/incident/create/request`
* `GET  /api/logs/retrieve`
  *(Full list in `/routes/api.php`)*

---

## Contributing

Feel free to fork, open issues, or submit PRs. Contributions are welcome.

---

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

## Credits

**Team CrimeGuard – Western Leyte College (CICTE)**

* **Jejomar Parrilla** – Lead Developer / Fullstack (Laravel, Vue.js, Tailwind CSS)
* **Dante Villalon** – Data Analyst / Project Manager
* **Sammer Sanchez** – UX/UI Designer
* **Engr. \[Adviser Name]** – Thesis Adviser, CICTE

---

> *CrimeGuard is a capstone project developed for community safety and research purposes in Ormoc City.*