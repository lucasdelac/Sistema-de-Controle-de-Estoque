<?php // Início do script PHP
// editar.php - Script responsável por editar um item do estoque

// Dados de conexão com o banco de dados

$host = "localhost";  // Endereço do servidor MySQL (geralmente 'localhost' para XAMPP)
$username = "root";   // Nome de usuário padrão do MySQL no XAMPP
$password = "";       // Senha do MySQL (em XAMPP, normalmente é vazia)
$dbname = "formulario"; // Nome do banco de dados que será utilizado

//Conexão com o banco de dados
$conn = mysqli_connect($host, $username, $password, $dbname);

// Verificando a conexão
if (!$conn) {
    // Encerra o script e mostra uma mensagem de erro se a conexão falhar
    die("Falha na conexão: " . mysqli_connect_error());
}

// Verifica se o parâmetro 'id' foi passado pela URL (método GET)
if (isset($_GET['id'])) {
    // Armazena o ID recebido pela URL na variável $id
    $id = $_GET['id'];

    // Prepara uma query SQL para selecionar o produto com base no ID
    $stmt = $conn->prepare("SELECT * FROM itens WHERE id = ?");
    
    // Associa o valor do ID ao parâmetro da query (i = inteiro)
    $stmt->bind_param("i", $id);
    
    // Executa a query
    $stmt->execute();
    
    // Obtém o resultado da query
    $resultado = $stmt->get_result();

    // Verifica se algum registro foi encontrado
    if ($resultado->num_rows > 0) {
        // Transforma o resultado em um array associativo e armazena em $produto
        $item = $resultado->fetch_assoc();
    } else {
        // Caso nenhum produto seja encontrado, exibe uma mensagem
        echo "Item não encontrado!";
        // Encerra o script imediatamente
        exit;
    }
} else {
    // Caso nenhum ID tenha sido passado via GET, exibe mensagem de erro
    echo "ID não especificado!";
    // Encerra o script
    exit;
}

// Verifica se o formulário foi enviado (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe o valor do campo 'nome' do formulário e armazena na variável $nome
    $nome = $_POST['nome'];
    
    // Recebe o valor do campo 'codigo' do formulário
    $codigo = $_POST['codigo'];
    
    // Recebe o valor do campo 'tipo' do formulário
    $tipo = $_POST['tipo'];
    
    // Recebe o valor do campo 'quantidade' do formulário
    $quantidade = $_POST['quantidade'];
    
    // Recebe a data de entrada informada no formulário
    $data_entrada = $_POST['data_entrada'];
    
    // Verifica se o campo 'data_saida' foi preenchido
    // Se sim, armazena o valor; senão, define como null
    $data_saida = !empty($_POST['data_saida']) ? $_POST['data_saida'] : null;

    // Prepara uma query SQL para atualizar os dados do produto com os novos valores
    $update = $conn->prepare("UPDATE itens SET nome=?, codigo=?, tipo=?, quantidade=?, data_entrada=?, data_saida=? WHERE id=?");
    
    // Associa os valores recebidos do formulário aos parâmetros da query
    $update->bind_param("sssissi", $nome, $codigo, $tipo, $quantidade, $data_entrada, $data_saida, $id);

    // Executa a query de atualização
    if ($update->execute()) {
        // Se a inserção for bem-sucedida, redireciona para a página de listagem
        header("Location: listar_produtos.php");
    } else {
        // Caso ocorra algum erro, exibe a mensagem de erro retornada
        echo "Erro ao atualizar: " . $update->error;
    }

    // Encerra a instrução preparada
    $update->close();
    
    // Encerra o script após atualizar o produto
    exit;
} // Fim do bloco POST
?> <!-- Fim do bloco PHP -->

<!DOCTYPE html> <!-- Declaração do tipo de documento HTML -->
<html lang="pt-br"> <!-- Início do elemento HTML com idioma definido para português do Brasil -->
<head> <!-- Início do cabeçalho da página -->
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres como UTF-8 -->
    <link rel="stylesheet" href="css/style.css">
    <title>Editar Produto</title> <!-- Título da aba do navegador -->
</head> <!-- Fim do cabeçalho -->
<body> <!-- Início do corpo da página -->
    
    <div class="container">
    <h1>Editar Produto</h1> <!-- Título principal da página -->

    <!-- Início do formulário HTML que envia dados via método POST -->
    <form method="POST">

        <!-- Campo de texto para o nome do produto -->
        <label>Nome:</label> <!-- Rótulo do campo -->
        <input type="text" name="nome" value="<?= $item['nome'] ?>" required><br> <!-- Input preenchido com o valor atual -->

        <!-- Campo de texto para o código do produto -->
        <label>Código:</label>
        <input type="text" name="codigo" value="<?= $item['codigo'] ?>" required><br>

        <!-- Campo de texto para o tipo do produto -->
        <label>Tipo:</label>
        <input type="text" name="tipo" value="<?= $item['tipo'] ?>" required><br>

        <!-- Campo numérico para a quantidade do produto -->
        <label>Quantidade:</label>
        <input type="number" name="quantidade" value="<?= $item['quantidade'] ?>" required><br>

        <!-- Campo de data para a data de entrada do produto -->
        <label>Data de Entrada:</label>
        <input type="date" name="data_entrada" value="<?= $item['data_entrada'] ?>" required><br>

        <!-- Campo de data para a data de saída do produto -->
        <label>Data de Saída:</label>
        <input type="date" name="data_saida" value="<?= $item['data_saida'] ?>"><br><br>

        <!-- Botão de envio do formulário -->
        <input id="atualizar" type="submit" value="Atualizar">

    </form> <!-- Fim do formulário -->
    </div>

</body> <!-- Fim do corpo da página -->
</html> <!-- Fim do documento HTML -->