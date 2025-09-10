<?php
    namespace Saulin\Cifrador\views;

    class LinhaComandoVisao {
        public string $senha;
        public string $texto;
        public string $cifra;

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

        public function lerSenha(): void {
            $this->senha = strtoupper($this->lerEntrada('Digite a senha: '));
        }

        public function lerTexto(): void {
            $this->texto = strtoupper($this->lerEntrada('Digite o texto: '));
        }

        public function lerCifra(): void {
            $this->cifra = strtoupper($this->lerEntrada('Digite a cifra: '));
        }

        public function exibirCifra(string $cifra): void {
            echo PHP_EOL, "Cifra: $cifra", PHP_EOL;
        }

        public function exibirTextoDecifrado(string $texto): void {
            echo PHP_EOL, "Texto decifrado: $texto", PHP_EOL;
        }

        public function exibirOpcaoInvalida(): void {
            echo PHP_EOL, 'Opção inválida. Tente novamente.', PHP_EOL;
        }

        public function exibirSaindo(): void {
            echo PHP_EOL, 'Saindo...', PHP_EOL;
        }

        private function lerEntrada($texto): string {
            echo PHP_EOL;
            $entrada = readline($texto);
            // echo PHP_EOL;
            return $entrada;
        }
    }