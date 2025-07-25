# API de Receitas Gastronômicas (Laravel 12 + PHP 8.2 + MySQL 8)

### Desenvolvido por Bruno Corral

Este projeto foi desenvolvido como parte do processo seletivo para a vaga Desenvolvedor - Private Code Soluções Digitais, atendendo a todos os requisitos funcionais, técnicos e diferenciais solicitados.

A API realiza a autenticação de usuário, visualização, inclusão, atualização e deleção de receitas gastronômicas, o visitante consegue deixar comentários e notas para receitas e é exibido uma nota média da receita baseada nas notas que os visitantes deram para a receita.

---

## Tecnologias utilizadas

- PHP 8.2
- Laravel 12.x
- MySQL 8.x
- GIT para versionamento do projeto

---

## Instalação e configuração

### Clonando o projeto
```bash
git clone https://github.com/seu-usuario/api_gastronomic_recipes
cd api_gastronomic_recipes
```

### Configurando o arquivo `.env`
```bash
cp .env.example .env
```

### Gerando a key da aplicação
```bash
php artisan key:generate
```

### Rodando as migrations
```bash
php artisan migrate
```

### Acessando a aplicação no navegador
```
http://localhost:8000
```

---

## Como utilizar a API no Postman ou Insomnia

### Para registrar um usuário crie a HTTP Request com o tipo POST e passe o link: (POST `http://localhost:8000/api/register`)
Exemplo de JSON no Body para cadastro:
```json
{
	"name": "Bruno",
	"email": "bruno@gmail.com",
	"password": "bruno123"
}
```

### Para fazer login do usuário crie a HTTP Request com o tipo POST e passe o link: (POST `http://localhost:8000/api/login`)
Exemplo de JSON no Body para cadastro:
```json
{
	"email": "bruno@gmail.com",
	"password": "bruno123"
}
```

- Copie o token gerado para ser usado na próxima requisição

#### Para fazer a autenticação do usuário logado crie a HTTP Request com o tipo POST e passe o link: (POST `http://localhost:8000/api/validate`)

#### Para fazer o logout do usuário logado crie a HTTP Request com o tipo POST e passe o link: (POST `http://localhost:8000/api/logout`)

### Rotas autenticadas
- As rotas abaixo devem seguir o passo a passo abaixo para que se tenha o retorno esperado pela API:

1. Vá na aba Auth
2. Em Auth Types escolha a opção Bearer Token
3. Deixe a opção "ENABLED" habilitado
4. Cole o Token gerado na requisição de login no campo Token
5. No campo Prefix, escreva Bearer
6. Aperte em "Send" para enviar a requisição para ter a autenticação do usuário logado

#### Para fazer a visualização das receitas, comentários das receitas, nome do visitante que fez o comentário e a nota do visitante e a nota média da receita crie a HTTP Request com o tipo GET e passe o link: (GET `http://localhost:8000/api/recipe`)

#### Para fazer a visualização de uma receita crie a HTTP Request com o tipo GET e passe o link: (GET `http://localhost:8000/api/recipe/{id}`)
Ex: http://localhost:8000/api/recipe/1

#### Para fazer a criação de uma receita crie a HTTP Request com o tipo POST e passe o link: (POST `http://localhost:8000/api/recipe`)
Exemplo de JSON no Body para criação:
```json
{
	"title": "Bolo de Laranja",
	"description": "Ingrediente: Ovo, Farinha, Manteiga"
}
```

#### Para fazer a atualização de uma receita crie a HTTP Request com o tipo PUT e passe o link: (PUT `http://localhost:8000/api/recipe/{id}`)
Ex: http://localhost:8000/api/recipe/1

Exemplo de JSON no Body para criação:
```json
{
	"title": "Bolo de Laranja com cobertura",
	"description": "Ingrediente: Ovo, Farinha, Manteiga, Açúcar"
}
```

#### Para fazer a deleção de uma receita crie a HTTP Request com o tipo DELETE e passe o link: (DELETE `http://localhost:8000/api/recipe/{id}`)
Ex: http://localhost:8000/api/recipe/1

---

### Rota não autenticada

- Esta rota não é autenticada para que o visitante consiga fazer a adição de um comentário e uma nota para uma receita

#### Para fazer a criação de um comentário e nota de um visitante para uma receita crie a HTTP Request com o tipo POST e passe o link: (POST `http://localhost:8000/api/recipe/{id}/comment`)
Ex: http://localhost:8000/api/recipe/1/comment

Exemplo de JSON no Body para criação:
```json
{
	"author": "Luciano",
	"comment": "O bolo está muito bom!",
	"note": 5
}
```

- Após a inclusão de uma nota de um visitante a nota média (average_note) irá ser atualizada de sua respectiva receita

---

## Requisitos atendidos (conforme orientado na descrição do projeto)
- ✅ A API deve conter um sistema de autenticação completo (login, logoff e register)
- ✅ Após logado o usuário deve poder cadastrar novas receitas além de visualizar, editar ou excluir receitas já existentes
- ✅ Visitantes devem poder dar uma nota de 1 a 5 para uma receita, além de criar um comentário sobre a mesma
- ✅ Ao exibir uma receita, o sistema deve mostrar seus respectivos comentários, avaliações e uma nota média de todas as avaliações que foram dadas para aquela receita

---

## Seguindo padrões de commits baseados do site
* https://www.conventionalcommits.org/pt-br/v1.0.0-beta.4/

---

## Sobre mim

Projeto desenvolvido por Bruno Corral como parte do processo seletivo para Desenvolvedor para Private Code Soluções Digitais.  
Focado em boas práticas, clareza de código e eficiência.

---

## Licença
Este projeto foi desenvolvido exclusivamente para fins de avaliação técnica.