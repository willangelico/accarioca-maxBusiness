<?php
/**
* Função para gerar senhas aleatórias
*
* @author    Thiago Belem <contato@thiagobelem.net>
*
* @param integer $tamanho Tamanho da senha a ser gerada
* @param boolean $maiusculas Se terá letras maiúsculas
* @param boolean $numeros Se terá números
* @param boolean $simbolos Se terá símbolos
*
* @return string A senha gerada
*/
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234567890';
$simb = '!@#$%*-';
$retorno = '';
$caracteres = '';

$caracteres .= $lmin;
if ($maiusculas) $caracteres .= $lmai;
if ($numeros) $caracteres .= $num;
if ($simbolos) $caracteres .= $simb;

$len = strlen($caracteres);
for ($n = 1; $n <= $tamanho; $n++) {
$rand = mt_rand(1, $len);
$retorno .= $caracteres[$rand-1];
}
return $retorno;
}

/**
 * Verifica chaves de arrays
 *
 * Verifica se a chave existe no array e se ela tem algum valor.
 * Obs.: Essa função está no escopo global, pois, vamos precisar muito da mesma.
 *
 * @param array  $array O array
 * @param string $key   A chave do array
 * @return string|null  O valor da chave do array ou nulo
 */
function chk_array ( $array, $key ) {
	// Verifica se a chave existe no array
	if ( isset( $array[ $key ] ) && ! empty( $array[ $key ] ) ) {
		// Retorna o valor da chave
		return $array[ $key ];
	}
	
	// Retorna nulo por padrão
	return null;
} // chk_array


/**
 * Classe que gera breadcrumb para bootstrap
 * 
 * @package Maxwill
 * @since 0.1
 */
 
class breadcrumb{

	private $way;

	function __construct(){
		//echo HOME_URI}";
	}

	public function setWay($array){
		$this->way[] = $array;
	}

	public function getWay(){
		echo '<ol class="breadcrumb">';
			$this->makeWay();
		echo '</ol>';
	}

	private function makeWay(){
		foreach ($this->way as $value) {
			$li = isset($value['li']) ? '<li class="'.$value['li'].'">' : '<li>';
			if(!empty($value['a'])){
				if(is_array($value['a'])){
					foreach ($value['a'] as $key => $value) {
						$a_prop .= ' '.$key.'="'.$value.'"';
					}
				}else{
					$a_prop = ' href='.$value['a'];
				}
				$a = '<a '.$a_prop.'>';
			}else{
				unset($a);
			}
			if(!empty($value['icon'])){
				$icon = '<i class="'.$value['icon'].'"></i>';
			}else{
				unset($icon);
			}
			$name = $value['name'];

			$a2 = isset($a) ? '</a>' : null;
			$li2 = isset($li) ? '</li>' : null;
			echo isset($li) ? $li : null;
				echo isset($a) ? $a : null;
					echo isset($icon) ? $icon : null;
					echo isset($name) ? $name : null;
				echo isset($a2) ? $a2 : null;
			echo isset($li2) ? $li2 : null;
			
		}
	}



}


	function seo($string){
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª|';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                  ';	
		$string = utf8_decode($string);
		$string = strtr($string, utf8_decode($a), $b);
		$string = strip_tags(trim($string));
		$string = str_replace(" ","-",$string);
		$string = str_replace(array("-----","----","---","--"),"-",$string);
		return strtolower(utf8_encode($string));
	}	

/**
 * Função para carregar automaticamente todas as classes padrão
 * Ver: http://php.net/manual/pt_BR/function.autoload.php.
 * Nossas classes estão na pasta library/classes/.
 * O nome do arquivo deverá ser NomeDaClasse.class.php.
 * Por exemplo: para a classe initMVC, o arquivo vai chamar initMVC.class.php
 */
function __autoload($class_name) {
	$file = ABSPATH . '/library/classes/' . $class_name . '.class.php';
	
	if ( ! file_exists( $file ) ) {
		require_once ABSPATH . '/application/views/errors/404.php';
		return;
	}
	
	// Inclui o arquivo da classe
    require_once $file;
} // __autoload
