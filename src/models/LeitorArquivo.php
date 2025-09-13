<?php   
    namespace Saulin\Cifrador\models;

    use Saulin\Cifrador\exceptions\LeituraArquivoException;

    class LeitorArquivo {
        private const EXTENSAO_ARQUIVO = 'txt';
        public static function lerArquivo(string $caminho): string {
            $partesCaminho = explode('.', $caminho);
            $extensao = array_pop($partesCaminho);

            if (!is_file($caminho)) {
                throw new LeituraArquivoException(
                    'Não foi possível ler o conteúdo do arquivo porque ele não existe.'
                );
            }

            if ($extensao !== self::EXTENSAO_ARQUIVO) {
                throw new LeituraArquivoException(
                    'Não foi possível ler o conteúdo do arquivo, apenas a extensão '. self::EXTENSAO_ARQUIVO .' é aceita.'
                );
            }

            if (!is_readable($caminho)) {
                throw new LeituraArquivoException(
                    'Não foi possível ler o conteúdo do arquivo.'
                );
            }

            $conteudoArquivo = file_get_contents($caminho);

            if (!$conteudoArquivo) {
                throw new LeituraArquivoException(
                    'Houve um erro ao tentar ler o arquivo.'
                );
            }

            return $conteudoArquivo;
        }
    }