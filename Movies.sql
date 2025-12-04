CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    type ENUM('film', 'serie') NOT NULL,
    genre VARCHAR(100) NULL,
    rating INT NULL CHECK (rating >= 1 AND rating <= 5), 
    is_watched BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO movies (title, type, genre, rating, is_watched) VALUES
('Inception', 'film', 'Science-Fiction', 5, TRUE),
('Dune', 'film', 'Science-Fiction', NULL, FALSE),            
('Breaking Bad', 'serie', 'Drame', 5, TRUE),                  
('The Mandalorian', 'serie', 'Science-Fiction', 4, FALSE);    