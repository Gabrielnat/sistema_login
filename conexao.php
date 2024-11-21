<?php

/*
    conexao com bd usando pdo : pdo permite acessar qualquer banco de dados
    pdo = php data obejects = php objetivo de dados
*/
// declara as variaveis com os dados de conexao
$host = 'localhost';
$dbname = 't57_login';
$usuario= 'root';
$senha = '';

// data source name = nome da origem dos dados
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try{
    // criar a conexao
    $conn = new PDO($dsn,$usuario,$senha);

    $conn->setAttribute(PDO ::ATTR_ERRMODE,PDO ::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO ::ATTR_DEFAULT_FETCH_MODE,PDO ::FETCH_ASSOC);
}catch(PDOException $e){
    die("erro de conexao".$e->getMessage());
}