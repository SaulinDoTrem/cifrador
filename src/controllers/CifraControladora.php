<?php 
    namespace Saulin\Cifrador\controllers;
    use Saulin\Cifrador\exceptions\LeituraArquivoException;
    use Saulin\Cifrador\models\ICifrador;
    use Saulin\Cifrador\views\LinhaComandoVisao;
    use Throwable;

    class CifraControladora {
        private string $texto = '';
        private string $senha = '';
        private string $cifra = '';
        /**
         * Summary of cifradores
         * @var ICifrador[]
         */
        private array $cifradores;
        private LinhaComandoVisao $visao;
        private array $opcoes;
        private bool $sair;
        public const OPCAO_INVALIDA = 0;
        public const OPCAO_CIFRAR = 1;
        public const OPCAO_DECIFRAR = 2;
        public const OPCAO_ALTERAR_SENHA = 3;
        public const OPCAO_SAIR = 4;

        public function __construct(array $cifradores, LinhaComandoVisao $visao) {
            $this->cifradores = $cifradores;
            $this->visao = $visao;
            $this->opcoes = [
                self::OPCAO_CIFRAR => 'Cifrar',
                self::OPCAO_DECIFRAR => 'Decifrar',
                self::OPCAO_ALTERAR_SENHA => 'Alterar senha',
                self::OPCAO_SAIR => 'Sair'
            ];
            $this->sair = false;
        }

        private function cifrar(): string {
            $texto = $this->texto;
            foreach ($this->cifradores as $cifrador) {
                $texto = $cifrador->cifrar($texto, $this->senha);
            }
            return $texto;
        }

        private function decifrar(): string {
            $cifra = $this->cifra;
            foreach (array_reverse($this->cifradores) as $cifrador) {
                $cifra = $cifrador->decifrar($cifra, $this->senha);
            }
            return $cifra;
        }

        private function executarOpcaoCifrar(): void {
            if (empty($this->senha)) {
                $this->senha = $this->visao->lerSenha();
            }
            try {
                $this->texto = $this->visao->lerTexto();
            } catch (LeituraArquivoException $e) {
                
            }
            $cifra = $this->cifrar();
            $this->visao->exibirCifra($cifra);
        }

        private function executarOpcaoDecifrar(): void {
            if (empty($this->senha)) {
                $this->senha = $this->visao->lerSenha();
            }
            $this->cifra = $this->visao->lerCifra();
            $texto = $this->decifrar();
            $this->visao->exibirTextoDecifrado($texto);
        }

        private function executarOpcaoAlterarSenha(): void {
            if (empty($this->senha)) {
                $this->visao->exibirErro('Nenhuma senha foi definida. Defina uma senha ao cifrar/decifrar.');
                return;
            }
            $this->senha = $this->visao->lerSenha();
        }

        private function executarOpcaoSair(): void {
            $this->sair = true;
            $this->visao->exibirSaindo();
        }

        private function executarOpcaoInvalida(): void {
            $this->visao->exibirErro('Opção inválida. Tente novamente.');
        }

        private function executarOpcaoEscolhida($opcaoEscolhida): void {
            switch ($opcaoEscolhida) {
                case self::OPCAO_CIFRAR:
                    $this->executarOpcaoCifrar();
                    break;
                case self::OPCAO_DECIFRAR:
                    $this->executarOpcaoDecifrar();
                    break;
                case self::OPCAO_ALTERAR_SENHA:
                    $this->executarOpcaoAlterarSenha();
                    break;
                case self::OPCAO_SAIR:
                    $this->executarOpcaoSair();
                    break;
                default:
                    $this->executarOpcaoInvalida();
                    break;
            }
        }

        public function rodar() {
            while(!$this->sair) {
                try {
                    $this->visao->exibirMenu($this->opcoes);
                    $opcaoEscolhida = $this->visao->lerOpcao(self::OPCAO_INVALIDA);
                    $this->executarOpcaoEscolhida($opcaoEscolhida);
                    sleep(1);
                } catch (Throwable $e) {
                    $this->visao->exibirErro('Houve um erro inesperado!');
                }
            }
        }
    }