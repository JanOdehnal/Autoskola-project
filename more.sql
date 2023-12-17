use aut_project;

desc lector;
alter table lector drop column surename;
alter table lector add surname varchar(45) NULL;
alter table lector modify phone_number varchar(12) NULL;
alter table student modify phone_number varchar(12) NULL;
select * from lector;
select * from student;
desc student;