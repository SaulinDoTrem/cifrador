<?php
    namespace Saulin\Cifrador\models;

    use Saulin\Cifrador\models\ICifrador;

    class CifradorVigenere implements ICifrador {
        private array $alfabeto;
        private int $qtdAlfabeto;
        private array $matriz;
        //private string $acentos = 'áàâãäéèêëíìîïóòôõöúùûüçñÁÀÂÃÄÉÈÊËÍÌÎÏÓÒÔÕÖÚÙÛÜÇÑ';
        //private string $pontuacao = '.,;:!?-()"\'';

        public function __construct($caractereDePreenchimento) {
            $this->alfabeto = array_merge(range('A', 'Z'), range('a', 'z'), [' ', $caractereDePreenchimento],   
            //mb_str_split($acentos, 1, 'UTF-8'),
            //mb_str_split($pontuacao, 1, 'UTF-8')
            );
            $this->qtdAlfabeto = count($this->alfabeto);
            $this->matriz = $this->gerarMatrizVigenere();
        }

        public function cifrar($texto, $senha): string {
            $cifra = '';
            $senhaSplitada = str_split($senha);
            $qtdSenha = strlen($senha);
            foreach (str_split($texto) as $i => $letra) {
                $letraSenha = $senhaSplitada[$i % $qtdSenha];
                $posicaoLetra = array_search($letra, $this->alfabeto);
                $cifra .= $this->matriz[$letraSenha][$posicaoLetra];
            }
            return $cifra;
        }

        public function decifrar($cifra, $senha): string {
            $texto = '';
            $senhaSplitada = str_split($senha);
            $qtdSenha = strlen($senha);
            foreach(str_split($cifra) as $i => $letra) {
                $letraSenha = $senhaSplitada[$i % $qtdSenha];
                $posicaoLetra = array_search($letra, $this->matriz[$letraSenha]);
                $texto .= $this->alfabeto[$posicaoLetra];
            }
            return $texto;
        }

        private function gerarMatrizVigenere(): array {
            $matriz = [];
            foreach ($this->alfabeto as $letra) {
                $matriz[$letra] = $this->gerarAlfabeto($letra);
            }
            return $matriz;
        }

        private function gerarAlfabeto($letra) {
            $inicial = array_search($letra, $this->alfabeto);
            $alfabetoDaLetra = [];

            for($i = $inicial, $j = 0; $j < $this->qtdAlfabeto; $i = ($i + 1) % $this->qtdAlfabeto, $j++) {
                $alfabetoDaLetra[] = $this->alfabeto[$i];
            }

            return $alfabetoDaLetra;
        }
    }