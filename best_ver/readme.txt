database name > multimedia_data

CREATE TABLE multimedia_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    about TEXT,
    video VARCHAR(255),
    image VARCHAR(255),
    pdf VARCHAR(255)
);
