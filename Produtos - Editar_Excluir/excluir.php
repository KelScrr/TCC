<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vitrine";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o valor do ID do produto
    $product_id = $_POST["product-id"];

    // Verifica se o botão de exclusão foi clicado
    if (isset($_POST["delete"])) {
        // Verifica se o ID do produto não está vazio e é um número
        if (!empty($product_id) && is_numeric($product_id)) {
            // Prepara a consulta SQL utilizando uma declaração preparada para a exclusão
            $sql = "DELETE FROM vitrine WHERE id=?";
            $stmt = $conn->prepare($sql);

            // Vincula os parâmetros
            $stmt->bind_param("i", $product_id);

            // Executa a declaração preparada para exclusão
            if ($stmt->execute()) {
                // Redireciona para a página desejada após a exclusão
                header('Location: /tcc%20geral1/Produtos%20-%20Editar_Excluir/');
                exit();
            } else {
                echo "Erro ao excluir o produto: " . $stmt->error;
            }
        } else {
            echo "ID do produto inválido.";
        }

        $stmt->close();
    }

    // Verifica se o botão de edição foi clicado
    elseif (isset($_POST["edit"])) {
        // Recupera os outros valores do formulário
        $product_name = $_POST["product-name"];
        $product_type = $_POST["product-type"];
        $product_price = $_POST["product-price"];
        $product_parcels = $_POST["product-parcels"];
        $product_description = $_POST["product-description"];

        // Monta a consulta SQL apenas com os campos que foram fornecidos
        $sql = "UPDATE vitrine SET ";
        $params = array();

        if (isset($product_name) && $product_name !== "") {
            $sql .= "nome=?, ";
            $params[] = $product_name;
        }

        if (isset($product_type) && $product_type !== "") {
            $sql .= "categoria=?, ";
            $params[] = $product_type;
        }

        if (isset($product_price) && $product_price !== "") {
            $sql .= "preco=?, ";
            $params[] = $product_price;
        }

        if (isset($product_parcels) && $product_parcels !== "") {
            $sql .= "parcelas=?, ";
            $params[] = $product_parcels;
        }

        if (isset($product_description) && $product_description !== "") {
            $sql .= "descricao=?, ";
            $params[] = $product_description;
        }

        // Tratamento da nova imagem (se fornecida)
        if ($_FILES['product-image']['error'] == 0) {
            // Verifica se o diretório de destino para o upload existe, senão cria
            $uploadDir = '../Vitrine/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
        
            // Gera um nome único para o arquivo com base no timestamp e mantém a extensão original
            $uploadFile = $uploadDir . time() . '_' . $_FILES['product-image']['name'];
        
            // Move o arquivo para o diretório de destino
            if (move_uploaded_file($_FILES['product-image']['tmp_name'], $uploadFile)) {
                // Adiciona apenas o nome do arquivo à consulta SQL
                $sql .= "foto=?, ";
                $params[] = pathinfo($uploadFile, PATHINFO_BASENAME); // Obtém o nome do arquivo com a extensão
            } else {
                echo "Erro ao fazer upload da imagem.";
                exit();
            }
        }
        

        // Remove a última vírgula e espaço em branco da consulta SQL
        $sql = rtrim($sql, ', ');

        // Adiciona a cláusula WHERE para o ID do produto
        $sql .= " WHERE id=?";
        $params[] = $product_id;

        // Prepara a consulta SQL utilizando uma declaração preparada para a atualização
        $stmt = $conn->prepare($sql);
         // Vincula os parâmetros
         $types = str_repeat('s', count($params)); // Assume que todos os parâmetros são strings
          $stmt->bind_param($types, ...$params);

          // Executa a declaração preparada para atualização
          if ($stmt->execute()) {
             // Redireciona para a página desejada após a atualização
            header('Location: /tcc%20geral1/Produtos%20-%20Editar_Excluir/');
             exit();
          } else {
              echo "Erro ao editar o produto: " . $stmt->error;
         }

          $stmt->close();
        }
        }

        ?>