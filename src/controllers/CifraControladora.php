<?php
    namespace Saulin\Cifrador\controllers;
    use Saulin\Cifrador\models\ICifrador;
    use Saulin\Cifrador\views\LinhaComandoVisao;

    class CifraControladora {
        /**
         * Summary of cifradores
         * @var ICifrador[]
         */
        public array $cifradores;
        public LinhaComandoVisao $visao;
        public array $opcoes;
        public const OPCAO_INVALIDA = 0;
        public const OPCAO_CIFRAR = 1;
        public const OPCAO_DECIFRAR = 2;
        public const OPCAO_SAIR = 3;

        public function __construct(array $cifradores, LinhaComandoVisao $visao) {
            $this->cifradores = $cifradores;
            $this->visao = $visao;
            $this->opcoes = [
                self::OPCAO_CIFRAR => 'Cifrar',
                self::OPCAO_DECIFRAR => 'Decifrar',
                self::OPCAO_SAIR => 'Sair'
            ];
        }

        private function cifrar($texto, $senha): string {
            foreach ($this->cifradores as $cifrador) {
                $texto = $cifrador->cifrar($texto, $senha);
            }
            return $texto;
        }

        private function decifrar($cifra, $senha): string {
            foreach (array_reverse($this->cifradores) as $cifrador) {
                $cifra = $cifrador->decifrar($cifra, $senha);
            }
            return $cifra;
        }

        public function rodar() {
            $sair = false;
            while(!$sair) {
                $this->visao->exibirMenu($this->opcoes);
                $opcaoEscolhida = $this->visao->lerOpcao(self::OPCAO_INVALIDA);

                switch ($opcaoEscolhida) {
                    case self::OPCAO_CIFRAR:
                        $this->visao->lerSenha();
                        $this->visao->lerTexto();
                        $cifra = $this->cifrar($this->visao->texto, $this->visao->senha);
                        $this->visao->exibirCifra($cifra);
                        break;
                    case self::OPCAO_DECIFRAR:
                        $this->visao->lerSenha();
                        $this->visao->lerCifra();
                        $texto = $this->decifrar($this->visao->cifra, $this->visao->senha);
                        $this->visao->exibirTextoDecifrado($texto);
                        break;
                    case self::OPCAO_SAIR:
                        $sair = true;
                        $this->visao->exibirSaindo();
                        break;
                    default:
                        $this->visao->exibirOpcaoInvalida();
                        break;
                }
            }
        }
    }