<?php
    require_once('Pessoa.php');
    require_once('PessoaDAO.php'); 
    require_once('config_upload.php');

#CADASTRO PESSOA
    if(isset($_POST['cadastrar'])){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];
        $nome_arquivo=$_FILES['imagem']['name'];  
        $tamanho_arquivo=$_FILES['imagem']['size']; 
        $arquivo_temporario=$_FILES['imagem']['tmp_name']; 
       if (!empty($nome_arquivo)){

        if($sobrescrever=="não" && file_exists("$caminho/$nome_arquivo"))
            die("Arquivo já existe");

        if($limitar_tamanho=="sim" && ($tamanho_arquivo > $tamanho_bytes))  
            die("Arquivo deve ter o no máximo $tamanho_bytes bytes");

        $ext = strrchr($nome_arquivo,'.');
        if (($limitar_ext == "sim") && !in_array($ext,$extensoes_validas))
            die("Extensão de arquivo inválida para upload");

        if (move_uploaded_file($arquivo_temporario, "../../imagens/$nome_arquivo")) {
                echo " Upload do arquivo: ". $nome_arquivo." foi concluído com sucesso <br>";


                $pessoa=new Pessoa();
                $pessoa->setnome($nome);
                $pessoa->setemail($email);
                $pessoa->setcpf($cpf);
                $pessoa->setsenha($senha);
                $pessoa->setimagem($nome_arquivo);

                $PessoaDAO= new PessoaDAO($pessoa);



                $retorno=$PessoaDAO->inserirPessoa($pessoa);

                
                header('location:../../index.php');
         }
    }
}
#ENTRAR
    if(isset($_POST['entrar'])){
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $pessoa=new Pessoa();
        $pessoa->setemail($email);
        $pessoa->setsenha($senha);

        $PessoaDAO= new PessoaDAO();

        $retorno=$PessoaDAO->acessarPessoa($pessoa);

        if($retorno){
            session_start();
            $_SESSION['logado'] = true;
            $_SESSION['codpessoa'] = $retorno['codpessoa'];
            $_SESSION['nome'] = $retorno['nome'];
            header('location:../../index.php');
        }
        else{
            header('location:../../login.php');
        }
    }

#SAIR
    if(isset($_POST['sair'])){
            session_start();
            session_destroy();
            header('location:../../login.php');
    }

#EDITAR PESSOA
    if(isset($_POST['editar'])){
    
                $codpessoa = $_POST['editar'];

                $pessoa=new Pessoa();

                $pessoa->setcodpessoa($codpessoa);

                $PessoaDAO= new PessoaDAO();

                $retorno=$PessoaDAO->buscarPessoa($pessoa);

                require_once('../../alterarPessoa.php');
    }    
#ALTERAR PESSOA
    if(isset($_POST['alterar'])){
    
            $codpessoa = $_POST['codpessoa'];
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $cpf = $_POST['cpf'];
            $senha = $_POST['senha'];    

            $pessoa=new Pessoa();
            $pessoa->setnome($nome);
            $pessoa->setemail($email);
            $pessoa->setcpf($cpf);
            $pessoa->setsenha($senha);
            $pessoa->setcodpessoa($codpessoa);

            $PessoaDAO= new PessoaDAO();



            $retorno=$PessoaDAO->alterarPessoa($pessoa);

            header('location:../../index.php');
    }
#DELETAR PESSOA
    if(isset($_POST['deletar'])){
        $codpessoa = $_POST['deletar'];

                $pessoa=new Pessoa();

                $pessoa->setcodpessoa($codpessoa);

                $PessoaDAO= new PessoaDAO();

                $retorno=$PessoaDAO->deletarPessoa($pessoa);
       

        header('Location:../../index.php');
    }

#PESQUISAR PESSOA
    if(isset($_POST['pesquisar'])){

                $pessoa=new Pessoa();

                $nome = "%".strtoupper($_POST['nome'])."%";

                $pessoa->setnome($nome);

                $PessoaDAO= new PessoaDAO();

                $retorno=$PessoaDAO->pesquisarPessoa($pessoa);

                require_once('../../mostrarPessoa.php');
    }
#ALTERAR PERFIL
    if(isset($_POST['alterarPerfil'])){
 
            session_start();

            $codpessoa = $_POST['codpessoa'];
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $cpf = $_POST['cpf'];
            $senha = $_POST['senha'];    

            $pessoa=new Pessoa();
            $pessoa->setnome($nome);
            $pessoa->setemail($email);
            $pessoa->setcpf($cpf);
            $pessoa->setsenha($senha);
            $pessoa->setcodpessoa($codpessoa);

            $PessoaDAO= new PessoaDAO();

            $retorno=$PessoaDAO->alterarPessoa($pessoa);

            $_SESSION['nome'] = $nome;
            echo $_SESSION['nome'];
            header('location:../../alterarPerfil.php');
    }
?>