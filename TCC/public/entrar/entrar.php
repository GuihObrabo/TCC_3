<?php
// Inicia a sessão
session_start();

// Conexão com o banco de dados
$conexao = mysqli_connect("localhost", "root", "159159", "tccSA");

// Verifica se houve falha na conexão
if (!$conexao) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Obtém o e-mail e a senha do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta no banco de dados para verificar o usuário
$sql = "SELECT * FROM tb_usuarios WHERE email = '$email' AND senha = '$senha'";
$result = mysqli_query($conexao, $sql);

// Verifica se a consulta retornou algum resultado
if (mysqli_num_rows($result) > 0) {
    // Pega os dados do usuário
    $usuario = mysqli_fetch_assoc($result);

    // Armazena o nome do usuário na sessão
    $_SESSION['nome'] = $usuario['nome'];

    // Alerta de sucesso e redirecionamento para a página inicial
    echo '<script>alert("Login realizado com sucesso!");</script>';
    echo '<meta http-equiv="refresh" content="0; url=../public/layout/layout.html">'; // Página inicial

} else {
    // Se as credenciais estiverem incorretas
    echo '<script>alert("E-mail ou senha incorretos!");</script>';
    echo '<meta http-equiv="refresh" content="0; url=../entrar/entrar.html">';
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
