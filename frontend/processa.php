<?php
// Dados de conexão com o banco de dados

$host = "localhost";  // Endereço do servidor MySQL (geralmente 'localhost' para XAMPP)
$username = "root";   // Nome de usuário padrão do MySQL no XAMPP
$password = "";       // Senha do MySQL (em XAMPP, normalmente é vazia)
$dbname = "formulario"; // Nome do banco de dados que será utilizado

// Criando a conexão com o banco de dados
$conn = mysqli_connect($host, $username, $password, $dbname);

// Verificando a conexão
if (!$conn) {
    // Encerra o script e mostra uma mensagem de erro se a conexão falhar
    die("Falha na conexão: " . mysqli_connect_error());
}

// Verificando se os dados foram enviados via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pega os dados enviados pelo formulário via POST e armazena em variáveis
    $nome = $_POST['nome'];                 // Pega o valor do campo 'nome'
    $codigo = $_POST['codigo'];             // Pega o valor do campo 'codigo'
    $tipo = $_POST['tipo'];                 // Pega o valor do campo 'tipo'
    $quantidade = $_POST['quantidade'];     // Pega o valor do campo 'quantidade'
    $data_entrada = $_POST['data_entrada']; // Pega o valor do campo 'data_entrada'
    $data_saida = $_POST['data_saida'];     // Pega o valor do campo 'data_saida'

    // Cria uma consulta SQL para inserir os dados no banco de dados
    $sql = "INSERT INTO itens (nome, codigo, tipo, quantidade, data_entrada, data_saida) 
            VALUES ('$nome', '$codigo', '$tipo', '$quantidade', '$data_entrada', '$data_saida')";
    
    // Executa a consulta SQL
    if (mysqli_query($conn, $sql)) {
        // Se a inserção for bem-sucedida, redireciona para a página de listagem
        header("Location: listar_produtos.php");
    } else {
        // Se houver erro na inserção, exibe mensagem de erro com detalhes
        echo "Erro ao cadastrar item: " . mysqli_error($conn);
        // Mostra um link para voltar à página de cadastro
        echo "<br><a href='index.html'>Voltar</a>";
    }
}

// Fecha a conexão com o banco de dados após a execução
mysqli_close($conn);
?>

