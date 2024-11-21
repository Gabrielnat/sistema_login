<?php
// codigo para receber as informacoes do html e fazer algo
//captura oq o usuario digitou e cadastra no bd

//chama arquivo de conexao
include 'conexao.php';

//verifica se existe alguma informacao chegando pela rede
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //recebe o e-mail,filtra e armazena dna variavel
    $email = htmlspecialchars($_POST['email']);

    //recebe a senha,criptografa e armazena em uma variavel
    $senha = password_hash($_POST['senha'],PASSWORD_DEFAULT);

    //exibe a variavel para testar
    //var_dump($senha);

    //bloco tente para cadastrar no banco de dados
    try{
        //prepara o comando sql para inserir no banco de dados
        //utilizar o prepared para previnir injetar sql
        $stmt = $conn->prepare("INSERT INTO usuarios (email,senha) values (:email, :senha)");

        //associa os valores das variaveis :email e :senha
        $stmt->bindParam(":email",$email);// vincula o e-mail e limpa
        $stmt->bindParam(":senha",$senha);

        //executa o codigo
        $stmt->execute();

        echo "cadastro com sucesso";
    }catch(PDOException $e){
        echo "Erro ao cadstrar o usuario : ".$e->getMessage();
    }
}