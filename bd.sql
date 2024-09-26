create database evaluacion;
use evaluacion;
CREATE TABLE departments(
	idDepartment int PRIMARY key AUTO_INCREMENT,
    descrip varchar(25)
);
CREATE TABLE roles(
	idRol int PRIMARY key AUTO_INCREMENT,
    descrip varchar(25)
);
create table employees(
    idEmployee int PRIMARY KEY AUTO_INCREMENT,
    nombre varchar(25),
    apellido varchar(25),
    correo varchar(50),
    puesto varchar(25),
    salario decimal(11,2),
    fechaCont date,
    idRolFK int,
    idDepartmentFK int,
    FOREIGN KEY (idRolFK) REFERENCES roles(idRol)
    FOREIGN KEY (idDepartmentFK) REFERENCES departments(idDepartment)
);

-- ##///////////////////////////Regitros para departments
use evaluacion;
INSERT INTO departments (descrip) VALUES
('Recursos Humanos'),
('Finanzas'),
('IT'),
('Marketing'),
('Ventas');

-- ##///////////////////////////Regitros para Roles
use evaluacion;
INSERT INTO roles (descrip) VALUES
('Gerente'),
('Analista'),
('Desarrollador'),
('Soporte Técnico'),
('Vendedor');

-- ##///////////////////////////Regitros para empleados
use evaluacion;
INSERT INTO employees (nombre, apellido, correo, puesto, salario, fechaCont, idRolFK, idDepartmentFK) VALUES
('Juan', 'Pérez', 'juan.perez@example.com', 'Gerente', 75000.00, '2022-01-15', 1, 1),
('Ana', 'García', 'ana.garcia@example.com', 'Analista', 55000.00, '2021-03-22', 2, 2),
('Carlos', 'López', 'carlos.lopez@example.com', 'Desarrollador', 60000.00, '2020-07-30', 3, 3),
('María', 'Rodríguez', 'maria.rodriguez@example.com', 'Soporte Técnico', 45000.00, '2019-11-05', 4, 3),
('Luis', 'Martínez', 'luis.martinez@example.com', 'Vendedor', 50000.00, '2023-05-18', 5, 5);

-- ##///////////////////////////Consulta que muesytra la info de los empleados y sus respectivos roles y departamentos:
SELECT 
  e.nombre, 
  e.apellido, 
  e.correo, 
  e.puesto, 
  e.salario, 
  e.fechaCont, 
  r.descrip AS rol_descrip, 
  d.descrip AS department_descrip
FROM 
  employees e
  INNER JOIN roles r ON e.idRolFK = r.idRol
  INNER JOIN departments d ON e.idDepartmentFK = d.idDepartment;



-- ##///////////////////////////Construir una sentencia SQL para mostrar un campo adicional que indique si el salario 
--## del empleado está por encima o por debajo del salario promedio de su departamento.
SELECT 
  e.nombre, 
  e.apellido, 
  e.correo, 
  e.puesto, 
  e.salario, 
  e.fechaCont, 
  r.descrip AS rol_descrip, 
  d.descrip AS department_descrip,
  CASE 
    WHEN e.salario > (SELECT AVG(salario) FROM employees WHERE idDepartmentFK = e.idDepartmentFK) 
      THEN 'sobre el promedio'
    WHEN e.salario < (SELECT AVG(salario) FROM employees WHERE idDepartmentFK = e.idDepartmentFK) 
      THEN 'menos del promedio'
    ELSE 'promedio'
  END AS salary_comparison
FROM 
  employees e
  INNER JOIN roles r ON e.idRolFK = r.idRol
  INNER JOIN departments d ON e.idDepartmentFK = d.idDepartment;


--Vista para las consultas del detalle de empleados:

CREATE VIEW employee_details AS
SELECT 
  e.idEmployee as id,
  e.nombre, 
  e.apellido, 
  e.correo, 
  e.puesto, 
  e.salario, 
  e.fechaCont, 
  r.descrip AS rol_descrip, 
  d.descrip AS department_descrip
FROM 
  employees e
  INNER JOIN roles r ON e.idRolFK = r.idRol
  INNER JOIN departments d ON e.idDepartmentFK = d.idDepartment;


--Vista para las consultas del detalle de empleados: aunque no tenga rol ni departamentos

CREATE VIEW employee_details AS
SELECT 
  e.idEmployee as id,
  e.nombre, 
  e.apellido, 
  e.correo, 
  e.puesto, 
  e.salario, 
  e.fechaCont, 
  r.descrip AS rol_descrip, 
  d.descrip AS department_descrip
FROM 
  employees e
  LEFT JOIN roles r ON e.idRolFK = r.idRol
  LEFT JOIN departments d ON e.idDepartmentFK = d.idDepartment;