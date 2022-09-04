# PHP MVC

Este projeto implementa o _pattern_ `MVC` (do inglês, _Model-View-Controller_) na linguagem PHP. Ademais, ele é inspirado na série de vídeos `MVC em PHP` do canal WDEV do programador brasileiro [William Costa](https://github.com/william-costa).

[Playlist](https://www.youtube.com/watch?v=7fxguLAebl4&list=PL_zkXQGHYosGQwNkMMdhRZgm4GjspTnXs)

## Tecnologias utilizadas

- MySQL 8.0
- PHP 8.0
- Apache 2
- [Docker](https://www.docker.com/)
- [Bootstrap](https://getbootstrap.com/)

## Como rodar

Há duas opções que o desenvolvedor pode escolher:

- Desenvolver utilizando as dependências instaladas diretamente na própria máquina ou
- Desenvolver utilizando Docker (forma **mais simples** e com **menos conflitos** de camadas e instalações de pacotes)

Contudo, é importante ressaltar que com o Docker **NÃO** será possível debugar o código utilizando o [xDebug](https://xdebug.org/).

### Etapas

1. Gere imagem da aplicação via Dockerfile:

```bash
docker build .
```

2. Execute os _multi-containers_ via Docker Compose:

```bash
docker-compose up -d
```

3. Execute o script SQL dentro do _container_ do MySQL via Docker:

```bash
docker exec -i mysql-container mysql -h mysql-container -u<<usuario>> -p<<senha>> <script.sql
```

4. Insira os dados das variáveis de ambiente no arquivo `.env.example` e, após, renomeie para `.env` apenas.

5. Abra o navegador e digite o URL do projeto que foi definido no arquivo de variáveis de ambiente na etapa anterior.
