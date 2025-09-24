<?php

namespace Saulin\Cifrador\models;

use Saulin\Cifrador\exceptions\CifradorException;

class CifradorAES implements ICifrador {
    private const ALGORITMO_ENCRIPTACAO = 'aes-256-cbc';
    private const ALGORITMO_HASH = 'sha256';
    private const TAMANHO_HASH = 32;

    private function obterTamanhoVetorInicializacao($algoritmoDeEncriptacao): int|bool {
        return openssl_cipher_iv_length($algoritmoDeEncriptacao);
    }

    private function obterVetorInicializacao($algoritmoDeEncriptacao): string {
        return openssl_random_pseudo_bytes(
            $this->obterTamanhoVetorInicializacao($algoritmoDeEncriptacao)
        );
    }

    private function hash($cifraPura, $senha) {
        return hash_hmac(self::ALGORITMO_HASH, $cifraPura, $senha, true);
    }

    public function cifrar($texto, $senha): string{
        $vetorInicializacao = $this->obterVetorInicializacao(self::ALGORITMO_ENCRIPTACAO);

        $cifraPura = openssl_encrypt(
            $texto,
            self::ALGORITMO_ENCRIPTACAO,
            $senha,
            OPENSSL_RAW_DATA,
            $vetorInicializacao
        );

        $hash = $this->hash($cifraPura, $senha);

        return base64_encode($vetorInicializacao . $hash . $cifraPura);
    }

    public function decifrar($cifra, $senha): string {
        $dadosDecodificados = base64_decode($cifra,true);
        $tamanhoVetor = $this->obterTamanhoVetorInicializacao(self::ALGORITMO_ENCRIPTACAO);
        $vetorInicializacao = substr($dadosDecodificados, 0, $tamanhoVetor);
        $hashCifra = substr($dadosDecodificados, $tamanhoVetor, self::TAMANHO_HASH);
        $cifraPura = substr($dadosDecodificados, $tamanhoVetor+self::TAMANHO_HASH);       
        
        $hash = $this->hash($cifraPura, $senha);

        if (!hash_equals($hash, $hashCifra)) {
            throw new CifradorException("A senha utilizada para decifrar não foi a mesma que cifrou o texto.");
        }

        $texto = openssl_decrypt(
            $cifraPura,
            self::ALGORITMO_ENCRIPTACAO,
            $senha,
            OPENSSL_RAW_DATA,
            $vetorInicializacao
        );

        return $texto;
    }
}