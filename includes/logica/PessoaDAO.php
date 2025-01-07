<?php
   Class PessoaDAO{
    private $conexao;

    public function __construct() {
           try {
            $this->conexao = new PDO("mysql:host=localhost; dbname=aula; charset=utf8", "root","");
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e) {
                    echo 'Error: ' . $e->getMessage();
            }
    }

    function inserirPessoa($pessoa){
       try {
            $query = $this->conexao->prepare("insert into pessoa (nome, email, cpf, senha, imagem) values (:nome, :email, :cpf, :senha, :imagem)");

            $resultado = $query->execute(['nome' => $pessoa->getnome(),'email' => $pessoa->getemail(),'cpf' => $pessoa->getcpf(),'senha' => $pessoa->getsenha(),'imagem' => $pessoa->getimagem()]);
            
            return $resultado;
            
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }


    function alterarPessoa($pessoa){
        try {
            $query = $this->conexao->prepare("update pessoa set nome= :nome, email = :email, cpf= :cpf, senha= :senha where codpessoa = :codpessoa");
            $resultado = $query->execute(['nome' => $pessoa->getnome(),'email' => $pessoa->getemail(),'cpf' => $pessoa->getcpf(),'senha' => $pessoa->getsenha(),'codpessoa' => $pessoa->getcodpessoa()]);   
            return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    function deletarPessoa($pessoa){
        try {
            $query = $this->conexao->prepare("delete from pessoa where codpessoa = :codpessoa");
            $resultado = $query->execute(['codpessoa' => $pessoa->getcodpessoa()]);   
             return $resultado;
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }
 
    function listarPessoa(){
      try {
        $query = $this->conexao->prepare("SELECT * FROM pessoa");      
        $query->execute();
        $pessoas = $query->fetchAll();
        return $pessoas;
      }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  

    }

     function buscarPessoa($pessoa){
        try {
        $query = $this->conexao->prepare("select * from pessoa where codpessoa=:codpessoa");
        if($query->execute(['codpessoa' => $pessoa->getcodpessoa()])){
            $pessoa = $query->fetch(); //coloca os dados num array $usuario
            return $pessoa;
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

    function acessarPessoa($pessoa){
        try {
        $query = $this->conexao->prepare("select * from pessoa where email=:email and senha=:senha");
        if($query->execute(['email' => $pessoa->getemail(), 'senha' => $pessoa->getsenha()])){
            $pessoa = $query->fetch(); //coloca os dados num array $pessoa
          if ($pessoa)
            {  
                return $pessoa;
            }
        else
            {
                return false;
            }
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

 function pesquisarPessoa($pessoa){
        try {
        $query = $this->conexao->prepare("select * from pessoa where upper(nome) like :nome");
        if($query->execute(['nome' => $pessoa->getnome()])){
            $pessoas = $query->fetchAll(); //coloca os dados num array $pessoa
          if ($pessoas)
            {  
                return $pessoas;
            }
        else
            {
                return false;
            }
        }
        else{
            return false;
        }
         }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
      }  
    }

}
   ?>