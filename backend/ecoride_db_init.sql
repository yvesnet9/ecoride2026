-- =====================================
-- EcoRide Database Initialization Script
-- Base : ecoride_db
-- Date : 2025-10-22
-- =====================================

-- Créer la base
DROP DATABASE IF EXISTS ecoride_db;
CREATE DATABASE ecoride_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE ecoride_db;

-- ==============================
-- Table : users
-- ==============================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                    phone VARCHAR(20),
                        role ENUM('driver', 'passenger', 'admin') DEFAULT 'passenger',
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                            );

                            -- ==============================
                            -- Table : vehicles
                            -- ==============================
                            CREATE TABLE vehicles (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                    user_id INT NOT NULL,
                                        brand VARCHAR(50),
                                            model VARCHAR(50),
                                                plate_number VARCHAR(20) UNIQUE,
                                                    seats INT DEFAULT 4,
                                                        color VARCHAR(30),
                                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                                                                );

                                                                -- ==============================
                                                                -- Table : rides
                                                                -- ==============================
                                                                CREATE TABLE rides (
                                                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                                                        driver_id INT NOT NULL,
                                                                            origin VARCHAR(255) NOT NULL,
                                                                                destination VARCHAR(255) NOT NULL,
                                                                                    departure_time DATETIME NOT NULL,
                                                                                        price DECIMAL(10,2) NOT NULL,
                                                                                            available_seats INT DEFAULT 3,
                                                                                                status ENUM('scheduled', 'in_progress', 'completed', 'cancelled') DEFAULT 'scheduled',
                                                                                                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                                                                        FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE
                                                                                                        );

                                                                                                        -- ==============================
                                                                                                        -- Table : bookings
                                                                                                        -- ==============================
                                                                                                        CREATE TABLE bookings (
                                                                                                            id INT AUTO_INCREMENT PRIMARY KEY,
                                                                                                                ride_id INT NOT NULL,
                                                                                                                    passenger_id INT NOT NULL,
                                                                                                                        seats_booked INT DEFAULT 1,
                                                                                                                            status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
                                                                                                                                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                                                                                                    FOREIGN KEY (ride_id) REFERENCES rides(id) ON DELETE CASCADE,
                                                                                                                                        FOREIGN KEY (passenger_id) REFERENCES users(id) ON DELETE CASCADE
                                                                                                                                        );

                                                                                                                                        -- ==============================
                                                                                                                                        -- Table : feedback
                                                                                                                                        -- ==============================
                                                                                                                                        CREATE TABLE feedback (
                                                                                                                                            id INT AUTO_INCREMENT PRIMARY KEY,
                                                                                                                                                ride_id INT NOT NULL,
                                                                                                                                                    reviewer_id INT NOT NULL,
                                                                                                                                                        rating INT CHECK (rating BETWEEN 1 AND 5),
                                                                                                                                                            comment TEXT,
                                                                                                                                                                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                                                                                                                                    FOREIGN KEY (ride_id) REFERENCES rides(id) ON DELETE CASCADE,
                                                                                                                                                                        FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE
                                                                                                                                                                        );

                                                                                                                                                                        -- ==============================
                                                                                                                                                                        -- Insertion d’un compte admin par défaut
                                                                                                                                                                        -- ==============================
                                                                                                                                                                        INSERT INTO users (name, email, password, role)
                                                                                                                                                                        VALUES ('Admin EcoRide', 'admin@ecoride.com', 'admin123', 'admin');
                                                                                                                                                                        
