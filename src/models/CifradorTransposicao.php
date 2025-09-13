<?php
    namespace Saulin\Cifrador\models;

    class CifradorTransposicao implements ICifrador {
        private $caractereDePreenchimento;

        public function __construct($caractereDePreenchimento) {
            $this->caractereDePreenchimento = $caractereDePreenchimento;
        }

        public function cifrar($texto, $senha): string {
            $matriz = $this->gerarMatrizTransposicao($senha, $texto);
            $this->ordenarMatriz($matriz);

            $cifra = '';

            foreach($matriz as $coluna) {
                $letras = $coluna['letras'];
                for($i = 1; $i < count($letras); $i++) {
                    $cifra .= $letras[$i];
                }
            }

            return $cifra;
        }
        public function decifrar($cifra, $senha): string {
            $matriz = $this->gerarMatrizTransposicaoInversa($cifra, $senha);
            $this->ordenarMatrizPelaPosicaoOriginal($matriz);

            $texto = '';

            $tamanhoSenha = strlen($senha);
            for($i = 0; $i < strlen($cifra); $i++) {
                $texto .= $matriz[($i % $tamanhoSenha)]['letras'][($i / $tamanhoSenha) + 1];
            }

            return str_replace($this->caractereDePreenchimento, '', $texto);
        }


        private function gerarCabecalhoMatrizTransposicao($senha): array {
            $matriz = [];
            foreach(str_split($senha) as $i => $letra) {
                $matriz[] = ['posicaoOriginal' => $i, 'letras' => [$letra]];
            }

            return $matriz;
        }

        private function gerarMatrizTransposicao($senha, $texto): array {
            $tamanhoTexto = strlen($texto);
            $tamanhoSenha = strlen($senha);
            $matriz = $this->gerarCabecalhoMatrizTransposicao($senha);
    
            $offset = 0;
            $palavrasAdicionadas = 0;
            do {
                $textoParte = substr($texto, $offset, $tamanhoSenha);
                $this->completarComCaractereDePreenchimento($textoParte, $tamanhoSenha);
                $arrayTextoParte = str_split($textoParte);
    
                for ($i = 0; $i < $tamanhoSenha; $i++) {
                    $matriz[$i]['letras'][] = $arrayTextoParte[$i];
                }
                $offset += $tamanhoSenha;
                $palavrasAdicionadas++;
            } while ($offset < $tamanhoTexto);

            return $matriz;
        }

        private function completarComCaractereDePreenchimento(&$texto, $tamanhoSenha): void {
            $tamanhoTexto = strlen($texto);
            if ($tamanhoTexto < $tamanhoSenha) {
                $texto .= str_repeat($this->caractereDePreenchimento, $tamanhoSenha - $tamanhoTexto);
            }
        }

        private function ordenarMatriz(&$matriz): void {
            $qtdMatriz = count($matriz);
            for($i = 0; $i < $qtdMatriz; $i++) {
                for($j = 0; $j < $qtdMatriz; $j++) {
                    $a = $matriz[$i];
                    $b = $matriz[$j];
                    if ($a['letras'][0] < $b['letras'][0]) {
                        $matriz[$i] = $b;
                        $matriz[$j] = $a;
                    }
                }
            }
        }

        private function gerarMatrizTransposicaoInversa($cifra, $senha): array {
            $tamanhoSenha = strlen($senha);
            $tamanhoCifra = strlen($cifra);

            $matriz = $this->gerarCabecalhoMatrizTransposicao($senha);
            $qtdLinhasMatriz = $tamanhoCifra / $tamanhoSenha;
            $this->ordenarMatriz($matriz);

            $offset = $tamanhoCifra;
            $i = 0;
            do {
                $cifraParte = substr($cifra, $offset - $qtdLinhasMatriz, $qtdLinhasMatriz);
                $posicaoCifraParte = $tamanhoSenha - $i - 1;

                foreach(str_split($cifraParte) as $letra) {
                    $matriz[$posicaoCifraParte]['letras'][] = $letra;
                }

                $offset -= $qtdLinhasMatriz;
                $i++;
            } while ($offset > 0);

            return $matriz;
        }

        private function ordenarMatrizPelaPosicaoOriginal(&$matriz): void {
            $qtdMatriz = count($matriz);
            for($i = 0; $i < $qtdMatriz; $i++) {
                for($j = 0; $j < $qtdMatriz; $j++) {
                    $a = $matriz[$i];
                    $b = $matriz[$j];
                    if ($a['posicaoOriginal'] < $b['posicaoOriginal']) {
                        $matriz[$i] = $b;
                        $matriz[$j] = $a;
                    }
                }
            }
        }
    }