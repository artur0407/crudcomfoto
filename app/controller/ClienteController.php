<?php
namespace controller;

use model\ClienteModel;
use helper\Validation;

class ClienteController
{
    private $redirect;

    public function __construct($post, $file, $action, $id)
    {
        $this->redirect = 'index.php';

        if (count($post) > 0) {

            $validation = new Validation();
            $isError = $validation->validate($post, $file);

            if (isset($isError["erroForm"])) {
                $resultMessage["erro"] = $isError["erroForm"];
                $this->redirect = 'index.php?page=clienteForm';
            } else {
                $post["foto"]   = $validation->getPathUpload();
                $resultMessage  = empty($post["id"]) ? $this->save($post) : $this->update($post, $id);
            }
        } else {
            if ($action == 'remove' && !empty($id)) {
                $resultMessage = $this->delete($id);
            }
        }

        if ($resultMessage["sucesso"]) {
            $_SESSION["sucesso"] = $resultMessage["sucesso"];
        } else {
            $_SESSION["erro"] = $resultMessage["erro"];
        }

        header("Location: " . $this->redirect);
    }

    private function save($post)
    {
        $retorno = [];
        
        $clienteInsert = new ClienteModel();
        $cliente = $clienteInsert->save($post);

        if (isset($cliente["erro"])) {
            $retorno["erro"] = "Erro ao cadastrar cliente";
        } else {
            $retorno["sucesso"] = "Cliente <b> cadastrado </b> com sucesso!";
        }

        return $retorno;
    }

    private function update($post, $id)
    {
        $retorno = [];

        $clienteUpdate = new ClienteModel();
        $cliente = $clienteUpdate->update($post, $id);
        
        if (isset($cliente["erro"])) {
            $retorno["erro"] = "Erro ao atualizar cliente";
        } else {
            $retorno["sucesso"] = "Cliente <b> alterado </b> com sucesso!";
        }

        return $retorno;
    }

    private function delete($id)
    {
        $retorno = [];

        $clienteRemove = new ClienteModel();
        $cliente = $clienteRemove->remove($id);

        if (isset($cliente["erro"])) {
            $retorno["erro"] = "Erro ao tentar <b> remover </b> cliente";
        } else {
            $retorno["sucesso"] = "Cliente <b> removido </b> com sucesso";
        }
        
        return $retorno;
    }
}