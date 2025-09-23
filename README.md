# Cifrador - Implementação de Cifras Clássicas

Trabalho da disciplina de **Segurança e Auditoria de Sistemas** do curso de **Bacharelado de Sistemas de Informação** do **CEFET/NF**. Esse trabalho consiste em fazer um programa que cifra um texto de um arquivo a partir de uma senha com transposição colunar e depois cifra novamente utilizando mesma senha com Viginère e DES, ao mesmo tempo que também faz o caminho inverso para decifrar a mensagem.

## Autores

- Saulo Klein Nery
- Otávio Mendonça da Costa.
- Mychelle Satyn da Conceição.

## Ambiente de desenvolvimento

Para executar o projeto é necessário ter previamente instalado/configurado no ambiente: 

- [PHP](https://www.php.net/) (Recomendado versão 7.4 ou superior)

- [Composer](https://getcomposer.org/)

## Como executar

1. **Clonar o repositório**

```bash
git clone https://github.com/SaulinDoTrem/cifrador.git
cd cifrador
```

2. **Instalar Dependências**

```bash
composer install
```

3. **Testar via terminal**

```bash
composer execute
```

## Testar cifragem com texto:

- Escolha a opção 1 (Cifrar com texto);
- Defina uma senha:
- Digite um texto (Aceita maiúsculas, minusculas e espaços);
- Anote a cifra gerada;

## Testar a decifragem com texto:

- Escolha a opção 3 (Decifrar com texto);
- Digite a senha;
- Digite a cifra anotada anteriormente;
- Confirme se o texto original foi recuperado;
- Caso deseje alterar a senha vai na opção 5 (Alterar senha);

## Testar cifragem com arquivo:

- Crie o arquivo texto.txt;
- Escolha a opção 2 (Cifrar com arquivo);
- Digite a senha desejada;
- Digite o caminho completo do arquivo texto.txt (Ex:C:\Users\myche\OneDrive\Documentos\SegurancaAuditoria\cifrador\texto.txt);
- A cifra será exibida e deve ser salva em no arquivo com o nome cifra.txt;

## Testar a decifragem com arquivo:

- Escolha a opção 4 (Decifrar com arquivo);
- Digite a senha correspondente;
- Digite o caminho completo do arquivo cifra.txt (Ex:C:\Users\myche\OneDrive\Documentos\SegurancaAuditoria\cifrador\cifra.txt);
- Confirme se o texto original foi recuperado;
