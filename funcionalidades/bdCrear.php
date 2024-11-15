<?php



$servername = "localhost";
$username = "root";
$password = "";

$conexionMySql = new mysqli($servername, $username, $password);


// Verificar conexión
if ($conexionMySql->connect_error) {
   die("Error de conexión: " . $conexionMySql->connect_error);
}

function queryVoid($sql, $conn)
{
   if ($conn->query($sql) === TRUE) {
   return true;
   } else {
   echo "Error en la consulta.$sql: " . $conn->error;
   return false;
   };
}
function insertUsuaurios($conn,$usuario,$contra)
{
      if ($conn->query("insert into usuarios ( usuario,contra ) value ( '$usuario','$contra' )") === TRUE) {
      return true;
      } else {
      echo "Error en la consulta.Crear usuario: " . $conn->error;
      return false;
      };
}

//BD
$CreaDB = "create database if not exists lemp";
queryVoid($CreaDB, $conexionMySql);
$conexionMySql->select_db("lemp");

$CreaTB1 = "create table if not exists usuarios(
         id_usuario int auto_increment,
         contra varchar(30),
         usuario varchar(35) unique,
         primary key(id_usuario)
         )";
queryVoid($CreaTB1, $conexionMySql);

insertUsuaurios($conexionMySql,"john","12345678");
insertUsuaurios($conexionMySql,"santiago","1234");
insertUsuaurios($conexionMySql,"robert","1234");
insertUsuaurios($conexionMySql,"admin","admin");


$CreaTB2_clientes = "create table if not exists clientes(
         id_cliente int auto_increment,
         nombre varchar(40),
         empleo varchar(30),
         correo varchar(40),
         numero varchar(10),
         rutaImg varchar(120),
         primary key(id_cliente)
         )";

queryVoid($CreaTB2_clientes, $conexionMySql);

echo"SE creo Clientes";
//$CreaTB2 = "create table if not exists usuarios(
//         contra varchar(30),
//         usuario varchar(35)
//         )";
//queryVoid($CreaTB, $conexionMySql);
