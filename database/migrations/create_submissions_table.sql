-- SQL Script to Create the Submissions Table
CREATE TABLE IF NOT EXISTS submissions (
    id BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
    amount INT(10) NOT NULL,
    buyer VARCHAR(255) NOT NULL,
    receipt_id VARCHAR(20) NOT NULL UNIQUE,
    items TEXT NOT NULL,
    buyer_email VARCHAR(50) NOT NULL,
    buyer_ip VARCHAR(20) DEFAULT NULL,
    note TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    hash_key VARCHAR(255) NOT NULL,
    entry_at DATE NOT NULL,
    entry_by INT(10) NOT NULL
);
