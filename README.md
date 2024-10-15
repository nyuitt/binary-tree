# Teste Técnico - Go Dev

Este é o repositório do teste técnico para a vaga de desenvolvedor na Go Dev. O projeto consiste em um sistema de gestão de pontos baseado em uma estrutura de árvore binária, utilizando Laravel para o backend.

## Pré-requisitos

Antes de começar, você precisará ter instalado em sua máquina:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/download/) (para o frontend)

## Instalação das Dependências

### Backend (Laravel)

1. Clone o repositório:

   ```bash
   git clone https://github.com/seu-usuario/teste-tecnico-go-dev.git
   cd teste-tecnico-go-dev
   
2. Instale as dependências do Laravel usando Composer:

```bash
composer install
```
3. Copie os arquivos do .env.example para .env

4. Configure o banco de dados no .env
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=arvorebinaria
   DB_USERNAME=user
   DB_PASSWORD=password

5. Gere a chave do projeto
   ```bash
   php artisan key:generate

6. Na raiz do projeto, instale as dependencias e rode o front-end
   ```bash
   npm install/npm run dev
   
7. Ainda na raiz do projeto rode o ambiente docker
   ```bash
   docker-compose up -d

8. Rode as migrações com o comando
   ```bash
   docker exec -it nome_do_container_backend php artisan migrate --seed
   
9. Acesse seu projeto
    ```bash
    localhost:8080


### Pontos importantes:

- **Adapte** o nome correto do container no comando `docker exec`.
- **Ajuste** qualquer detalhe de configuração do `.env` de acordo com o seu projeto.
