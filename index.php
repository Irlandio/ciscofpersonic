<?php
/**
 * CodeIgniter
 *
 * Uma estrutura de desenvolvimento de aplicativos de código aberto para PHP
 *
 * Este conteúdo é liberado sob a licença MIT (MIT)
 *
 * Copyright (c) 2014 - 2017, Instituto de Tecnologia de British Columbia
 *
 * Permissão é concedida gratuitamente a qualquer pessoa que obtenha uma cópia.
 * deste software e dos arquivos de documentação associados (o "Software"), para lidar
 * no Software sem restrições, incluindo, sem limitação, os direitos
 * usar, copiar, modificar, mesclar, publicar, distribuir, sublicenciar e / ou vender
 * cópias do Software e para permitir pessoas para as quais o Software é
 * fornecido para tal, sujeito às seguintes condições:
 *
 * O aviso de copyright acima e este aviso de permissão devem ser incluídos no
 * todas as cópias ou partes substanciais do Software.
 *
 * O SOFTWARE É FORNECIDO "COMO ESTÁ", SEM GARANTIA DE QUALQUER TIPO, EXPRESSA OU
 * IMPLÍCITA, INCLUINDO, MAS NÃO SE LIMITANDO ÀS GARANTIAS DE COMERCIALIZAÇÃO,
 * ADEQUAÇÃO A UM DETERMINADO FIM E NÃO VIOLAÇÃO. EM NENHUMA CIRCUNSTÂNCIA
 * AUTORES OU DETENTORES DOS DIREITOS AUTORAIS SER RESPONSABILIZADOS POR QUALQUER REIVINDICAÇÃO, DANOS OU OUTROS
 * RESPONSABILIDADE, SEJA EM AÇÃO DE CONTRATO, DELITO OU OUTRO, DECORRENTE DE,
 * FORA OU EM CONEXÃO COM O SOFTWARE OU O USO OU OUTRAS CONCESSÕES
 * O SOFTWARE.
 *
 * @package CodeIgniter
 * @author EllisLab Dev Team
 * @copyright Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright Copyright (c) 2014 - 2017, Instituto de Tecnologia de British Columbia (http://bcit.ca/)
 * @license http://opensource.org/licenses/ Licença MIT MIT
 * @link https://codeigniter.com
 * desde a versão 1.0.0
 * @filesource
 */

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * Você pode carregar diferentes configurações dependendo do seu
 * ambiente atual. Definir o ambiente também influencia
 * coisas como registro e relatório de erros.
 *
 * Isso pode ser definido para qualquer coisa, mas o uso padrão é:
 *
 * desenvolvimento
 * teste
 *     Produção
 *
 * NOTA: Se você alterá-los, altere também o código error_reporting () abaixo
 */
	define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
	break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		}
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
	$system_path = 'system';

/*
 *---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 *---------------------------------------------------------------
 *
 *Se você quiser que este front controller use um "aplicativo" diferente
 * Diretório que o padrão você pode definir seu nome aqui. O diretório
 * também pode ser renomeado ou realocado em qualquer lugar do servidor. Se você fizer,
 * use um caminho absoluto (completo) do servidor.
 * Para mais informações, consulte o guia do usuário:
 *
 * https://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
	$application_folder = 'application';

/*
 *---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 *---------------------------------------------------------------
 *
 *Se você quiser mover o diretório de visualização para fora do aplicativo
 * diretório, defina o caminho para isso aqui. O diretório pode ser renomeado
 * e realocado em qualquer lugar no seu servidor. Se em branco, será o padrão
 * para o local padrão dentro do seu diretório de aplicativos.
 * Se você mover isso, use um caminho de servidor absoluto (completo).
 *
 * NO TRAILING SLASH!
 */
	$view_folder = '';


/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normalmente você irá configurar seu controlador padrão no arquivo routes.php.
 * Você pode, no entanto, forçar um roteamento personalizado codificando um
 * Classe / função do controlador específico aqui. Para a maioria das aplicações, você
 * NÃO irá definir o seu roteamento aqui, mas é uma opção para aqueles
 * instâncias especiais em que você pode querer substituir o padrão
 * roteamento em um front controller específico que compartilha uma instalação comum de CI.
 *
 * IMPORTANTE: Se você definir o roteamento aqui, nenhum outro controlador será
 * chamavel. Em essência, essa preferência limita seu aplicativo a UM
 * controlador específico. Deixe o nome da função em branco se precisar
 * para chamar funções dinamicamente através do URI.
 *
 * Descomente o $ array de roteamento abaixo para usar este recurso
 * /
// O nome do diretório, relativo ao diretório "controllers". Deixe em branco
// se o seu controlador não estiver em um subdiretório dentro dos "controllers"
// $ routing ['diretório'] = '';

// O nome do arquivo de classe do controlador. Exemplo: mycontroller
// $ routing ['controller'] = '';

// A função do controlador que você deseja chamar.
// $ routing ['function'] = '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 */
	// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (($_temp = realpath($system_path)) !== FALSE)
	{
		$system_path = $_temp.DIRECTORY_SEPARATOR;
	}
	else
	{
		// Ensure there's a trailing slash
		$system_path = strtr(
			rtrim($system_path, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		).DIRECTORY_SEPARATOR;
	}

	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
		exit(3); // EXIT_CONFIG
	}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// Path to the system directory
	define('BASEPATH', $system_path);

	// Path to the front controller (this file) directory
	define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

	// Name of the "system" directory
	define('SYSDIR', basename(BASEPATH));

	// The path to the "application" directory
	if (is_dir($application_folder))
	{
		if (($_temp = realpath($application_folder)) !== FALSE)
		{
			$application_folder = $_temp;
		}
		else
		{
			$application_folder = strtr(
				rtrim($application_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
	{
		$application_folder = BASEPATH.strtr(
			trim($application_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}

	define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

	// The path to the "views" directory
	if ( ! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.'views';
	}
	elseif (is_dir($view_folder))
	{
		if (($_temp = realpath($view_folder)) !== FALSE)
		{
			$view_folder = $_temp;
		}
		else
		{
			$view_folder = strtr(
				rtrim($view_folder, '/\\'),
				'/\\',
				DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
			);
		}
	}
	elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
	{
		$view_folder = APPPATH.strtr(
			trim($view_folder, '/\\'),
			'/\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
	else
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}

	define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
require_once BASEPATH.'core/CodeIgniter.php';
