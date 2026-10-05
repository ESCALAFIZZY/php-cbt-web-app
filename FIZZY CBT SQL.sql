USE cbt_app;

CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option CHAR(1) NOT NULL
);

-- Insert a test question
INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_option) 
VALUES ('What does HTML stand for?', 'Hyper Text Preprocessor', 'Hyper Text Markup Language', 'Hyper Terminal Motor Language', 'High Text Markup', 'B');