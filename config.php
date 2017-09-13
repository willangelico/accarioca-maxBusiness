<?php
/**
 * Configuração geral
 */

define( 'NAME', 'AC Carioca Materiais para Festas');

// Caminho para a raiz
define( 'ABSPATH', dirname( __FILE__ ) );

define( 'APPLICATION', '/application');

// Caminho para a pasta de uploads
define( 'UP_ABSPATH', ABSPATH . '/public/files' );

// URL da home
define( 'HOME_URI', '/' );


define( 'URL', 'https://www.accarioca.com.br' );

// Nome do host da base de dados
define( 'HOSTNAME', 'mysql796.umbler.com:41890' );

// Nome do DB
//define( 'DB_NAME', 'estefanb_bd' );
define( 'DB_NAME','accarioca-site');

// Usuário do DB
//define( 'DB_USER', 'estefanb_user' );
define( 'DB_USER', 'accarioca' );

// Senha do DB
//define( 'DB_PASSWORD', 'oQhxLvWF95Te' );
define( 'DB_PASSWORD', 'ac123carioca' );

// Charset da conexão PDO
define( 'DB_CHARSET', 'utf8' );

//define host de email
define( 'HOST_MAIL', 'webmail.umbler.com.br' );

//define porta de envio de email
define( 'PORTA_MAIL', 587);

// Se você estiver desenvolvendo, modifique o valor para true
define( 'DEBUG', false );

define( 'FOLDERS', 'admin');

date_default_timezone_set('America/Sao_Paulo');
/**
 * Não edite daqui em diante
 */

// Carrega o loader, que vai carregar a aplicação inteira
require_once ABSPATH . '/loader.php';
?>