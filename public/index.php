<?php

/**
 * Se mostrarán todos los errores
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Importar el fichero generado por composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

use Comandos\ComandoFactory;
use GuzzleHttp\Exception\GuzzleException;

$json = <<<JSON
    {
       "comandos":[
          {
             "nombre":"Comando1",
             "especificos":[
                {
                   "nombre":"Especifico1",
                   "valor":"ValorEspecifico1"
                },
                {
                   "nombre":"Especifico2",
                   "valor":"ValorEspecifico2"
                }
             ]
          },
          {
             "nombre":"Comando2",
             "especificos":[
                {
                   "nombre":"Especifico21",
                   "valor":"ValorEspecifico21"
                },
                {
                   "nombre":"Especifico22",
                   "valor":"ValorEspecifico22"
                }
             ]
          }
       ],
       "parametros":[
          {
             "nombre":"Nombre1",
             "valor":"Valor1"
          },
          {
             "nombre":"Nombre2",
             "valor":"Valor2"
          }
       ]
    }
JSON;

$comandoFactory = new ComandoFactory($json, [
    'Comando1' => 'http://www.ejemplo1.ejemplo',
    'Comando2' => 'http://www.ejemplo2.ejemplo'
]);

$respuestas = array();

foreach ($comandoFactory->getComandos() as $comando)
{
    try {

        $respuestas[] = $comando->getRespuesta();

    } catch (GuzzleException $ex) {

        //Salta una excepción de Guzzle
        echo $ex->getMessage();

    } catch (Exception $ex) {

        //Salta cualquier otra excepción
        echo $ex->getMessage();

    }

}
