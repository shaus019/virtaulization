CREATE TABLE todo_list (
    user_id int PRIMARY KEY,
    username varchar(7) UNIQUE NOT NULL
);

CREATE TABLE todo_item (
    task_name varchar(50) PRIMARY KEY,
    task_details varchar(150),
    list_id int,
    
    FOREIGN KEY (list_id) REFERENCES todo_list(user_id)
);

INSERT INTO todo_list(username, user_id) VALUES ('john', 1);
INSERT INTO todo_list(username, user_id)  VALUES ('pheboe1', 2);



INSERT INTO todo_item(task_name, task_details, list_id) VALUES ('Meeting','Got a meeting somewhere', 1);
INSERT INTO todo_item(task_name, task_details, list_id) VALUES ('swimming','Stay healthy', 2);