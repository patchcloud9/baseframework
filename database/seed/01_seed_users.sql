-- Seed Users Table
-- Default password for all users: password123
-- Hash generated with: password_hash('password123', PASSWORD_DEFAULT)

INSERT INTO users (name, email, password, role) VALUES
('Alice Johnson', 'alice@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFVNHMyIBnRaV59bGYWJJYkAqNBaEoW2', 'admin'),
('Bob Smith', 'bob@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFVNHMyIBnRaV59bGYWJJYkAqNBaEoW2', 'user'),
('Carol Williams', 'carol@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFVNHMyIBnRaV59bGYWJJYkAqNBaEoW2', 'user'),
('David Brown', 'david@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFVNHMyIBnRaV59bGYWJJYkAqNBaEoW2', 'user'),
('Eve Davis', 'eve@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFVNHMyIBnRaV59bGYWJJYkAqNBaEoW2', 'admin');
