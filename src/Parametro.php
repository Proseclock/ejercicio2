<?php

namespace Comandos;

/**
 * Class Parametro
 * @package Comandos
 * Clase que representa un parámetro de un comando
 */
class Parametro
{
    private $nombre;
    private $valor;

    /**
     * Parametro constructor.
     * @param string $nombre
     * @param string $valor
     */
    public function __construct($nombre, $valor)
    {
        $this->nombre = $nombre;
        $this->valor = $valor;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->nombre}:{$this->valor}";
    }
}