<?php
    namespace Saulin\Cifrador\exceptions;

    use RuntimeException;

    class LeituraArquivoException extends RuntimeException {
        public function __construct($message) {
            parent::__construct($message);
        }
    }