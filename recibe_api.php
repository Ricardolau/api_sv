<?php

header('content-type: application/json; charset=utf-8');
//en caso de json en vez de jsonp habría que habilitar CORS:
header("access-control-allow-origin: *");


define('JOOMLA_MINIMUM_PHP', '5.3.10');

$resultado ='No';
$respuesta = array();
if (version_compare(PHP_VERSION, JOOMLA_MINIMUM_PHP, '<'))
{
	die('Your host needs to use PHP ' . JOOMLA_MINIMUM_PHP . ' or higher to run this version of Joomla!');
}

/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);
define('JPATH_BASE','./../../');// Ya sabemos ruta porque lo tenemos instalado en administrador/apisv 
if (!defined('_JDEFINES'))
{
	require_once JPATH_BASE . '/includes/defines.php';
}


require_once JPATH_BASE .'/includes/framework.php';

// require_once JPATH_BASE . '/includes/helper.php';
// require_once JPATH_BASE . '/includes/toolbar.php';
 $Configuracion =  JFactory::getConfig();


// Inicializamos framework
$plugin = JPluginHelper::getPlugin('system', 'apisv'); 
// Obtenemos:
// Si es correcto un objecto.
// Si es incorrecto un  array.

// if (gettype($plugin) === 'object'){
	$pluginParams = new JRegistry();
	$pluginParams->loadString($plugin->params);
	$clave = $pluginParams->get('clave_apisv');
// }



$method = $_SERVER['REQUEST_METHOD'];
 
// tendremos que tratar esta variable para obtener el recurso adecuado de nuestro modelo.
$resource = $_SERVER['REQUEST_URI'];

// Dependiendo del método de la petición ejecutaremos la acción correspondiente.
if (gettype($plugin) === 'object') {
	switch ($method) {
		case 'GET':
			// código para método GET
			break;
		case 'POST':
			$arguments = $_POST;
			if ($_POST['key'] === $clave){
                // Cargo clases que me interesa y lo que quiero hacer.
                
			} else {
				// Quiere decir que la clave es incorrecta.
				$respuesta['error'] = 'La clave es incorrecta revis el plugin en Joomla';

			}
			// código para método POST
			break;
		case 'PUT':
			parse_str(file_get_contents('php://input'), $arguments);
			// código para método PUT
			break;

	}
$respuesta['post'] = $_POST;
$respuesta['QuienDevuelve']= $resource;
$respuesta['Datos'] = $resultado;
$respuesta['metodo_utilizado']=$method;
} else {
	// Quiere decir que no hay clave... 
	$respuesta['error'] = ' No existe clave en servidor';
}

echo json_encode($respuesta,true); // $response será un array con los datos de nuestra respuesta.
?>

