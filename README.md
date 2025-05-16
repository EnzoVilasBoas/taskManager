# 📝 Projeto de Gestão de Tarefas com Laravel

Este projeto é uma aplicação web desenvolvida com **Laravel** para **criação, listagem e gerenciamento de tarefas**, permitindo o **vínculo de usuários** a essas tarefas, além de funcionalidades como autenticação, controle de status e permissões.

---

## ⚙️ Tecnologias Utilizadas

- Laravel 12
- PHP 8.x
- MySQL ou MariaDB
- Bootstrap 5
- jQuery 3.x
- Blade Templates
- Eloquent ORM

---

## 📂 Funcionalidades

- Cadastro e login de usuários com verificação de status ativo.
- Criação de tarefas com título, descrição e status.
- Vínculo de usuários às tarefas (muitos-para-muitos).
- Listagem de tarefas do usuário logado.
- Paginação de usuários.
- Troca de status via AJAX.
- Exclusão e edição de tarefas e vínculos.
- Autenticação com `Auth` nativo do Laravel.
- Middleware para restrição por permissão.
- Envio de mensagens de erro e sucesso.

---

## 🚀 Instalação

### 1. Clone o repositório:

```bash
git clone https://github.com/seu-usuario/seu-repo.git
cd seu-repo
```

### 2. Instale as dependências:

```bash
composer install
npm install && npm run dev
```

### 3.  Inicie o servidor:

```bash
php artisan serve
```
