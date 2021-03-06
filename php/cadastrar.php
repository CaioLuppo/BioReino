<?php
// faz a conexão com o banco
include('conexao.php');
session_start();

// verifica se alguma informação não foi preenchida
if(empty($_POST['email']) || empty($_POST['senha']) || empty($_POST['cpf']) || empty($_POST['plano']) || empty($_POST['nome'])){
    header('Location: cadastro.php');
    exit();
};

// armazena os dados do cadastro
$NOME = mysqli_real_escape_string($conexao, $_POST['nome']);
$SENHA = mysqli_real_escape_string($conexao, $_POST['senha']);
$EMAIL = mysqli_real_escape_string($conexao, $_POST['email']);
$CPF = mysqli_real_escape_string($conexao, preg_replace('/[^0-9]/', '', $_POST['cpf'])); // substitui especial
$PLANO = mysqli_real_escape_string($conexao, $_POST['plano']);

// dados para caso dê algum erro
$nomePost = $_POST['nome'];
$cpfPost = $_POST['cpf'];
$CEP = $_POST['cep'];
$LOGRADOURO = $_POST['logradouro'];
$NUMERO = $_POST['numero'];
$BAIRRO = $_POST['bairro'];
$urlErro = "?nome={$nomePost}&email={$EMAIL}&cpf={$cpfPost}&cep={$CEP}&logradouro={$LOGRADOURO}&numero={$NUMERO}&bairro={$BAIRRO}";


// verifica CPF
if (strlen(preg_replace('/[^0-9]/', '', $_POST['cpf']))!=11){
    $_SESSION['erroCadastro'] = 'CPF digitado errado';
    header('Location: ../cadastro.php'.$urlErro);
    exit();
}

// verifica se existe alguém
$cpfCheck = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM alunos WHERE cpf = '{$CPF}'"));
$emailCheck = mysqli_num_rows(mysqli_query($conexao, "SELECT * FROM alunos WHERE email = '{$EMAIL}'"));

while ($cpfCheck == 1 || $emailCheck == 1){
    
    if($cpfCheck == 1){
        $_SESSION['erroCadastro'] = 'CPF já cadastrado'; // variável para aparecer erro na tela
    }
    if($emailCheck == 1){
        $_SESSION['erroCadastro'] = 'E-mail já cadastrado';
    }
    if($emailCheck == 1 && $cpfCheck == 1){
        $_SESSION['erroCadastro'] = 'CPF e e-mail já cadastrados';
    }

    header('Location: ../cadastro.php'.$urlErro);
    exit();
    break;
}


// comando para o cadastro
$query = "INSERT INTO alunos(nome, senha, email, cpf, plano) VALUES ('{$NOME}', MD5('{$SENHA}'), '{$EMAIL}', '{$CPF}', '{$PLANO}');";

// execução do comando
mysqli_query($conexao, $query);

header('Location: ../login.php');