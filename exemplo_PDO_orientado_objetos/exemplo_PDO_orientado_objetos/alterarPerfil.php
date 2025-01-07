<!DOCTYPE html>
<html>
<?php
 include_once('includes/componentes/cabecalho.php');
 include_once('includes/componentes/header.php');
 require_once('includes/logica/Pessoa.php');
 require_once('includes/logica/PessoaDAO.php'); 

 $codpessoa = $_SESSION['codpessoa'];

 $pessoa=new Pessoa();
 $pessoa->setcodpessoa($codpessoa);
 $pessoasDAO = new PessoaDAO();
 $retorno = $pessoasDAO->buscarPessoa($pessoa);

?>
    <title>Alterar Perfil</title>
</head>
<body>

<main>
    <section>
    <form action="includes/logica/logica_pessoa.php" method="post">
      <p><label for="nome">Nome: </label><input type="text" name="nome" id="nome" value="<?php echo $retorno['nome']; ?>"></p>
      <p><label for="email">Email: </label><input type="text" name="email" id="email" value="<?php echo $retorno['email']; ?>"></p>
      <p><label for="cpf">CPF: </label><input type="text" name="cpf" id="cpf" value="<?php echo $retorno['cpf']; ?>"></p>
      <p><label for="senha">Senha: </label><input type="password" name="senha" id="senha" value="<?php echo $retorno['senha']; ?>"></p>
      <input type="hidden" id='codpessoa' name='codpessoa' value="<?php echo $retorno['codpessoa']; ?>">
      <p> <input type="submit" id='alterarPerfil' name='alterarPerfil' value="Alterar">
      </p>        
        </form>

    </section>
</main>
<?php require('includes/componentes/footer.php');?>
</body>
</html>