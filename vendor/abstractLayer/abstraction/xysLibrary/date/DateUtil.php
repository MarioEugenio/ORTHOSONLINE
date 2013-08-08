<?php

namespace abstraction\xysLibrary\date;

/**
 * Classe responsável por processar datas
 */
class DateUtil
{

    /**
     * Semanas
     * @var array
     */
    public $week = array(
        0 => 'Domingo',
        1 => 'Segunda-Feira',
        2 => 'Terça-Feira',
        3 => 'Quarta-Feira',
        4 => 'Quinta-Feira',
        5 => 'Sexta-Feira',
        6 => 'Sábado'
    );

    /**
     * Meses
     * @var array
     */
    private $months = array(
        1  => "Janeiro",
        2  => "Fevereiro",
        3  => "Março",
        4  => "Abril",
        5  => "Maio",
        6  => "Junho",
        7  => "Julho",
        8  => "Agosto",
        9  => "Setembro",
        10 => "Outubro",
        11 => "Novembro",
        12 => "Dezembro"
    );

    /**
     * Converte um valor de data retornado pela aplicação em um objeto DateTime.
     *
     * @param string|null Entrada do usuário
     *
     * @return \DateTime|null
     */
    public function inputToDate ($input)
    {
        if ($input instanceof \DateTime) {
            return $input;
        }
        if (!trim($input)) {
            return NULL;
        }
        return \DateTime::createFromFormat("d/m/Y", $input);
    }

    /**
     * converte date string para datetime
     *
     * @param string $date
     *
     * @return \DateTime
     */
    public function convertDateTime ($date=NULL, $time=NULL)
    {
        if ($date) {
            $strTime = "";
            $date     = explode('/', $date);
            $formated = "{$date[2]}-{$date[1]}-{$date[0]}";

            if (isset($time))  {
                $strTime = " {$time}";
            }

            return new \DateTime($formated.$strTime);
        }

        return NULL;
    }

    /**
     * Método para operações de subtração e adição em datas
     *
     * @param string $date data formato dd/mm/aaaa
     * @param string $operation Operação a ser realizada. Operações: sub (subtração), sum (soma).
     * @param bool|string $where operações sobre: day, month, year.
     * @param integer $quant número de dias, meses ou anos a ser operado
     * @param boolean $return_format
     *
     * @return string
     */
    public function operations ($date, $operation, $where = FALSE, $quant, $return_format = FALSE)
    {
        // Verifica erros
        $warning = "<br>Warning! Date Operations Fail... ";
        if (!$date || !$operation) {
            return "$warning invalid or inexistent arguments<br>";
        } else {
            if (!($operation == "sub" || $operation == "-" || $operation == "sum" || $operation == "+"))
                return "<br>$warning Invalid Operation...<br>";
            else {
                // Separa dia, mês e ano
                // Determina a operação (Soma ou Subtração)
                ($operation == "sub" || $operation == "-") ? $op = "-" : $op = '';

                list($day, $month, $year) = split("/", $date);
                if ($where == "day")
                    $sum_day = $op . "$quant";
                if ($where == "month")
                    $sum_month = $op . "$quant";
                if ($where == "year")
                    $sum_year = $op . "$quant";

                // Determina aonde será efetuada a operação (dia, mês, ano)
                // Gera o timestamp
                $date = mktime(0, 0, 0, $month + $sum_month, $day + $sum_day, $year + $sum_year);

                // Retorna o timestamp ou extended
                ($return_format == "timestamp" || $return_format == "ts") ? $date = $date : $date = date("d/m/Y", "$date");

                // Retorna a data
                return $date;
            }
        }
    }

    /**
     * Método que retorna o tipo de intervalo por extenso
     *
     * @param string $typeInterval  M = Mês, W = Semana, D = Dia e Y = ano
     *
     * @return string
     */
    public function getTypeInterval ($typeInterval)
    {
        switch ($typeInterval) {
            case "M":
                $retorno = 'Mês';
                break;
            case "W":
                $retorno = 'Semana';
                break;
            case "D":
                $retorno = 'Dia';
                break;
            case "Y":
                $retorno = 'Ano';
                break;
        }

        return $retorno;
    }

    /**
     * Método que retorna o mês por extenso
     *
     * @param int $monthNumber
     *
     * @return String
     */
    public function getMonth ($monthNumber)
    {
        return $this->months[$monthNumber];
    }

    /**
     * calcula icício e fim da semana
     * @param $week
     * @param $year
     *
     * @return array
     */
    public function getWeekDates ($week,$year)
    {
        $start = date("d/m/Y", strtotime("{$year}-W{$week}-1"));
        $end = date("d/m/Y", strtotime("{$year}-W{$week}-7"));

        return array(
            "start" => $start,
            "end" => $end
        );
    }
}
