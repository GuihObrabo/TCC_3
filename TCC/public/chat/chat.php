<?php
// Iniciando a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../cadastro/cadastro.php"); // Redireciona para a página de login se não estiver logado
    exit();
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "159159";
$dbname = "tccsa";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém o nome do usuário logado
$user_id = $_SESSION['user_id'];
$sql = "SELECT nome FROM usuarios WHERE id = '$user_id'";
$result = $conn->query($sql);
$user_name = $result->fetch_assoc()['nome'] ?? 'Usuário';

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHAT CONVERSATION - Roxo e Preto</title>
    <link rel="stylesheet" href="../chat/chat.css">
    <!-- <base href="http://localhost/TCC"> --> <!-- Caso esteja usando xampp, apenas tire o comando de comentário -->
</head>
<body>
    <div class="app-container">
        <!-- Barra lateral com ícones -->
        <div class="sidebar-icons">
            <img src="../imagens/Logos/logo_roxa.png" alt="Logo" id="logo-icon" onclick="goToHomePage()" width="65vw" height="65ch">
            <img src="../imagens/source/casa.png" alt="Home" id="home-icon" onclick="goToHomePage()" width="40vw" height="40ch">
            <img src="../imagens/source/sino.png" alt="Notificações" id="notifications-icon" width="40vw" height="40ch">
            <img src="../imagens/source/perfil.png" alt="Contatos" id="contacts-icon" width="40vw" height="40ch">
            <img src="../imagens/source/mais.png" alt="Adicionar" id="add-icon" width="40vw" height="40ch">
            <img src="../imagens/source/engrenagem.png" alt="Configurações" id="settings-icon" width="40vw" height="40ch">
        </div>

        <div class="sidebar">
            <header>
                <h2>Conversa</h2>
                <button id="add-group" onclick="openAddGroupModal()">+ Adicionar Grupo</button>
            </header>
            <div class="contact-list" id="contact-list">
                <div class="contact" onclick="openChat('CHAT GERAL')">
                    <img src="../imagens/icons/Etec_geral.png" alt="Avatar" class="contact-avatar">
                    CHAT GERAL
                    <div class="options">
                        <span class="dots">...</span> 
                        <div class="dropdown hidden">
                            <button onclick="shareLink('CHAT GERAL')">Compartilhar Link</button>
                            <button onclick="showRoleOptions('CHAT GERAL')">Adicionar Funções</button>
                        </div>
                    </div>
                </div>
                <!-- Mais grupos aparecerão aqui -->
            </div>
        </div>
        <div class="chat-container">
            <div id="chat-header">
                <img id="profile-image" src="../imagens/icons/Etec_geral.png" alt="Imagem do Contato" />
                <h2 id="chat-name">Selecione um contato</h2>
            </div>
        
            <div id="chat-content">
                <!-- Aqui irão as mensagens do chat -->
            </div>
            <div class="mensagem">
        <span class="nome-usuario">Nome do Usuário</span>
        <div class="texto-mensagem">
            Esta é a mensagem enviada pelo usuário.
        </div>
    </div>
    <!-- Adicione mais mensagens conforme necessário -->
</div>
        
            <div class="message-input">
                <img src="../imagens/source/clip.png" alt="Enviar Arquivo" id="clip-icon" onclick="requestFilePermission()" width="40px" height="40px">
                <input type="text" id="message-text" placeholder="Digite uma mensagem...">
                <button onclick="sendMessage()">Enviar</button>
                <img src="../imagens/source/microfone.png" alt="Gravar Áudio" id="mic-icon" onclick="startRecording()" width="40px" height="40px">
                <img src="../imagens/source/microfone.png" alt="Parar Gravação" id="stop-icon" style="display: none;" onclick="stopRecording()" width="40px" height="40px">
            </div>
        </div>  
        <!-- Modal para adicionar grupo -->
        <div id="add-group-modal" class="overlay hidden">
            <div class="overlay-content">
                <h3>Adicionar Novo Grupo</h3>
                <input type="text" id="group-name" placeholder="Nome do grupo" class="rounded-input">
                <input type="number" id="group-members" placeholder="Quantidade de participantes" min="1" class="rounded-input">
                <input type="file" id="group-image" accept="image/*" onchange="previewImage(event)">
                <img id="image-preview" src="" alt="Pré-visualização da imagem" style="display: none; border-radius: 50%; width: 100px; height: 100px;">
                <button onclick="addGroup()" class="rounded-button">Adicionar</button>
                <button onclick="closeAddGroupModal()" class="rounded-button">Fechar</button>
            </div>
        </div>

        <!-- Modal para adicionar função -->
        <div id="overlay-role" class="overlay hidden">
            <div class="overlay-content">
                <h3>Selecione o cargo:</h3>
                <select id="role-selection" class="rounded-input">
                    <option value="Representante">Representante</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Supervisor">Supervisor</option>
                </select>
                <input type="text" id="user-id" placeholder="Digite o ID do aluno, servidor ou professor" class="rounded-input">
                <button onclick="addRole()" class="rounded-button">Finalizar</button>
                <button onclick="closeOverlay()" class="rounded-button">Fechar</button>
            </div>
        </div>

        <script src="../chat/chat.js"></script>
    </div>
</body>
</html>
