<?php
/**
 * initMVC - Gerencia Models, Controllers e Views
 *
 * @package TutsupMVC
 * @since 0.1
 */
class initMVC
{
	/**
	* $folder
	*
	* Receberá o nome da pasta onde se encontra os arquivos
	* exemplo.com/admin/controlador/acao
	* @access private
	*
	*/

	private $folder;

	/**
	 * $controlador
	 *
	 * Receberá o valor do controlador (Vindo da URL).
	 * exemplo.com/controlador/
	 *
	 * @access private
	 */
	private $controlador;
	
	/**
	 * $acao
	 *
	 * Receberá o valor da ação (Também vem da URL):
	 * exemplo.com/controlador/acao
	 *
	 * @access private
	 */
	private $acao;
	
	/**
	 * $parametros
	 *
	 * Receberá um array dos parâmetros (Também vem da URL):
	 * exemplo.com/controlador/acao/param1/param2/param50
	 *
	 * @access private
	 */
	private $parametros;
	
	/**
	 * $not_found
	 *
	 * Caminho da página não encontrada
	 *
	 * @access private
	 */
	private $not_found = '/application/views/errors/404.php';
	
	/**
	 * Construtor para essa classe
	 *
	 * Obtém os valores do controlador, ação e parâmetros. Configura 
	 * o controlado e a ação (método).
	 */
	public function __construct () {
		
		// Obtém os valores do controlador, ação e parâmetros da URL.
		// E configura as propriedades da classe.
		$this->get_url_data();

		
		/**
		 * Verifica se o controlador existe. Caso contrário, adiciona o
		 * controlador padrão (controllers/home-controller.php) e chama o método index().
		 */
		if ( ! $this->controlador ) {
			

			// Adiciona o controlador padrão
			require_once ABSPATH . '/'.$this->folder.'/controllers/indexController.php';
			
			// Cria o objeto do controlador "indexController.php"
			// Este controlador deverá ter uma classe chamada indexController
			$this->controlador = new indexController();
			
			// Executa o método index()
			$this->controlador->index();
			
			// FIM :)
			return;
		
		}
		
		$this->controlador = $this->controlador.'Controller';
		// Se o arquivo do controlador não existir, não faremos nada
		if ( ! file_exists( ABSPATH . '/'.$this->folder.'/controllers/' . $this->controlador . '.php' ) ) {
			// Página não encontrada

			require_once ABSPATH . '/'.$this->folder.'/controllers/indexController.php';

			$contr = $this->controlador;

			$this->controlador = new indexController();
			
			// Executa o método index()
			$album = $this->controlador->existe_album($contr,$this->acao);

			if(!$album){

				require_once ABSPATH . $this->not_found;
				// FIM :)
				return;
			}
			array_unshift($this->parametros,$contr,$this->acao);

			require_once ABSPATH . '/'.$this->folder.'/controllers/albumController.php';

			$this->controlador = new albumController();
			$this->controlador->index($this->parametros);
			
			return;


		}
		
				
		// Inclui o arquivo do controlador
		require_once ABSPATH . '/'.$this->folder.'/controllers/' . $this->controlador . '.php';
		
		
		// Remove caracteres inválidos do nome do controlador para gerar o nome
		// da classe. Se o arquivo chamar "news-controller.php", a classe deverá
		// se chamar NewsController.
		$this->controlador = preg_replace( '/[^a-zA-Z]/i', '', $this->controlador );
		
		// Se a classe do controlador indicado não existir, não faremos nada
		if ( ! class_exists( $this->controlador ) ) {
			// Página não encontrada
			
			require_once ABSPATH . $this->not_found;

			// FIM :)
			return;
		} // class_exists
		
		
		// Cria o objeto da classe do controlador e envia os parâmentros
		
		$this->controlador = new $this->controlador( $this->parametros );
		
		// Remove caracteres inválidos do nome da ação (método)
		$this->acao = preg_replace( '/[^a-zA-Z]/i', '', $this->acao );
		
		// Se o método indicado existir, executa o método e envia os parâmetros
		if ( method_exists( $this->controlador, $this->acao ) ) {
			$this->controlador->{$this->acao}( $this->parametros );
			
			// FIM :)
			return;
		} // method_exists
		
		// Sem ação, chamamos o método index
		if ( ! $this->acao && method_exists( $this->controlador, 'index' ) ) {
			$this->controlador->index( $this->parametros );		
			
			// FIM :)
			return;
		} // ! $this->acao 
		
		// Página não encontrada
		require_once ABSPATH . $this->not_found;
		
		// FIM :)
		return;
	} // __construct
	
	/**
	 * Obtém parâmetros de $_GET['path']
	 *
	 * Obtém os parâmetros de $_GET['path'] e configura as propriedades 
	 * $this->controlador, $this->acao e $this->parametros
	 *
	 * A URL deverá ter o seguinte formato:
	 * http://www.example.com/controlador/acao/parametro1/parametro2/etc...
	 */
	public function get_url_data () {
		
		// Verifica se o parâmetro url foi enviado
		if ( isset( $_GET['url'] ) ) {
	
			// Captura o valor de $_GET['url']
			$url = $_GET['url'];
			
			// Limpa os dados
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            
			// Cria um array de parâmetros
			$url = explode('/', $url);
			
			// Configura as propriedades
			$folders = explode('|',FOLDERS);

			if(in_array(chk_array( $url, 0 ),$folders)){
				$this->folder = APPLICATION.'/'.chk_array( $url, 0 );
				$this->controlador  = chk_array( $url, 1 );
				$this->acao         = chk_array( $url, 2 );				
				unset( $url[2] );
			}else{				
				$this->controlador  = chk_array( $url, 0 );
				$this->acao         = chk_array( $url, 1 );
			}
			unset( $url[0] );
			unset( $url[1] );
			$this->parametros = array_values( $url );

			
			
			
			// DEBUG
			//

			// echo $this->folder . '<br>';
			// echo $this->controlador . '<br>';
			// echo $this->acao        . '<br>';
			// echo '<pre>';
			// print_r( $this->parametros );
			// echo '</pre>';

		}
		if( ! $this->folder ){
			$this->folder = APPLICATION;
		}
	
	} // get_url_data
	
} // class TutsupMVC