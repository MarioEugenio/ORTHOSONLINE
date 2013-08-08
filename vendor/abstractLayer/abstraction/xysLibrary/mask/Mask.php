<?php
namespace abstraction\xysLibrary\mask;

/**
 * Classe responsável por criar mascaras
 */
class Mask
{
    const MASK_CPF  = '999.999.999-99';
    const MASK_CNPJ = '999.999.999/9999-99';
    const MASK_FONE = '(##)####-####';
    const MASK_CEP  = '99999-999';

    /**
     *
     * @param type $cpf
     */
    public function maskCPF ($cpf)
    {
        return substr($cpf,0,3).'.'.substr($cpf,3,3).'.'.substr($cpf,6,3).'-'.substr($cpf,9,2);
    }

    /**
     *
     * @param type $cnpj
     */
    public function maskCNPJ ($cnpj)
    {
        return substr($cnpj,0,2).'.'.substr($cnpj,2,3).'.'.substr($cnpj,5,3).'/'.substr($cnpj,8,4).'-'.substr($cnpj,12,2);
    }

    /**
     *
     * @param type $fone
     */
    public function maskPhone ($fone)
    {
        $this->mountMask(self::MASK_FONE, $fone);
    }

    /**
     *
     * @param type $money
     */
    public function maskMoney ($money)
    {

    }

    /**
     *
     * @param type $cep
     */
    public function maskCEP ($cep)
    {
        return substr($cep, 0,5).'-'.substr($cep, -3);
    }

    /**
     *
     * @param type $date
     * @param type $format
     */
    public function dateFormat ($date, $format)
    {

    }

    /**
     *
     * @param type $string
     * @param type $format
     */
    public function mountMask ($format, $string)
    {
            if (!empty($string)) {
            $string = str_replace(" ","",$string);
            for($i=0;$i<strlen($string);$i++)
            {
                $format[strpos($format,"#")] = $string[$i];
            }

            return $format;
        }

        return ;
    }

    /**
     * remove mascara da string
     *
     * @param string $string
     * @return string
     */
    public function unicDigits ($string)
    {
        return preg_replace("/[^0-9]/","", $string);
    }

    public function unicString ($string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

    public function unicFloat ($string)
    {
        return filter_var($string, FILTER_SANITIZE_NUMBER_FLOAT);
    }
}