# 🍽️ Cardápio Digital

## Universidade
Universidade Federal do Tocantins  

## Curso
Ciência da Computação  

## Disciplina
Engenharia de Software  

## Semestre
2º semestre de 2025  

## Professor
Edeílson Milhomem  

## Integrantes do Projeto
- Arthur Vinicíus de Oliveira Carvalho  
- Ester Arraiz de Matos  
- Jorge Antônio Motta Braga  
- Matheus Henrique de Freitas  
- Vitória Maria Reis Fontana  

---

## 📖 Descrição do Projeto
O Cardápio Digital é uma aplicação web desenvolvida para modernizar a experiência em restaurantes, lanchonetes e bares. O sistema permite a criação facilitada de um cardápio digital.

## 🎯 Objetivo
O principal objetivo deste projeto é aplicar os conceitos e práticas de Engenharia de Software no desenvolvimento de uma solução web funcional. Isso inclui o levantamento de requisitos, modelagem do sistema, implementação utilizando o padrão arquitetural MVC (Model-View-Controller), gerenciamento de banco de dados e trabalho em equipe, resultando em um produto de software coeso e bem-estruturado.

## ✅ Requisitos Implementados

| **Funcionalidade**                               | **Descrição**                                                                                      | **Responsável**                           |
|--------------------------------------------------|--------------------------------------------------------------------------------------------------|-------------------------------------------|
| **Criação (Create)**                             | Adicionar novos itens ao cardápio com nome, descrição, preço, categoria e imagem.               | Ester Arraiz de Matos (Formulário) <br> Arthur Vinicíus de Oliveira Carvalho (Lógica) |
| **Leitura (Read)**                                | Listar todos os produtos cadastrados de forma organizada.                                       | Jorge Antônio Motta Braga                 |
| **Atualização (Update)**                          | Editar todas as informações de um produto existente, incluindo a substituição da imagem.        | Matheus Henrique de Freitas              |
| **Exclusão (Delete)**                             | Remover produtos do cardápio.                                                                    | Vitória Maria Reis Fontana               |
| **Gerenciamento de Categorias**                   | Associação de produtos a categorias (Ex: Lanches, Bebidas, Sobremesas).                         | **Todos**                                |
| **Upload de Imagens**                             | Sistema de upload para associar uma imagem a cada produto.                                      | **Todos**                                |


# 🔄 Ciclo de Revisão

## Arthur Vinicíus ➡️ revisa o código da Ester  
## Ester ➡️ revisa o código do Jorge  
## Jorge ➡️ revisa o código do Matheus  
## Matheus ➡️ revisa o código da Vitória  
## Vitória ➡️ revisa o código do Arthur

## 💻 Tecnologias Utilizadas
- **Backend:** PHP 8.1+  
- **Banco de Dados:** PostgreSQL (via Supabase)  
- **Frontend:** HTML5, CSS3 
- **Gerenciador de Dependências:** Composer  
- **Arquitetura:** MVC (Model-View-Controller)  

## 🎥 Vídeo de Apresentação
Assista ao vídeo de apresentação do nosso projeto, onde demonstramos as funcionalidades e explicamos a arquitetura do sistema.
https://drive.google.com/file/d/14b0xUAFVPUmXZmBEkvBOXQHb22GtGGrG/view?usp=sharing
## 🚀 Configuração e Execução Local

### Pré-requisitos
Antes de começar, certifique-se de ter instalado:
- PHP (versão 8.1 ou superior)  
- Composer  
- Git  
- Uma conta no Supabase para o banco de dados PostgreSQL  

## 🚀 Passos para Instalação

### 1. Clone o repositório

- git clone https://github.com/esterarraiz/cardapio-digital.git
- cd cardapio-digital

### 2. Instale as dependências do PHP
- composer install

### 3. Configure o Banco de Dados (Supabase/PostgreSQL)

- 1.Crie um novo projeto no Supabase.

- 2.Navegue até Project Settings > Database e encontre suas credenciais de conexão (Host, Database name, User, Port e Password).

- 3.Renomeie o arquivo config/Database.example.php para config/Database.php (se ele existir) ou crie o arquivo.

- 4.Crie um arquivo .env e preencha com as suas credenciais do Supabase.

### 5. Executando a Aplicação
- Inicie o servidor embutido do PHP:
php -S localhost:8000 -t public
- Acesse a aplicação:
http://localhost:8000
