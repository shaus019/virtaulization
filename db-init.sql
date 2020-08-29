/* Basic small table to hold tasks
    ID - incremental unique integer
    task - task name UNIQUE
*/

CREATE TABLE todo_list (
    id int PRIMARY KEY AUTO_INCREMENT,
    task varchar(255) UNIQUE NOT NULL
);