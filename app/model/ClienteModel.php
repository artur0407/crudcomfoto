<?php
namespace model;

use lib\Conexao;
use PDO;
use PDOException;

class ClienteModel
{    
    private $pdo = NULL;

    public function __construct()
    {
        $this->pdo = Conexao::getInstance();
    }
     
    public function list() 
    {
        $cliente = array();

        try {

            $sql = "SELECT * FROM cliente ORDER BY id DESC";
            $result = $this->pdo->prepare($sql);
            $result->execute();
    
            if ($result->execute()) {
                $cliente = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $cliente["erro"] = "Erro: Não foi possível recuperar os dados do banco de dados";
            }

        } catch (PDOException $erro) {
            $cliente["erro"] = $erro->getMessage();
        }

        return $cliente; 
    }

    public function get($id) 
    {
        $cliente = array();

        try {
				
            $sql = "SELECT id, nome, email, cpf, sexo, 
            celular, encode(imagem, 'base64') AS imagem
            FROM cliente WHERE id = :id";

            $result = $this->pdo->prepare($sql);
            $result->execute(['id' => $id]); 

            if ($result->rowCount() == 0 && is_numeric($id)) {
                $cliente["erro"] = "Registro não encontrado para <b> edição </b>";
            }

            $cliente = $result->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $erro) {
            $cliente["erro"] . $erro->getMessage();
        }

        return $cliente; 
    }

    public function save($post) 
    {
        $cliente = array();
        
        extract($post);

        try {

            $data = file_get_contents($foto);
            $escaped = bin2hex($data);

            $sql = "INSERT INTO cliente 
            (nome, email, cpf, sexo, celular, imagem) VALUES 
            (:nome, :email, :cpf, :sexo, :celular, decode(:imagem, 'hex'))";

            $exec = $this->pdo->prepare($sql); 
   
            $data = [
                ':nome'    => filter_var($nome, FILTER_SANITIZE_STRING),
                ':email'   => filter_var($email, FILTER_SANITIZE_EMAIL),
                ':cpf'     => preg_replace("/[^0-9]/", "", $cpf),
                ':sexo'    => $sexo,
                ':celular' => preg_replace("/[^0-9]/", "", $celular),
                ':imagem'  => $escaped
            ];

            $result = $exec->execute($data);

            if (!$result) {  
                $cliente["erro"] = $exec->errorInfo();
            }

        } catch (PDOException $erro) {
            var_dump($erro); exit;
            $cliente["erro"] = $erro->getMessage();
        }

        return $cliente;
    }
         
    public function update($post, $id) 
    {
        $cliente = array();

        extract($post);
        
        try {
            
            $data = file_get_contents($foto);
            $escaped = bin2hex($data);

            $sql = "UPDATE cliente SET 
            nome = :nome, 
            email = :email, 
            cpf = :cpf, 
            sexo = :sexo,  
            celular = :celular,
            imagem = decode(:imagem, 'hex')
            WHERE id = :id";

            $exec = $this->pdo->prepare($sql); 

            $data = [
                ':id'      => $id,
                ':nome'    => filter_var($nome, FILTER_SANITIZE_STRING),
                ':email'   => filter_var($email, FILTER_SANITIZE_EMAIL),
                ':cpf'     => preg_replace("/[^0-9]/", "", $cpf),
                ':sexo'    => $sexo,
                ':celular' => preg_replace("/[^0-9]/", "", $celular),
                ':imagem'  => $escaped
            ];

            $result = $exec->execute($data);

            if (!$result) {  
                $cliente["erro"] = $exec->errorInfo();
            }

        } catch (PDOException $erro) {
            $cliente["erro"] = $erro->getMessage();
        }

        return $cliente;
    }
         
    public function remove($id) 
    {
        $cliente = array();

        try {
            $exec = $this->pdo->prepare('DELETE FROM cliente WHERE id = :id');
            $exec->bindParam(':id', $id, PDO::PARAM_INT); 
            $exec->execute();
               
            if($exec->rowCount() == 1) {
                $cliente["sucesso"] = "Cliente <b> removido </b> com sucesso";
            } else {
                $cliente["erro"] = "Erro ao tentar <b> remover </b> cliente";
            }
        } catch(PDOException $e) {
            $cliente["erro"] = $e->getMessage();
        }

        return $cliente;
    }
}