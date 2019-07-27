<?php

namespace Comandos;

use Comandos\Interfaces\IComando;
use GuzzleHttp\Client;

/**
 * Class Comando
 * @package Comandos
 * Clase que representa un comando, que puede ser ejecutado en forma de llamada a un microservicio
 */
class Comando implements IComando
{
    private $nombre;
    private $parametros;
    private $url;

    /**
     * Comando constructor.
     * @param string $nombre
     * @param Parametro[] $parametros
     */
    public function __construct($nombre, $parametros)
    {
        $this->nombre = $nombre;
        $this->parametros = $parametros;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return Parametro[]
     */
    public function getParametros()
    {
        return $this->parametros;
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param Parametro[] $parametros
     */
    public function addParametros($parametros)
    {
        foreach ($parametros as $parametro)
        {
            $this->addParametro($parametro);
        }
    }

    /**
     * @param Parametro $parametro
     */
    public function addParametro($parametro)
    {
        foreach ($this->parametros as $miParametro) {
            //Si el comando ya tiene un parámetro con el mismo nombre en su lista, no se añade otra vez.
            if ($miParametro->getNombre() == $parametro->getNombre()) return;
        }

        array_push($this->parametros, $parametro);
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRespuesta()
    {
        $clientHttp = new Client();
        return $clientHttp->request('GET', $this->url, ['query' => ['comando' => $this->nombre, 'parametros' => implode(';', $this->parametros)]]);
    }
}