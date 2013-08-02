<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers&#65533;o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est&#65533; dispon&#65533;vel sob a Licen&#65533;a GPL dispon&#65533;vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc&#65533; deve ter recebido uma c&#65533;pia da GNU Public License junto com     |
// | esse pacote; se n&#65533;o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora&#65533;&#65533;es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo&#65533;o Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordena&#65533;&#65533;o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Ita&#65533;: Glauber Portella                        |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DIN&#65533;MICOS DO SEU CLIENTE PARA A GERA&#65533;&#65533;O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul&#65533;rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//

$date = explode(" ", $_GET['dt_vencimento']['date']);
$date = explode("-", $date[0]);
// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0.00;
$data_venc =   $date[2].'/'.$date[1].'/'.$date[0]; // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $_GET['vl_parcela']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = str_pad($_GET['sq_parcelas'],8,0,STR_PAD_LEFT);  // Nosso numero - REGRA: M&#65533;ximo de 8 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss&#65533;o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v&#65533;rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = utf8_decode($_GET['no_paciente']);
$dadosboleto["endereco1"] = $_GET['tx_endereco'];
$dadosboleto["endereco2"] = "";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "";
$dadosboleto["demonstrativo2"] = "";
$dadosboleto["demonstrativo3"] = "";
$dadosboleto["instrucoes1"] = (isset($_GET['tx_boleto'])? nl2br(utf8_decode($_GET['tx_boleto'])) : "");
$dadosboleto["instrucoes2"] = "";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "1";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURA&#65533;&#65533;O DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - ITA&#65533;
$dadosboleto["agencia"] = "0479"; // Num da agencia, sem digito
$dadosboleto["conta"] = "74199";	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "3"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - ITA&#65533;
$dadosboleto["carteira"] = "175";  // C&#65533;digo da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

// SEUS DADOS
$dadosboleto["identificacao"] = (isset($_GET['no_razao_social'])? utf8_decode($_GET['no_razao_social']) : "");
$dadosboleto["cpf_cnpj"] = (isset($_GET['nu_cnpj'])? utf8_decode($_GET['nu_cnpj']) : "");
$dadosboleto["endereco"] = "AV. Castanheira Lote 1250 Lj.2";
$dadosboleto["cidade_uf"] = "Águas Claras / DF";
$dadosboleto["cedente"] = (isset($_GET['no_razao_social'])? utf8_decode($_GET['no_razao_social']) : "");

// N&#65533;O ALTERAR!
include("include/funcoes_itau.php"); 
include("include/layout_itau.php");
?>
