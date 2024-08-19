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
    // Recupera os valores do formulário
    $id = $_POST["product-id"];
    $foto = $_FILES["product-image"]["name"];
    $preco = $_POST["product-price"];
    $descricao = $_POST["product-description"];
    $nome = $_POST["product-name"];
    $categoria = $_POST["product-type"];
    $parcelas = $_POST["product-parcels"];

    // Move o arquivo de imagem para o diretório desejado
    $uploadDir = "../Vitrine/uploads/"; 
    $uploadPath = $uploadDir . basename($foto);
    move_uploaded_file($_FILES["product-image"]["tmp_name"], $uploadPath);

    // Certifique-se de que a categoria é um valor permitido
    $categoriasPermitidas = ['b', 'v', 'c', 's', 'a', 'sa'];
    if (!in_array($categoria, $categoriasPermitidas)) {
        die("Categoria inválida");
    }

    // Prepara a consulta SQL utilizando uma declaração preparada
    $sql = "INSERT INTO vitrine (foto, preco, descricao, nome, categoria, parcelas) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Vincula os parâmetros
    $stmt->bind_param("sdsssi", $foto, $preco, $descricao, $nome, $categoria, $parcelas);

    // Executa a declaração preparada
    if ($stmt->execute()) {
        // Redireciona de volta à página anterior
        header('Location: C:/xampp/htdocs/tcc geral1/Produtos - Adicionar/index.html');
        exit();
    } else {
        echo "Erro ao adicionar o produto: " . $stmt->error;
    }
    $stmt->close();
}

?>