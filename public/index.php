<?php
    require __DIR__.'/../vendor/autoload.php';

    use Saulin\Cifrador\controllers\CifraControladora;
    use Saulin\Cifrador\models\CifradorTransposicao;
    use Saulin\Cifrador\views\LinhaComandoVisao;

    error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

    $caractereDePreenchimento = '*';
    $visao = new LinhaComandoVisao();
    $cifrador = new CifradorTransposicao($caractereDePreenchimento);
    $cifradores = [$cifrador];
    $controladora = new CifraControladora($cifradores, $visao);
    $controladora->rodar();