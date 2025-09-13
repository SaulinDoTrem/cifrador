<?php
    namespace Saulin\Cifrador\views;

    use Saulin\Cifrador\models\LeitorArquivo;

    class LinhaComandoVisao {
        public function exibirMenu(array $opcoes): void {
            $menuDetalhes = str_repeat('=', 3);
            echo PHP_EOL, $menuDetalhes, " Menu ", $menuDetalhes, PHP_EOL;
            foreach ($opcoes as $i => $opcao) {
                echo $i, ") $opcao", PHP_EOL;
            }
        }

        public function lerOpcao($opcaoInvalida): int {
            $opcao = $this->lerEntrada('Escolha uma opção: ');

            if (!is_numeric($opcao)) {
                return $opcaoInvalida;
            }

            return intval($opcao);
        }

        public function lerSenha(): string {
            return strtoupper($this->lerEntrada('Digite a senha: '));
        }

        public function lerTexto(): string {
            $nomeArquivo = $this->lerEntrada('Digite o nome do arquivo (caminho completo) que contém o texto desejado: ');
            return LeitorArquivo::lerArquivo($nomeArquivo);
        }

        public function lerCifra(): string {
            $nomeArquivo = $this->lerEntrada('Digite o nome do arquivo (caminho completo) que contém a cifra desejada: ');
            return LeitorArquivo::lerArquivo($nomeArquivo);
        }

        public function exibirCifra(string $cifra): void {
            $this->exibir("Cifra: '$cifra'");
        }

        public function exibirTextoDecifrado(string $texto): void {
            $this->exibir("Texto decifrado: '$texto'");
        }

        public function exibirSaindo(): void {
            $this->exibir('Saindo...');
        }

        private function lerEntrada($texto): string {
            echo PHP_EOL;
            $entrada = readline($texto);
            return $entrada;
        }

        public function exibirErro($mensagem): void {
            $this->exibir("Erro: $mensagem");
        }

        private function exibir($mensagem): void {
            echo PHP_EOL, $mensagem, PHP_EOL;
        }
    }