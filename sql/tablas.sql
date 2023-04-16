CREATE TABLE users(
id int auto_increment primary key,
nombre varchar(20) not null,
apellidos varchar(40) not null,
email varchar(45) unique not null,
is_admin enum('SI', 'NO'),
sueldo float(6,2)
);

insert into users(nombre, apellidos, email, is_admin, sueldo) values("Manolo", 'Garcia Torres', 'usuario1@gmail.com', 'SI', '1500');
insert into users(nombre, apellidos, email, is_admin, sueldo) values("Paula", 'Moreno Tijeras', 'usuario2@gmail.com', 'SI', '1500');
insert into users(nombre, apellidos, email, is_admin, sueldo) values("Laura", 'Ruiz Fernandez', 'usuario3@gmail.com', 'NO', '1200');
insert into users(nombre, apellidos, email, is_admin, sueldo) values("Juan", 'Redondo Alvarez', 'usuario4@gmail.com', 'NO', '1100');
insert into users(nombre, apellidos, email, is_admin, sueldo) values("Sebastian", 'Moreno Lechuga', 'usuario5@gmail.com', 'NO', '1000');