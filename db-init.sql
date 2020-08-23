DROP TABLE UserTable;
DROP TABLE TaskList;
CREATE TABLE UserTable (
    userName VARCHAR2(7),
    toDo_Id int,
    PRIMARY KEY (userName),

);

CREATE TABLE TaskList(
    task_Name VARCHAR2(50),
    task_Details VARCHAr2(150),
    toDo_Id int,
    FOREIGN KEY (toDo_Id) REFRENCES UserTable(toDo_Id);

INSERT INTO UserTable VALUES ('jhon1',1);
INSERT INTO UserTable VALUES ('pheboe1',2);



INSERT INTO TaskList VALUES ('Meeting','Got a meeting somewhere', 2);
INSERT INTO TaskList VALUES ('swimming','Stay healthy',1);


