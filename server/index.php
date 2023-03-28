<?php

// Developed by: https://www.treinaweb.com.br/blog/programacao-de-sockets-em-php
// Adapted by: ewertondias.com

declare(strict_types=1);

error_reporting(E_ERROR | E_PARSE);

$server = stream_socket_server('tcp://127.0.0.1:7181', $errno, $errstr);
$connected = false;
$warned = false;
$idClientConnected = "";

if ($server === false) 
{
    fwrite(STDERR, "Error: $errno: $errstr");
    exit(1);
}

fwrite(STDERR, sprintf("Listening on: %s\n", stream_socket_get_name($server, false)));

while (true) 
{
    $connection = stream_socket_accept($server, 1, $clientAddress);
    if ($connection)
    {
        $idClientConnected = getrandmax()."-".getrandmax();;
        fwrite(STDERR, "Client [{$idClientConnected}] connected \n");
        $connected = true;
        $warned = false;

        while ($buffer = fread($connection, 2048)) 
        {
            if ($buffer !== '') { fwrite($connection, ""); }
        }        
        fclose($connection);
    } 
    else 
    {
        if (!$warned && $connected) { fwrite(STDERR, "Disconnected client [{$idClientConnected}]\n"); $warned = true; }
    }
}
    

