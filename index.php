<?php

class index
{

    public $dezenasPermitidas = array(6, 7, 8, 9, 10);
    private $dezenas;
    private $resultado;
    private $totalJogos;
    private $jogos;

    public function getDezenas()
    {
        return $this->dezenas;
    }

    public function setDezenas($dezenas)
    {
        $this->dezenas = $dezenas;
    }

    public function getResultado()
    {
        return $this->resultado;
    }

    public function setResultado($resultado)
    {
        $this->resultado = $resultado;
    }

    public function getTotalJogos()
    {
        return $this->totalJogos;
    }

    public function setTotalJogos($totalJogos)
    {
        $this->totalJogos = $totalJogos;
    }

    public function getJogos()
    {
        return $this->jogos;
    }

    public function setJogos($jogos)
    {
        $this->jogos = $jogos;
    }

    public function __construct($dezenas, $totalJogos)
    {
        if (!in_array($dezenas, $this->dezenasPermitidas)) {
            throw new Exception('A quantidade de dezenas deve ser igual ou maior a 6 e menor ou igual a 10.');
        }
        $this->setDezenas($dezenas);
        $this->setTotalJogos($totalJogos);
    }

    private function autoGetDezenas()
    {
        $jogo = array();
        for ($i = 0; $i < $this->getDezenas(); $i++) {
            $dezena = rand(1, 60);

            while (in_array($dezena, $jogo)) {
                $dezena = rand(1, 60);
            }

            $jogo[$i] = $dezena;
        }

        sort($jogo);

        return $jogo;
    }

    public function autoGenJogo()
    {
        $jogos = array();
        for ($i = 0; $i < $this->getTotalJogos(); $i++) {
            $jogos[$i] = $this->autoGetDezenas();
        }

        $this->setJogos($jogos);
    }

    public function autoPlay()
    {
        $jogo = array();
        for ($i = 0; $i < 6; $i++) {
            $dezena = rand(1, 60);

            while (in_array($dezena, $jogo)) {
                $dezena = rand(1, 60);
            }

            $jogo[$i] = $dezena;
        }

        sort($jogo);

        $this->setResultado($jogo);
    }

    public function index()
    {
        $this->autoGenJogo();
        $this->autoPlay();
        $jogos = $this->getJogos();
        $sorteado = $this->getResultado();
        echo '<div>Legenda:</div>';
        echo '<div style="background-color: #00f; color: #fff;">Dezenas selecionadas pelo cliente.</div>';
        echo '<div style="background-color: #0f0; color: #000;">Dezenas selecionadas pelo cliente que foram sorteadas.</div>';
        echo '<div style="background-color: #f00; color: #fff;">Dezenas sorteadas que não foram selecionadas pelo cliente.</div>';
        echo '<br/><table><tbody>';
        for ($i = 0; $i < $this->getTotalJogos(); $i++) {
            echo '<tr>';
            $qtdAcertos = 0;
            for ($x = 1; $x <= 60; $x++) {
                $auxClass = '';
                if (in_array($x, $jogos[$i]) && in_array($x, $sorteado)) {
                    $auxClass = ' style="background-color: #0f0; color: #000;"';
                    $qtdAcertos++;
                } else if (in_array($x, $jogos[$i])) {
                    $auxClass = ' style="background-color: #00f; color: #fff;"';
                } else if (!in_array($x, $jogos[$i]) && in_array($x, $sorteado)) {
                    $auxClass = ' style="background-color: #f00; color: #fff;"';
                }
                echo '<td' . $auxClass . '>' . $x . '</td>';
            }
            echo '<td style="background-color: gold;">O total de acertos nesse jogo é de ' . $qtdAcertos . ' dezenas</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    }
}

$classe = new index(10, 2);
$classe->index();