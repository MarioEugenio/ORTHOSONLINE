<?php
namespace abstraction\xysLibrary\validate;

/**
 * Classe responsável por métodos de validação
 */
class Validate
{
    /**
     * valida e-mail válido
     *
     * @param string $email
     * @return boolean
     */
    public function validEmail ($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function validURL ($url)
    {
        return filter_var ($url, FILTER_VALIDATE_URL);
    }

    /**
     * valida data válida
     *
     * @param string $date
     * @return boolean
     */
    public function validDate ($date)
    {
        $data = explode("/","$date");
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	$res = checkdate($m,$d,$y);
	if ($res){
	   return TRUE;
	} else {
	   return FALSE;
	}
    }

    /**
     * Valida data se for maior que data atual
     *
     * @param \DateTime $date
     * @return boolean
     */
    public function validDateForDateNow (\DateTime $date)
    {
        $dateNow = time();

        if ($date->getTimestamp() >= $dateNow)
        {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * valida período entre datas
     *
     * @param string $dateIni
     * @param string $dateEnd
     * @param integer $period
     * @return integer
     */
    public function validDatePeriod (\DateTime $date1, \DateTime $date2)
    {
        //calculo timestam das duas datas
        $timestamp1 = $date1->getTimestamp();
        $timestamp2 = $date2->getTimestamp();

        //diminuo a uma data a outra
        $segundos_diferenca = $timestamp1 - $timestamp2;
        //echo $segundos_diferenca;

        //converto segundos em dias
        $dias_diferenca = $segundos_diferenca / (60 * 60 * 24);

        //obtenho o valor absoluto dos dias (tiro o possível sinal negativo)
        $dias_diferenca = abs($dias_diferenca);

        //tiro os decimais aos dias de diferenca
        $dias_diferenca = floor($dias_diferenca);

        return $dias_diferenca;
    }

    /**
     * valida valor monetário
     *
     * @param float $money
     * @return boolean
     */
    public function validMoney ($money)
    {
        return filter_var($money, FILTER_VALIDATE_FLOAT);
    }

    /**
     * valida CPF
     *
     * @param type $cpf
     * @return boolean
     */
    public function validCpf ($cpf)
    {
        $cpf = str_replace(array('.','-'),'',$cpf);
        $cpf = str_pad(preg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
            // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11
            || $cpf == '00000000000'
            || $cpf == '11111111111'
            || $cpf == '22222222222'
            || $cpf == '33333333333'
            || $cpf == '44444444444'
            || $cpf == '55555555555'
            || $cpf == '66666666666'
            || $cpf == '77777777777'
            || $cpf == '88888888888'
            || $cpf == '99999999999')
            {
            return false;
        }
            else
            {   // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    public function validAlphanumericUnderscore ($str)
    {
        return preg_match('/^[a-zA-Z0-9_]*$/',$str);
    }

    /**
     * valida CNPJ
     *
     * @param type $cnpj
     * @return boolean
     */
    public function validCnpj ($cnpj)
    {
        $cnpj = str_replace(array('.','-','/'),'',$cnpj);
        $cnpj = preg_replace ("@[./-]@", "", $cnpj);

        if (strlen ($cnpj) <> 14 or !is_numeric ($cnpj))
        {
            return 0;
        }

        if($cnpj == '00000000000000')
            return 0;

        $j = 5;
        $k = 6;
        $soma1 = "";
        $soma2 = "";

        for ($i = 0; $i < 13; $i++)
        {
            $j = $j == 1 ? 9 : $j;
            $k = $k == 1 ? 9 : $k;
            $soma2 += ($cnpj{$i} * $k);

            if ($i < 12)
            {
                $soma1 += ($cnpj{$i} * $j);
            }
            $k--;
            $j--;
        }

        $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
        $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;
        return (($cnpj{12} == $digito1) and ($cnpj{13} == $digito2));
    }

    /**
     * valida IP
     *
     * @param string $ip
     * @return boolean
     */
    public function validIp ($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /**
     *
     *
     * @param type $extensao
     * @param type $fileExtension
     * @return boolean
     */
    public function validExtensionFile ($extensao,$fileExtension)
    {
        $extensao = str_replace ( ".", "", $extensao );

        for($i = 0; $i <= sizeof ( $fileExtension ); $i ++) {

                if ($fileExtension [$i] == $extensao) {
                        $retorno = true;
                        break;

                } else {
                        $retorno = false;
                }
        }
        return $retorno;
    }
}