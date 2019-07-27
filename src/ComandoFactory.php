<?php

namespace Comandos;

/**
 * Class ComandoFactory
 * @package Comandos
 * Clase encargada de transformar el JSON a instancias de la clase Comando, listas para ser ejecutadas.
 */
class ComandoFactory
{
    /**
     * @var string
     */
    private $json;
    /**
     * @var Comando[] $comandos
     */
    private $comandos;
    /**
     * @var Parametro[]
     */
    private $parametrosGlobales;
    /**
     * @var array
     */
    private $comandosEndpoints;

    /**
     * ComandoFactory constructor.
     * @param string $json El JSON con toda la información sobre los comandos (el que se indica en el ejercicio)
     * @param array $comandosUrls El array asociativo de claves los nombres de comandos y de valores las urls correspondientes a sus respectivos microservicios
     */
    public function __construct($json, $comandosUrls)
    {
        $this->json = $json;
        $this->comandos = array();
        $this->parametrosGlobales = array();
        $this->comandosEndpoints = $comandosUrls;

        $this->_jsonAComandos();
        $this->_asignarUrlsAComandos();
    }

    /**
     * @return Comando[]
     */
    public function getComandos()
    {
        return $this->comandos;
    }

    private function _jsonAComandos()
    {
        $arrJson = json_decode($this->json, true);

        foreach ($arrJson['comandos'] as $comando)
        {
            $parametrosEspecificos = array();

            foreach ($comando['especificos'] as $parametroEspecifico){
                array_push($parametrosEspecificos, new Parametro($parametroEspecifico['nombre'], $parametroEspecifico['valor']));
            }

            array_push($this->comandos, new Comando($comando['nombre'], $parametrosEspecificos));
        }

        foreach ($arrJson['parametros'] as $parametroGlobal)
        {
            array_push($this->parametrosGlobales, new Parametro($parametroGlobal['nombre'], $parametroGlobal['valor']));
        }

        foreach ($this->comandos as $comando){
            $comando->addParametros($this->parametrosGlobales);
        }
    }

    private function _asignarUrlsAComandos()
    {
        foreach ($this->comandosEndpoints as $nombreComando => $url)
        {
            $comando = $this->_buscarComandoPorNombre($nombreComando);

            if ($comando) {
               $comando->setUrl($url);
            }
        }
    }

    private function _buscarComandoPorNombre($nombre)
    {
        foreach ($this->comandos as $comando)
        {
            if($comando->getNombre() == $nombre) return $comando;
        }

        return null;
    }
}