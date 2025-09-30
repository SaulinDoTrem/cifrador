<?php
    namespace Saulin\Cifrador\views;

    use Saulin\Cifrador\models\LeitorArquivo;

    class LinhaComandoVisao {
        public function exibirMenu(string $nomeMenu, array $opcoes): void {
            $menuDetalhes = str_repeat('=', 3);
            echo PHP_EOL, $menuDetalhes, " $nomeMenu ", $menuDetalhes, PHP_EOL;
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
            return $this->lerEntrada('Digite o texto: ');
        }

        public function lerCifra(): string {
            return $this->lerEntrada('Digite a cifra: ');
        }

        public function lerArquivoTexto(): string {
            $nomeArquivo = $this->lerEntrada('Digite o nome do arquivo (caminho completo) que contém o texto desejado: ');
            return LeitorArquivo::lerArquivo($nomeArquivo);
        }

        public function lerArquivoCifra(): string {
            $nomeArquivo = $this->lerEntrada('Digite o nome do arquivo (caminho completo) que contém a cifra desejada: ');
            return LeitorArquivo::lerArquivo($nomeArquivo);
        }

        public function exibirCifra(string $cifra): void {
            $this->exibir("Cifra: '$cifra'");
        }

        public function exibirTextoDecifrado(string $texto): void {
            $this->exibir("Texto decifrado: '$texto'");
        }

        public function exibirProcessoCifragem(string $nomeCifrador, string $resultado): void {
            $this->exibir("=== Processo de Cifragem ===");
            $this->exibir("Cifrador: $nomeCifrador");
            $this->exibir("Texto cifrado: '$resultado'");
            $this->exibir(str_repeat('-', 30));
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