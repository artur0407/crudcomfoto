<?php

namespace helper;

class Validation
{
    private $pathUpload;
    
    public function validate($post, $file)
    {
        $cliente = array();

        extract($post);

        if (empty($nome)) {
            $cliente['erroForm'] = "Atenção, campo <b> Nome </b> não foi informado";
        } else if (empty($email)) {
            $cliente['erroForm'] = "Atenção, campo <b> Email </b> não foi informado";
        } else if(!$this->validate_email($email)) {
            $cliente['erroForm'] = "Atenção, o <b> Email </b> informado é inválido";
        } else if (empty($sexo)) {
            $cliente['erroForm'] = "Atenção, campo <b> Sexo </b> não foi escolhido";
        } else if (empty($cpf)) {
            $cliente['erroForm'] = "Atenção, campo <b> CPF </b> não foi escolhido";
        } else if(!$this->validate_cpf($cpf)) {
            $cliente['erroForm'] = "Atenção, o <b> CPF </b> informado é inválido";
        } else if (empty($celular)) {
            $cliente['erroForm'] = "Atenção, campo <b> Celular </b> não foi informado";
        } else if (!empty($this->valida_foto($file, 800, 800))) {
            $cliente['erroForm'] = $this->valida_foto($file, 800, 800);
        }

        return $cliente;
    }

    private function validate_email($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            $dominio=explode('@',$email);
            if(!checkdnsrr($dominio[1],'A')) {
                return false;
            }
        }
        return true;
    }
    
    private function validate_cpf($cpf = null)
    {
        // Verifica se um número foi informado
        if(empty($cpf)) return false;

        //Elimina possivel mascara
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
    
        // Verifica se o numero de digitos informados é igual a 11 e 
        // se nenhuma das sequências invalidas abaixo foi digitada. Caso afirmativo, retorna falso
        if (strlen($cpf) != 11) {
            return false;
        } else if ($cpf == '00000000000' || 
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999') {
            return false;
        } else {   
            // Calcula os digitos verificadores para verificar se o CPF é válido
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
            return true;
        }
    }
    
    private function valida_foto($files = array(), $largura = 800, $altura = 800)
    {
        $erro = "";

        if(isset($files['foto']['name']) && $files['foto']['error'] == 0 ) {

            $arquivo_tmp = $files['foto']['tmp_name'];
            $nome = $files['foto']['name'];
            $dimensoes = getimagesize($files['foto']['tmp_name']);

            //Pega a extensão e converte-a para minúsculo
            $extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
                    
            // Permitir somente imagens, .jpg; .jpeg;
            if (!strstr('.jpg;.jpeg;', $extensao)) {
                $erro = "Você poderá enviar apenas imagens <b>.jpg ou .jpeg</b>";
                return $erro;
            }

            if($dimensoes[0] < $largura || $dimensoes[1] < $altura) {
                $erro = "Sua imagem deve conter um tamanho de no mínimo 800 pixels de largura por 800 pixels de altura";
                return $erro;
            }

            $this->setPathUpload(uniqid(time()), $extensao);

            if (!move_uploaded_file($arquivo_tmp, $this->getPathUpload())) {
                $erro = 'Erro ao salvar imagem. Verifique a permissão no servidor';
                return $erro;
            }
        }

        return $erro;
    }

    private function setPathUpload($nome, $extensao)
    {
        $this->pathUpload = getcwd().'\assets\\upload\\'.$nome.'.'.$extensao;
    }

    public function getPathUpload()
    {
        return $this->pathUpload;
    }
}