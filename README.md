# Projeto Web - CRUD de Clientes

## Arquitetura: Mini MVC
## Front-End: CSS/Bootstrap e Javascript/Jquery
## Back-End: PHP e Banco de Dados Postgrees

###### Desenvolvimento de um sistema simples para Controle de Clientes.

## Ferramentas utilizadas:
- Linguagem de Programação: PHP;
- Biblioteca para manipulação da base de dados => PDO(PHP DATA OBJETC);
- Banco de Dados => Postgress;
- Framework JS => Jquery;
- Framework CSS => Bootstrap;

## Requisitos funcionais do Projeto:
- Campos para o cadastro de cliente: id, nome, email, cpf, sexo, celular, foto;
- Todos os campos com exceção da foto são obrigatórios;
- Se usuário preencher foto, validar se é JPG/JPEG e dimensões mínimas de 800x800 pixels;
- Email possui validação de formato e domínio válido;
- Utilizada máscara nos campos CPF e Celular;
- Utilizado combo/select no campo sexo;
- Utilizado autoload e namespace para carregamento automatico das classes

## Estrutura do Projeto
- Dir App => Núcleo por trás da aplicação
- Dir Assets => Tudo que é de dominio público para o usuário
- Dir. app/controller => faz o redirecionamento do sistema de acordo com a ação solicitada
- Dir. app/model => interação da classe Cliente com o banco de dados
- Dir. app/helper => classe para auxiliar no processo de validação das informações
- Dir. app/lib => configurações gerais de conexão com banco de dados, ambiente e funções úteis 
- Dir. assets/view => telas do sistema
- Dir. assets/css => biblioteca de estilos do boostrap
- Dir. assets/js => bilbioteca jquery e scripts js usados em validações
- File. autoload.php => faz o carregamento automático das classes quando necessário
- File. index.php => tela inicial com a listagem de clientes cadastrados
- Dir. sql => apenas um txt com o create da tabela utilizada

## Configuração para deploy da aplicação:
- Editar o arquivo **app/lib/config.php** para modificar ambiente