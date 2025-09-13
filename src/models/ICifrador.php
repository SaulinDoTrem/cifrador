<?php
    namespace Saulin\Cifrador\models;

    interface ICifrador {
        function cifrar($texto, $senha): string;
        function decifrar($cifra, $senha): string;
    }