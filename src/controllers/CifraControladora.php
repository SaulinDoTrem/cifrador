<?php 
    namespace Saulin\Cifrador\controllers;
    use Saulin\Cifrador\exceptions\CifradorException;
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
        public const OPCAO_CIFRAR_POR_TEXTO = 1;
        public const OPCAO_CIFRAR_POR_ARQUIVO = 2;
        public const OPCAO_DECIFRAR_POR_TEXTO = 3;
        public const OPCAO_DECIFRAR_POR_ARQUIVO = 4;
        public const OPCAO_ALTERAR_SENHA = 5;
        public const OPCAO_SAIR = 6;

        public function __construct(array $cifradores, LinhaComandoVisao $visao) {
            $this->cifradores = $cifradores;
            $this->visao = $visao;
            $this->opcoes = [
                self::OPCAO_CIFRAR_POR_TEXTO => 'Cifrar com texto',
                self::OPCAO_CIFRAR_POR_ARQUIVO => 'Cifrar com arquivo texto',
                self::OPCAO_DECIFRAR_POR_TEXTO => 'Decifrar com texto',
                self::OPCAO_DECIFRAR_POR_ARQUIVO => 'Decifrar com arquivo texto',
                self::OPCAO_ALTERAR_SENHA => 'Alterar senha',
                self::OPCAO_SAIR => 'Sair'
            ];
            $this->sair = false;
        }

        private function cifrar(): string {
            $texto = $this->texto;
            foreach ($this->cifradores as $cifrador) {
                $texto = $cifrador->cifrar($texto, $this->senha);
                
               $nomeCifrador = basename(str_replace('\\', '/', get_class($cifrador)));
               $this->visao->exibirProcessoCifragem($nomeCifrador, $texto);
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

        private function executarOpcaoCifrar($textoPorArquivo): void {
            if (empty($this->senha)) {
                $this->senha = $this->visao->lerSenha();
            }
            $this->texto = $textoPorArquivo
                ? $this->visao->lerArquivoTexto()
                : $this->visao->lerTexto();
            $cifra = $this->cifrar();
            $this->visao->exibirCifra($cifra);
        }

        private function executarOpcaoDecifrar($cifraPorArquivo): void {
            if (empty($this->senha)) {
                $this->senha = $this->visao->lerSenha();
            }
            $this->cifra = $cifraPorArquivo
                ? $this->visao->lerArquivoCifra()
                : $this->visao->lerCifra();
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
                case self::OPCAO_CIFRAR_POR_TEXTO:
                    $this->executarOpcaoCifrar(false);
                    break;
                case self::OPCAO_CIFRAR_POR_ARQUIVO:
                    $this->executarOpcaoCifrar(true);
                    break;
                case self::OPCAO_DECIFRAR_POR_TEXTO:
                    $this->executarOpcaoDecifrar(false);
                    break;
                case self::OPCAO_DECIFRAR_POR_ARQUIVO:
                    $this->executarOpcaoDecifrar(true);
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
                    $this->visao->exibirMenu('Menu', $this->opcoes);
                    $opcaoEscolhida = $this->visao->lerOpcao(self::OPCAO_INVALIDA);
                    $this->executarOpcaoEscolhida($opcaoEscolhida);
                } catch (LeituraArquivoException|CifradorException $e) {
                    $this->visao->exibirErro($e->getMessage());
                } catch (Throwable $e) {
                    $this->visao->exibirErro('Houve um erro inesperado!');
                }
                 sleep(1);
            }
        }
    }