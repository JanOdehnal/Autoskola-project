insert into course(vehicle_type, num_of_less) values ('Manual car', 28);
insert into course(vehicle_type, num_of_less) values ('Automatic car', 28);
delete from lector where id=2;
delete from course where id=4;
delete from student where id=7;
delete from student_course_lec where student_id = 7;
-- alter table course modify vehicle_type varchar(45) null unique;
select * from lector;
select * from course;
select * from student;
select * from student_course_lec;
use drive_sch_db;
UPDATE student SET password = "1234" where email = 'adam@deb';
UPDATE lector SET verify_lector = "1234" where email = 'jan@pako';
UPDATE student SET verify_student = "1234" where email = 'jan@blb';

delete from course where id = 3;
