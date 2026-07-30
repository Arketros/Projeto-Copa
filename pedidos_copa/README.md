# Projeto-Copa
Projeto de produção de sistema de pedidos a copa

## Como Rodar o Projeto

### Instalação

1. Gere a estrutura do banco de dados SQLite rodando o seguinte comando:
   ```bash
   sqlite3 database/database.db < database/schema.sql
   ```
2. *(Opcional, mas recomendado)* Popule o banco de dados com dados falsos (salas, usuários e itens de cardápio) para testes:
   ```bash
   php database/seed.php
   ```
3. Inicie o servidor embutido do PHP na raiz do projeto:
   ```bash
   php -S 0.0.0.0:8080
   ```