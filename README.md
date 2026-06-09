# 📚 Biblioteca Online - Sistema de Gerenciamento Back-end

Este projeto é um sistema de biblioteca web dinâmico desenvolvido como parte dos critérios de avaliação da disciplina de Análise e Desenvolvimento de Sistemas. A aplicação implementa um fluxo completo de autenticação, gerenciamento de acervo (CRUD) e carrinho de compras, utilizando **PHP (com arquitetura orientada a objetos na extensão MySQLi)**, **JavaScript nativo** e persistência em **Banco de Dados Relacional (MySQL)**.

---

## 👩‍💻 Autoras
- **Isabely Laura Goetz Martins**
- **Maria Beatriz**

---

## 🚀 Funcionalidades Principais

### 👤 Gestão de Usuários e Segurança
- **Autenticação e Níveis de Acesso:** Sistema de login com diferenciação estrita de privilégios entre usuários comuns e administradores (RBAC).
- **Controle de Sessão Seguro:** Páginas restritas protegidas por variáveis de sessão (`$_SESSION`), impedindo o acesso via URL por usuários não autenticados.

### 📖 Catálogo Dinâmico de Livros
- **Vitrine em Tempo Real:** Renderização automática dos cards de livros cadastrados no banco de dados, ordenados por relevância e novidades.
- **Mecanismo de Busca Client-Side:** Filtro instantâneo de títulos por meio de JavaScript assíncrono no Front-end.

### 🛒 Carrinho de Compras
- **Persistência de Estado:** Armazenamento volátil dos itens selecionados utilizando vetores de sessão.
- **Processamento Monetário:** Funções back-end em PHP para cálculo acumulado do total da compra.
- **Exclusão Segura:** Implementação do fluxo de remoção de itens utilizando o método HTTP `POST`, mitigando vulnerabilidades de requisições indevidas.

### 🛠️ Painel Administrativo (Dashboard)
- **Relatórios Dinâmicos:** Cards informativos baseados em queries agregadas de contagem (`COUNT`) no MySQL.
- **Tabela Interativa Interconectada:** Integração com a biblioteca **JSpreadsheet** para visualização e manipulação ágil de dados estruturados.

### 🍪 Conformidade e UX
- **Termo de Consentimento (LGPD):** Banner dinâmico para aceite de políticas de privacidade, gerenciado via manipulação de `$_COOKIE` no servidor e alertas informativos em JavaScript.
- **Player de Mídia Integrado:** Widget fixo com transmissão de música ambiente (Lofi) para enriquecer a experiência do usuário.

---

## 📋 Requisitos Técnicos Implementados (Critérios de Avaliação)

De acordo com as exigências acadêmicas da disciplina, o projeto cobre com sucesso os seguintes tópicos:

- [x] **Variáveis, Operadores e Tipagem:** Manipulação de dados financeiros e strings.
- [x] **Estruturas de Decisão (`if/else`):** Controle de fluxo de autenticação, checagem de cookies e permissões.
- [x] **Estruturas de Repetição (`while` / `foreach`):** Laços para iteração de arrays de dados e ponteiros de resultados do banco.
- [x] **Modularização (`include` / `require_once`):** Organização do ecossistema dividindo conexões, funções globais e cabeçalhos.
- [x] **Funções Personalizadas:** Encapsulamento de regras de negócio em arquivos isolados (`functions.php`).
- [x] **Persistência em Banco de Dados (MySQL):** Modelagem e persistência real de dados de usuários e livros.
- [x] **Segurança da Informação:** Uso de **Prepared Statements (`$stmt->bind_param`)** para prevenção contra ataques de *SQL Injection*.
- [x] **Métodos HTTP (GET e POST):** - `POST` para tráfego seguro de credenciais, cadastros e remoções.
  - `GET` para requisições de navegação e passagem de parâmetros simples.
- [x] **Gerenciamento de Estado (`$_SESSION` e `$_COOKIE`):** Manutenção de login ativo e persistência da escolha de cookies da LGPD por 30 dias.

---

## 🛠️ Tecnologias Utilizadas

- **PHP 8.x**: Linguagem de programação server-side.
- **MySQL**: Sistema de gerenciamento de banco de dados relacional.
- **HTML5 & CSS3**: Estruturação semântica e estilização (Layout moderno responsivo em Modo Escuro).
- **JavaScript (ES6+)**: Comportamento da interface, lógica de busca e controle do banner de consentimento.
- **JSpreadsheet (v4)**: Componente JavaScript para manipulação de tabelas ricas.
- **Font Awesome**: Conjunto de ícones vetoriais.

---

## 📂 Estrutura Estrutural do Projeto

```text
/
├── index.php             # Tela principal / Prateleira dinâmica de livros
├── assets/               # Recursos estáticos da aplicação
│   ├── style.css         # Folha de estilo central (temas claro/escuro)
│   └── script.js         # Lógica client-side e interceptação de eventos
├── includes/             # Módulos de core do sistema
│   ├── conexao.php       # Script de estabelecimento do canal MySQLi com o banco
│   └── functions.php     # Biblioteca de funções reaproveitáveis e sanitização
└── pages/                # Módulos e telas internas protegidas
    ├── login.php         # Formulário de autenticação
    ├── logout.php        # Encerramento e destruição de sessões
    ├── carrinho.php      # Gerenciamento de itens selecionados
    └── cadastrarlivro.php# Interface de inserção de dados no acervo