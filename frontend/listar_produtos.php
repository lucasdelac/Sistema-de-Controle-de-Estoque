<?php
// Define o nome do host do banco de dados
$host = "localhost";
// Define o nome de usuário para acesso ao banco de dados
$username = "root";
// Define a senha do banco de dados (vazia neste caso)
$password = "";
// Define o nome do banco de dados que será usado
$dbname = "formulario";

// Cria uma conexão com o banco de dados usando os dados fornecidos
$conn = mysqli_connect($host, $username, $password, $dbname);

// Verifica se a conexão falhou
if (!$conn) {
    // Encerra o script e mostra uma mensagem de erro, se a conexão falhar
    die("Falha na conexão: " . mysqli_connect_error());
}

// Cria uma consulta SQL para selecionar todos os registros da tabela "itens"
$sql = "SELECT * FROM itens";
// Executa a consulta no banco de dados e armazena o resultado na variável $resultado
$resultado = $conn->query($sql);
?>

<!DOCTYPE html> <!-- Define o tipo do documento HTML -->
<html lang="pt-br"> <!-- Início do documento HTML com idioma definido como português do Brasil -->
<head> <!-- Início do cabeçalho da página -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Define a visualização para dispositivos móveis -->
    <link rel="stylesheet" href="css/listar_produtos.css"> <!--Link de folha de estilos-->
    <title>Document</title> <!-- Título que aparece na aba do navegador -->
</head> <!-- Fim do cabeçalho -->
<body> <!-- Início do corpo da página -->

    <header> <!-- Início do cabeçalho da página -->
        <nav> <!-- Barra de navegação -->
            <a href="index.html">Inicio</a> | <!-- Link para o inicio do sistema -->
            <a href="cadastro.html">Cadastrar Itens</a> |  <!-- Link para cadastrar -->
            <a href="listar_produtos.php">Listar Itens</a> |  <!-- Link para listar -->
            <a href="login.html">Login</a>  <!-- Link para login -->
        </nav>
    </header> <!-- Fim do cabeçalho -->

    <h1>Lista de Itens</h1> <!-- Título principal da página -->

    <?php
        // Verifica se o resultado da consulta contém linhas
        if($resultado->num_rows > 0){
            // Abre uma div com classe para estilo da tabela
            echo '<div class="tabela-exemplo">';
            // Inicia a tabela
            echo "<table>";
            // Cabeçalhos das colunas
            echo "<tr><th>ID</th><th>Nome</th><th>Codigo</th><th>Tipo</th><th>Quantidade</th><th>Data de Entrada</th><th>Data de Saída</th><th>Ações</th></tr>";
            // Loop através de cada linha retornada
            while ($linha = $resultado->fetch_assoc()){
                echo "<tr>"; // Abre nova linha da tabela
                echo "<td>".$linha['id']."</td>"; // Exibe o ID
                echo "<td>".$linha['nome']."</td>"; // Exibe o nome
                echo "<td>".$linha['codigo']."</td>"; // Exibe o código
                echo "<td>".$linha['tipo']."</td>"; // Exibe o tipo
                echo "<td>".$linha['quantidade']."</td>"; // Exibe a quantidade
                echo "<td>".$linha['data_entrada']."</td>"; // Exibe a data de entrada
                echo "<td>".$linha['data_saida']."</td>"; // Exibe a data de saída

                // Cria botões de editar e excluir, passando o ID pela URL
                echo "<td><a class='editar-excluir' href='editar_produto.php?id=".$linha['id']."'>Editar</a>";
                
                echo "</tr>"; // Fecha a linha da tabela
            }
            echo "</table>"; // Fecha a tabela
            echo '</div>'; // Fecha a div
        }else{
            // Caso não existam resultados, mostra mensagem de vazio
            echo "<p>Nenhum produto cadastrado.</p>";
        }

        // Encerra a conexão com o banco de dados
        mysqli_close($conn);
    ?>
</body> <!-- Fim do corpo da página -->
</html> <!-- Fim do documento HTML -->
