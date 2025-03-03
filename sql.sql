CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL,
    khmer_name VARCHAR(255) NOT NULL,
    latin_name VARCHAR(255) NOT NULL,
    father_name VARCHAR(255) NOT NULL,
    mother_name VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    place_of_birth VARCHAR(255) NOT NULL,
    original_email VARCHAR(255) DEFAULT NULL,  -- Nullable email field
    school_email VARCHAR(255) NOT NULL,  -- Nullable email field
    phone_number VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile VARCHAR(255) NOT NULL,
    major VARCHAR(255) NOT NULL
);

