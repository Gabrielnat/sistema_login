<?php
include 'conexao.php';

//verifica se a requisição atual é um POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //limpa o emai e armazena
    $email = htmlspecialchars($_POST['email']);
    $senha = $_POST['senha'];

    try{
        //prepara a instrução sql para execução
        $stmt = $conn->prepare("SELECT id_cliente, senha, nome FROM usuarios where email = :email");
        $stmt->bindParam(':email',$email);
        $stmt->execute();

        //obtem o resultado para trabalhar depois
        $usuario = $stmt->fetch(PDO ::FETCH_ASSOC);

        //verifica se algum usuario foi retomada a consulta
        //se existir usuario
        if($usuario){
            //verifica se a senha fornecida corresponde a senha armazenada
            if(password_verify($senha,$usuario['senha'])){
                //inicia sessão para armazenar informações do usuario
                session_start();
                //regenera o id da sessão para previnir sequestro de sessão
                session_regenerate_id();
                //define configurações seguras para o cookie da sessão
                session_set_cookie_params(['secure'=>true,'httponly'=>true,'samesite'=>'strict']);
                // armazena o id do usuario e o estado de login
                $_SESSION['usuario_id'] = $usuario['id_cliente'];
                $_SESSION['logado'] = true;
                $_SESSION['nome'] = $usuario['nome'];

                //redireciona o usuario para a pagina do painel apos login
                header("location: painel.php");
                exit;
            }else{
                //caso a senha não esteja correta
                echo "senha incorreta";
            }
        }else{
            echo "usuario nao encontrado";
        }
    }catch(PDOException $e){
        echo "erro no login".$e->getMessage();
    }
}