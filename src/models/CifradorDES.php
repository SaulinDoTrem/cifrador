<?php

namespace Saulin\Cifrador\models;

class CifradorDES implements ICifrador{
    private const METODO_ENCRIPTACAO = 'des-cbc';
    private string $caractereDePrenchimento = '';

    public function __construct($caractereDePrenchimento) {
        $this->caractereDePrenchimento = $caractereDePrenchimento;
    }

    private function ajustarTamanhoChave($chave): string{
        $tamanhoChave = 8;
        $chaveAjustada = $chave;

        if (strlen($chaveAjustada) < $tamanhoChave) {
            $chaveAjustada = str_pad($chaveAjustada, $tamanhoChave, $this->caractereDePrenchimento);
        } elseif (strlen($chaveAjustada) > $tamanhoChave) {
            $chaveAjustada = substr($chaveAjustada, 0, $tamanhoChave); 
        }

        return $chaveAjustada; 
    }

    private function iniciar(): string {
        $vetorIniTamanho = openssl_cipher_iv_length(self::METODO_ENCRIPTACAO);
        return openssl_random_pseudo_bytes($vetorIniTamanho);
    }

    public function cifrar($texto, $senha): string{
        $chaveAjustada = $this->ajustarTamanhoChave($senha);
        $vetorInicializacao = $this->iniciar();

        $cifra = openssl_encrypt(
            $texto,
            self::METODO_ENCRIPTACAO,
            $chaveAjustada,
            OPENSSL_RAW_DATA,
            $vetorInicializacao
        );

      return base64_encode($vetorInicializacao . $cifra);
    }

    public function decifrar($cifra, $senha): string {
        $chaveAjustada = $this->ajustarTamanhoChave($senha);
        $dadosDecodificados = base64_decode($cifra,true);
        $vetorIniTamanho = openssl_cipher_iv_length(self::METODO_ENCRIPTACAO);

        $vetorInicializacao = substr($dadosDecodificados, 0, $vetorIniTamanho);
        $cifraPura = substr($dadosDecodificados, $vetorIniTamanho);

        $texto = openssl_decrypt(
            $cifraPura,
            self::METODO_ENCRIPTACAO,
            $chaveAjustada,
            OPENSSL_RAW_DATA,
            $vetorInicializacao
        );

        return $texto;
     }
}