<?php
$c = mysql_connect('localhost', 'foxx', 'cw3651');
mysql_select_db('foxx_emp');
mysql_query("DROP TABLE IF EXISTS periods;");
mysql_query("DROP TABLE IF EXISTS types;");
mysql_query("DROP TABLE IF EXISTS payroll;");
mysql_query("DROP TABLE IF EXISTS stores;");
mysql_query("DROP TABLE IF EXISTS employees;");
mysql_query("DROP TABLE IF EXISTS hourly;");
mysql_query("DROP TABLE IF EXISTS salary;");
mysql_query("DROP TABLE IF EXISTS users;");
mysql_query("DROP TABLE IF EXISTS login_logs");

mysql_query("CREATE TABLE users (user_id INTEGER PRIMARY KEY AUTO_INCREMENT, username text, password text);");
mysql_query("INSERT INTO users VALUES (null, 'teddy', 	'97703e5ad8c86a28c3b1c3d7bf5d3d9a4f6f60b6');");
mysql_query("INSERT INTO users VALUES (null, 'park', 	'97703e5ad8c86a28c3b1c3d7bf5d3d9a4f6f60b6');");
mysql_query("INSERT INTO users VALUES (null, 'foxx', 	'97703e5ad8c86a28c3b1c3d7bf5d3d9a4f6f60b6');");

mysql_query("CREATE TABLE logs (log_id INTEGER PRIMARY KEY AUTO_INCREMENT, user_id INTEGER REFERENCES users(user_id), action INTEGER, login_time DATETIME);");

mysql_query("CREATE TABLE periods (period_id INTEGER PRIMARY KEY AUTO_INCREMENT, period_date DATE);");

mysql_query("CREATE TABLE types (type_id INTEGER PRIMARY KEY AUTO_INCREMENT, type_name TEXT);");
mysql_query("INSERT INTO types VALUES (0, 'INACTIVE_2');");
mysql_query("INSERT INTO types VALUES (null, 'INACTIVE');");
mysql_query("INSERT INTO types VALUES (null, 'SALARY');");
mysql_query("INSERT INTO types VALUES (null, 'HOURLY');");

mysql_query("CREATE TABLE hourly (hourly_id INTEGER PRIMARY KEY AUTO_INCREMENT, emp_id INTEGER REFERENCES employees(emp_id), reg REAL, overtime REAL, overrate REAL, overtype INTEGER, gross_pay REAL, total_tax REAL, total_ded REAL, other_ded REAL, net_pay REAL, period_id INTEGER REFERENCES periods(period_id), note TEXT);");

mysql_query("CREATE TABLE salary (salary_id INTEGER PRIMARY KEY AUTO_INCREMENT, emp_id INTEGER REFERENCES employees(emp_id), salary REAL, bonus REAL, gross_pay REAL, total_tax REAL, total_ded REAL, other_ded REAL, net_pay REAL, period_id INTEGER REFERENCES periods(period_id), note TEXT);");

mysql_query("CREATE TABLE stores (store_id INTEGER PRIMARY KEY AUTO_INCREMENT, store_name TEXT);");
mysql_query("INSERT INTO stores VALUES(null, 'Foxx Corp.');");
mysql_query("INSERT INTO stores VALUES(null, 'Hair World');");
mysql_query("INSERT INTO stores VALUES(null, 'Foxx Beauty');");

mysql_query("CREATE TABLE employees (emp_id INTEGER PRIMARY KEY AUTO_INCREMENT, emp_name TEXT, type_id INTEGER REFERENCES types(type_id), store_id INTEGER REFERENCES stores(store_id), wage REAL, tax_status INTEGER, fed_allowance INTEGER, state_tax REAL, ss_tax REAL, med_tax REAL, fed_tax REAL, ins_ded REAL, other_ded REAL);");

mysql_query("INSERT INTO employees VALUES (null, 'Chang Park', 				3, 1, 0, 1, 4, 0, 0, 6.25, 1.4, 0, 0);");
mysql_query("INSERT INTO employees VALUES (null, 'Kyung Kim', 				3, 1, 0, 1, 4, 0, 0, 6.25, 1.4, 0, 0);");
mysql_query("INSERT INTO employees VALUES (null, 'Teddy Park',				3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0);");
mysql_query("INSERT INTO employees VALUES (null, 'Choon Hwan Kim', 			3, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0);");
mysql_query("INSERT INTO employees VALUES (null, 'Sook Kim', 				3, 2, 0, 0,0,0,0,0,0,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Soo Hyung Kim',			3, 2, 7.5,0,0,0,0,0,0,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Jaechang Hong',			4, 3, 6.5,0,0,0,0,0,0,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Carraway Nana Parish',	4, 2, 9,1,4,0,0,6.25,1.4,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Sheree Holmes',			2, 2, 8,1,4,0,0,6.25,1.4,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Mischelle Thomas',		4, 3, 8,1,4,0,0,6.25,1.4,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Veronica Silva',			4, 3, 7.5,1,4,0,0,6.25,1.4,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Carol',					4, 2, 6.5,1,0,0,0,0,0,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Rakeisha Mcdaniel',		4, 2, 10,0,0,0,0,0,0,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Shann Harden',			4, 3, 10,0,0,0,0,0,0,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Paula Courtemanche',		4, 3, 8,0,0,0,0,0,0,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Kisha Tatum',				4, 3, 9,0,0,0,0,0,0,0,0);");
mysql_query("INSERT INTO employees VALUES (null, 'Alcia',					4, 2, 6.5,0,0,0,0,0,0,0,0);");
echo "SUCCESS";
?>