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
      if ($conn->query("insert ignore into usuarios ( usuario,contra ) value ( '$usuario','$contra' )") === TRUE) {
      return true;
      } else {
      echo "Error en la consulta.Crear usuario: " . $conn->error;
      return false;
      };
}

function comprobarLoginUser($conn,$usuario,$contra)
{
   $resultado=$conn->query("select count(id_usuario) as total from usuarios where usuario= '$usuario' and contra ='$contra'");

   if ($resultado->num_rows > 0) {
      while($fila = $resultado->fetch_assoc()) {
         echo "numero: " . $fila["total"]."<br>";
         if ($fila["total"] >= 1) {
            echo "LOGIN CONFIRMADO";
            return true;
         };
      }
   } else {
      return false;
   }
   
}
//BD
$CreaDB = "create database if not exists lemp";
queryVoid($CreaDB, $conexionMySql);

//Seleccionamos nuestra Base de datos LEMP
$conexionMySql->select_db("lemp");

//Creacion de tablas
$CreaTB1 = "create table if not exists usuarios(
         id_usuario int auto_increment,
         contra varchar(30),
         usuario varchar(35) unique,
         primary key(id_usuario)
         )";
queryVoid($CreaTB1, $conexionMySql);

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

//Creacion de usuarios
try {
   //Dentro de un tryExcept pq a la segunda vez que se ejecute no quiero tener duplicado y
   //Si se intenta volver a introducir el mismo usuario a la BD fallara la insercion
   insertUsuaurios($conexionMySql,"john","12345678");
   insertUsuaurios($conexionMySql,"santiago","1234");
   insertUsuaurios($conexionMySql,"robert","1234");
   insertUsuaurios($conexionMySql,"admin","admin");

} catch (\Throwable $th) {
   echo "Ya existen los usuarios <br>";
}

//if (comprobarLoginUser($conexionMySql,"admin","admin")) {
//   header("Location: http://localhost:3000/../interfaz/inicio.html");
//}

//Recuperar datos con el metodo post
if (isset($_POST['nombre'], $_POST['contra'])) {
   $nombre = $_POST['nombre'];
   $contra = $_POST['contra'];

   if (comprobarLoginUser($conexionMySql,$nombre,$contra)) {
      header("Location: http://localhost:3000/../interfaz/inicio.html");
   }else {
      header("Location: http://localhost:3000/../interfaz/login.html");
   }

   exit(); // salir para evitar enviar más contenido

} else {
   echo "Error: No se recibieron los datos necesarios. Datos recibidos: " .
        (isset($_POST['nombre']) ? $_POST['nombre'] : "Nombre no proporcionado") . " || " .
        (isset($_POST['contra']) ? $_POST['contra'] : "contraseña no proporcionada") . " || " ;


     echo "<pre>";
     print_r($_POST);
     echo "</pre>";
}
