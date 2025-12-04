CREATE DATABASE IF NOT EXISTS trading_journal;
USE trading_journal;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE setups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    strategy TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    setup_id INT NOT NULL,
    symbol VARCHAR(20) NOT NULL,
    direction ENUM('long', 'short') NOT NULL,
    entry_price DECIMAL(15, 5) NOT NULL,
    stop_loss DECIMAL(15, 5) NOT NULL,
    take_profit DECIMAL(15, 5) NOT NULL,
    position_size DECIMAL(15, 5) NOT NULL,
    notes TEXT,
    status ENUM('pending', 'executed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (setup_id) REFERENCES setups(id) ON DELETE CASCADE
);

CREATE TABLE positions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan_id INT NOT NULL,
    symbol VARCHAR(20) NOT NULL,
    direction ENUM('long', 'short') NOT NULL,
    entry_price DECIMAL(15, 5) NOT NULL,
    current_size DECIMAL(15, 5) NOT NULL,
    original_size DECIMAL(15, 5) NOT NULL,
    stop_loss DECIMAL(15, 5) NOT NULL,
    take_profit DECIMAL(15, 5) NOT NULL,
    status ENUM('open', 'closed') DEFAULT 'open',
    realized_pnl DECIMAL(15, 2) DEFAULT 0,
    opened_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    closed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES plans(id) ON DELETE CASCADE
);

CREATE TABLE journal_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    position_id INT NOT NULL,
    action_type ENUM('open', 'partial_close', 'full_close') NOT NULL,
    size DECIMAL(15, 5) NOT NULL,
    price DECIMAL(15, 5) NOT NULL,
    pnl DECIMAL(15, 2) DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (position_id) REFERENCES positions(id) ON DELETE CASCADE
);