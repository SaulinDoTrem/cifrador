<?php
    class Programa {
        public $alfabeto;

        function __construct() {
            $this->alfabeto = range('A', 'Z');
            // DESCOMENTAR $this->alfabeto[] = ' ';
        }

        function transformarTexto($texto) {
    
        }
    
        function lerArquivo($nome_arquivo) {
            $texto = strtoupper(file_get_contents($nome_arquivo));
            return $texto;
        }
    
        function gerarMatrizTransposicao($senha, $texto) {
            $tamanhoTexto = strlen($texto);
            $tamanhoSenha = strlen($senha);
            $senhaSplitada = str_split($senha);
            $matriz = [];
    
            for($i = 0; $i < $tamanhoSenha; $i++) {
                $chave = $senhaSplitada[$i];
                $matriz[] = ['chave' => $chave, 'array' => []];
            }
    
            $offset = 0;
            $palavrasAdicionadas = 0;
            do {
                $textoParte = substr($texto, $offset, $tamanhoSenha);
                $tamanhoTextoParte = strlen($textoParte);
                if ($tamanhoTextoParte < $tamanhoSenha) {
                    $textoParte .= str_repeat('*', $tamanhoSenha - $tamanhoTextoParte);
                }
                $arrayTextoParte = str_split($textoParte);
    
                for ($i = 0; $i < $tamanhoSenha; $i++) {
                    $matriz[$i]['array'][] = $arrayTextoParte[$i];
                    
                }
    
                $offset += $tamanhoSenha;
                $palavrasAdicionadas++;
            } while ($offset < $tamanhoTexto);
    
            return $matriz;
        }
    
        function ordenarMatriz(&$matriz) {
            for($i = 0; $i < count($matriz); $i++) {
                for($j = 0; $j < count($matriz); $j++) {
                    $a = $matriz[$i];
                    $b = $matriz[$j];
                    if ($a['chave'] < $b['chave']) {
                        $matriz[$i] = $b;
                        $matriz[$j] = $a;
                    }
                }
            }
        }
    
        function transposicao($senha, $texto) {
            $matriz = $this->gerarMatrizTransposicao($senha, $texto);
            $this->ordenarMatriz($matriz);
            $cifra = '';
    
            foreach ($matriz as $i => $array) {
                $cifra .= join('', $array['array']);
            }
    
            return $cifra;
        }
    
        function gerarMatrizVigenere($senha) {
            $matriz = [];
    
            
            $senhaSplitada = str_split($senha);
            for($i = 0; $i < count($senhaSplitada); $i++) {
                $chave = $senhaSplitada[$i];
                if (!array_key_exists($chave, $matriz)) {
                    $alfabetoEspecifico = range($chave, 'Z');
                    //  DESCOMENTAR $alfabetoEspecifico[] = ' ';
                    if ($chave !== 'A') {
                        $letraAnterior = $this->pegarPosicaoNoAlfabeto($chave) - 1;
                        $restoAlfabeto = range('A', $this->alfabeto[$letraAnterior]);
                        $alfabetoEspecifico = array_merge($alfabetoEspecifico, $restoAlfabeto);
                    }
                    $matriz[$chave] = $alfabetoEspecifico;
                }
            }
    
            return $matriz;
        }
    
        function pegarPosicaoNoAlfabeto($letra) {
            return array_search($letra, $this->alfabeto);
        }
    
        function vigenere($matrizVigenere, $matriz) {
            $letrasEmVigenereDaColuna = [];
            foreach($matriz as $array) {
                $chave = $array['chave'];
                $letrasParaVigenere = $array['array'];
                $arrayVigenere = $matrizVigenere[$chave];
                foreach($letrasParaVigenere as $i => $letra) {
                    $pos = $this->pegarPosicaoNoAlfabeto($letra);
                    $letraEmVigenere = $arrayVigenere[$pos];
                    $letrasEmVigenereDaColuna[$i][] = $letraEmVigenere;

                    if ($i == 1) {
                        // echo var_dump($chave, $arrayVigenere, $letra);
                        // die();
                    }
                }
                // [ 'N', 'H', 'S' ]
            }

            $cifra = '';
            foreach ($letrasEmVigenereDaColuna as $letras) {
                $cifra.= join('', $letras);
            }

            return $cifra;
        }
    }

    
$p = new Programa();

$texto = str_replace(' ', '', strtoupper('o nilsinho vai passar todo mundo'));
$senha = strtoupper('intervalo');
$cifra = $p->transposicao('intervalo', $texto);
// echo var_dump(matrizVigenere($senha));
echo $cifra , PHP_EOL;
$matrizVigenere = $p->gerarMatrizVigenere($senha);
$matriz = $p->gerarMatrizTransposicao($senha, $cifra);
$vigenere = $p->vigenere($matrizVigenere, $matriz);
echo $vigenere, PHP_EOL;