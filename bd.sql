ALTER TABLE content_type
MODIFY COLUMN id INT AUTO_INCREMENT;

INSERT INTO content_type (name, class_name)
VALUES ("Картинка", "photo"), ("Видео", "video"), 
("Текст", "text"), ("Цитата", "quote"),
("Ссылка", "link");


SET FOREIGN_KEY_CHECKS = 0;

SET FOREIGN_KEY_CHECKS = 1;