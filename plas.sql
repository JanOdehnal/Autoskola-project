insert into course(vehicle_type, num_of_less) values ('Manual car', 28);
insert into course(vehicle_type, num_of_less) values ('Automatic car', 28);
insert into student(id) values (0);
delete from lector where id=2;
delete from course where id=4;
delete from student where id=7;
delete from sides where id=2;
delete from timetable where lesson_num = 4;
delete from student_course_lec where student_id = 7;
-- alter table course modify vehicle_type varchar(45) null unique;
alter table student add column verify_pass int null;
select * from lector;
select * from course;
select * from student;
select * from sides;
select * from student_course_lec;
select * from timetable;
select count(id) from lector;
select count(student_id) from timetable where student_id = 1;
use drive_sch_db;
-- alter table student add column status enum('finish', 'start', 'activ') default 'start';
alter table lector drop visibility;
alter table sides add column visibility ENUM('true', 'false');
alter table student add column lesson_num int null;
UPDATE student SET password = "1234" where email = 'adam@deb';
UPDATE lector SET verify_lector = "1234" where email = 'jan@pako';
UPDATE student SET verify_student = "1234" where email = 'ode2@seznam.cz';

insert into lector(name, surname, email, verify_lector, phone_number, possicion, prefer_veh) values ('Jirka', 'Šunka', 'jirka@sunka', '132', '420000111222', 'admin', '2');
delete from course where id = 3;
SELECT * FROM timetable ORDER BY lesson_date, lesson_num;
alter table timetable modify lesson_date date NULL;
desc timetable;
desc lector;
desc student;
desc student_course_lec;
desc course;
desc sides;
alter table sides drop column visible;
alter table sides add column visible enum('true', 'false');
alter table timetable add column finish_lesson enum('true', 'false') null;
insert into student_course_lec(student_id, course_id, lector_id) values(6, 1, 3);
insert into timetable(lesson_date, lesson_num, student_id, sides_id) values ('2024-01-24', 2, 1, 4);
drop table timetable;
insert into student_course_lec(student_id, lector_id, course_id) value (1, 1, 4);
SELECT count(student_id) from timetable where student_id = 6;
SELECT  x.* , y.lector_id from timetable x left join student_course_lec y on x.student_id = y.student_id where x.student_id=6;
SELECT x.* , y.lector_id from timetable x left join student_course_lec y on x.student_id = y.student_id where x.lesson_date > '2024-01-22' and lector_id=1;
SELECT distinct x.* , y.lector_id, z.* from timetable x left join student_course_lec y on x.student_id = y.student_id left join sides z on x.sides_id = z.id where x.lesson_date >= '2024-02-04' and y.lector_id=3 ORDER BY x.lesson_date, x.lesson_num;

SELECT count(student_id) from timetable where lesson_date = '2024-03-02' and student_id =6;
SELECT * from timetable where student_id = 6;


alter table student add column num_veh INT DEFAULT 1;
create 
begin if new.telefon = null then set new.telefon= '000000000'  
end if