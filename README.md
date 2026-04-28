# Biblioteca-PHP
# Biblioteca-PHP

# 📚 Biblioteca Online - Sistema de Gerenciamento

Este projeto é um sistema de biblioteca web desenvolvido como parte da disciplina de Análise e Desenvolvimento de Sistemas. O sistema permite o cadastro de usuários, login, gerenciamento de acervo e um fluxo completo de carrinho de compras, utilizando **PHP** e **JavaScript** com persistência em **Sessões (Sessions)**.
---

## 👩‍💻 Autoras
- **Isabely Laura Goetz Martins**
- **Maria Beatriz**

---
## 🚀 Funcionalidades Principais

### 👤 Gestão de Usuários
- **Cadastro e Login:** Sistema de autenticação com diferenciação entre usuários comuns e administradores.
- **Segurança de Acesso:** Páginas protegidas que redirecionam o usuário para o login caso não esteja autenticado.

### 📖 Catálogo de Livros
- **Vitrine Dinâmica:** Listagem de livros disponíveis com opção de adicionar ao carrinho.
- **Cadastro de Livros:** Interface para adicionar novos títulos ao acervo (armazenados em array de sessão).

### 🛒 Carrinho de Compras
- **Fluxo Completo:** Adicionar itens, visualizar o total acumulado e remover itens específicos.
- **Cálculo em Tempo Real:** Funções PHP que processam os valores monetários para exibir o total da compra.
- **Remoção via POST:** Implementação de exclusão segura utilizando o método POST conforme exigência acadêmica.

### 🛠️ Painel Administrativo
- **Relatório Executivo:** Cards dinâmicos com contagem total de livros e usuários.
- **Tabela Interativa:** Utilização da biblioteca **JSpreadsheet** para gerenciar dados em formato de planilha diretamente no navegador.

---

## 📋 Requisitos Técnicos Implementados (Critérios de Avaliação)

De acordo com as exigências da disciplina, o projeto contém:

- [x] **Variáveis e Operadores:** Cálculos de totais e manipulação de dados de preço.
- [x] **Estruturas de Decisão:** `if/else` para controle de acesso, validação de login e permissões de ADM.
- [x] **Estruturas de Repetição:** `foreach` para percorrer vetores e listar livros/usuários.
- [x] **Funções PHP:** Centralizadas no `functions.php` para cálculos de total e validação de campos.
- [x] **Métodos GET e POST:** - `POST` para envio de formulários e **exclusão de itens** no carrinho.
    - `GET` para adicionar itens e navegação simples.
- [x] **Vetores (Arrays):** Armazenamento de dados estruturados em `$_SESSION`.
- [x] **Include/Require:** Organização modular do código.
- [x] **Página com Tabela:** Implementação avançada no Dashboard Administrativo.
- [x] **Validação de Formulários:** Checagem de campos obrigatórios no servidor.

---

## 🛠️ Tecnologias Utilizadas

- **PHP 8.x**: Lógica de back-end e gerenciamento de sessões.
- **HTML5 & CSS3**: Estrutura e estilização (Layout moderno com Sidebar).
- **JavaScript**: Lógica de interface e integração com a planilha JSpreadsheet.
- **JSpreadsheet (v4)**: Biblioteca de planilha de dados.
- **Font Awesome**: Ícones de interface.

---

## 📂 Estrutura do Projeto

```text
/
├── index.php             # Vitrine principal de livros
├── assets/               # Arquivos estáticos (style.css, scripts.js e a pasta img para imagens)
├── includes/             
│   └── functions.php     # Funções globais de cálculo e validação
└── pages/                # Páginas internas do sistema, como login.php, carrinho.php, entre outros.
