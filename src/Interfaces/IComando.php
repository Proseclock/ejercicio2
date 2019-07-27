<?php

namespace Comandos\Interfaces;

interface IComando
{
    function getNombre();

    function getParametros();

    function addParametros($parametros);

    function addParametro($parametro);

    function getRespuesta();

    function getUrl();

    function setUrl($url);
}