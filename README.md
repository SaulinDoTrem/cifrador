# Cifrador - Implementação de Cifras Clássicas

Trabalho da disciplina de **Segurança e Auditoria de Sistemas** do curso de **Bacharelado de Sistemas de Informação** do **CEFET/NF**. Esse trabalho consiste em fazer um programa que cifra um texto de um arquivo a partir de uma senha com transposição colunar e depois cifra novamente com a mesma senha com Viginère, ao mesmo tempo que também faz o caminho inverso para decifrar a mensagem.

## Autores

Saulo
Otávio
Mychelle Satyn da Conceição

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

## Testar cifragem:

- Escolha a opção 1 (Cifrar com texto);
- Defina uma senha:
- Digite um texto (Aceita maiúsculas, minusculas e espaços);
- Anote a cifra gerada;

## Testar a decifragem:

- Escolha a opção 3 (Decifrar com texto);
- Defina uma senha;
- Cole a cifra anotada anteriormente;
- Confirme se o texto original foi recuperado;

4. **Testar com arquivo**

## Testar cifragem:

- Edite o arquivo texto.txt na raiz do projeto;
- Escolha a opção 2 (Cifrar com arquivo);
- Digite a senha desejada;
- Digite o caminho completo do arquivo texto.txt (Ex:C:\Users\myche\OneDrive\Documentos\SegurancaAuditoria\cifrador\texto.txt);
- A cifra será exibida e deve ser salva em no arquivo cifra.txt na raiz do projeto;

## Testar a decifragem:

- Escolha a opção 4 (Decifrar com arquivo);
- Digite a mesma senha;
- Digite o caminho completo do arquivo cifra.txt (Ex:C:\Users\myche\OneDrive\Documentos\SegurancaAuditoria\cifrador\cifra.txt);
- Confirme se o texto original foi recuperado;
