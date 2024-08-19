

<?php
include 'vitrine.php';

// Query para obter os produtos do banco de dados
$sql = "SELECT * FROM vitrine";
$result = $conn->query($sql);
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vitrine de Produtos</title>
 
  <link rel="stylesheet" href="vitrinicss.css">
  
</head>
<body>


 <div class="header">
      <h1 class="logo">Baratão da Moda</h1>]
      <h1 class="logo">- Vestidos - </h1>
      <div class="header-right">
         <a href="../página_inicial/index.html">Início</a>
         <div class="dropdown">
            <button class="dropbtn">Produtos
               <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
               <a href="../Vitrine/VitrineBlusa_Top.php">Blusas e Tops</a>
               <a href="../Vitrine/VitrineVestido.php">Vestidos</a>
               <a href="../Vitrine/VitrineCalca_Short.php">Calças e Shorts</a>
               <a href="../Vitrine/VitrineSaias.php">Saias</a>
               <a href="../Vitrine/VitrineConjuntos.php">Conjuntos</a>
               <a href="../Vitrine/VitrineAcessorios.php">Acessórios</a>
            </div>
            </div>
            <a href="../Sobre nós/sobre.html">Sobre nós</a>
            <a href="../Login/index.html">Área do Proprietário</a>
        </div>
      <div class="mobile-menu-icon">
         <span></span>
         <span></span>
         <span></span>
      </div>
   </div>


  <h2 class="vitrine"> Interessado em alguma peça? Entre em contato conosco pelas redes sociais!!</h2>

    <!-- Produtos aqui -->
    <ul class="lista-produtos" id="listaProdutos">
    <?php
// Loop através dos resultados da consulta
while ($row = $result->fetch_assoc()) {
    // Verifica se a categoria é "v"
    if ($row['categoria'] === 'v') {
      echo '<li class="item-produto">';
      echo '<a href="#" class="link-produto">';
      echo '<figure class="info-produto">';
      echo '<div class="imagem-produto">';
      echo '<img src="uploads/' . $row['foto'] . '" alt="' . $row['descricao'] . '">';
      echo '</div>';
      echo '<figcaption class="descricao-produto">';
      echo '<h2 class="titulo">' . $row['nome'] . '</h2>';
      echo '<p class="descricao">' . $row['descricao'] . '</p>';
      echo '<span class="product-id">ID: ' . $row['id'] . '</span>';
      echo '</figcaption>';
      echo '<div class="caixa-preco">';
      echo '<div class="preco">';
      echo '<div>';
      echo '<ins>R$ ' . number_format($row['preco'], 2, ',', '.') . '</ins>';
      echo '</div>';

      // Adiciona a mensagem de parcelas apenas se for maior que 1
      if ($row['parcelas'] > 1) {
          echo '<span class="info-preco">,ou ' . $row['parcelas'] . ' parcelas de R$' . number_format($row['preco'] / $row['parcelas'], 2, ',', '.') . '</span>';
      }

      echo '</div>';
      echo '</div>';
      echo '</figure>';
      echo '</a>';
      echo '</li>';
  }
}
?>
</ul>


  <div class="pagination" id="pagination"></div>
  <style>
  .pagination {
    /* Outros estilos existentes... */
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px; /* Adicione margem acima do bloco de paginação */
  }

  .pagination-link {
    display: inline-block !important;
    width: 30px !important;
    height: 30px !important;
    margin: 0 5px !important;
    color: #f0c60d !important;
    text-align: center !important;
    line-height: 30px !important;
    border-radius: 50% !important;
    text-decoration: none !important;
    font-weight: bold !important;
    font-size: 14px !important;
    border: 2px solid #f0c60d !important;
    transition: background-color 0.3s, color 0.3s !important;
  }

  .pagination-link:hover {
    filter: sepia(100%);
    transition: 0.4s;
  }

  .current-page {
    background-color: rgba(255, 204, 0, 0.5); /* R, G, B, Alpha */
    color: black;
  }
</style>




 <div class="footer">
      <div class="col-3">
         <h3>Contatos</h3>
         <div class="social-icons">
            <a href="https://www.instagram.com/baratao_da_moda_oficial/">
               <i class="fab fa-whatsapp"></i>Instagram: @barataodamoda_</a>
            <br>
            <a
               href="https://l.instagram.com/?u=http%3A%2F%2Fapi.whatsapp.com%2Fsend%3F1%3Dpt_BR%26phone%3D5574981078030&e=AT1VkjJx0ByCFni7FqalJVEbLk_uxlBKXGw0JTLvEZO2fkRvQcHlxCKkM520msiwL05FP9YZeAFycnhsZ6tdEk3gd-jb33v1EeAAMG1XxQ5yHu1u">
               <i class="fab fa-instagram"></i>Whatsapp:(74) 98125-6582</a>
         </div>
      </div>

      <div class="col-2">
         <h3>Links</h3>
         <a href="#">Sobre Nós</a>
         <a href="index.html#categorias">Produtos</a>
         <a href="#">Área do Proprietário</a>
      </div>

      <div class="col-1" style="direction: ltr;">
         <h3>Endereço</h3>
         <p>Caldeirão Grande</p>
         <p>Bahia</p>
      </div>
   </div>


   <script>
document.addEventListener("DOMContentLoaded", function () {
    const listaProdutos = document.getElementById("listaProdutos");
    const pagination = document.querySelector(".pagination");

    const itemsPerPage = 10;
    let currentPage = 1;

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const produtos = listaProdutos.children;

        for (let i = 0; i < produtos.length; i++) {
            produtos[i].style.display = i >= start && i < end ? "block" : "none";
        }
    }

    function createPaginationLinks(totalPages) {
        pagination.innerHTML = ''; // Limpa a paginação antes de recriá-la

        for (let i = 1; i <= totalPages; i++) {
            const link = document.createElement("a");
            link.href = "#";
            link.textContent = i;
            link.classList.add("pagination-link");

            // Realce o botão da página atual
            if (i === currentPage) {
                link.classList.add("current-page");
            }

            link.addEventListener("click", function (e) {
                e.preventDefault();
                currentPage = i;
                showPage(currentPage);
                createPaginationLinks(totalPages);
            });
            pagination.appendChild(link);
        }
    }

    const produtos = listaProdutos.children;
    const totalPages = Math.ceil(produtos.length / itemsPerPage);
    showPage(currentPage);
    createPaginationLinks(totalPages);
});
</script>

</body>
</html>