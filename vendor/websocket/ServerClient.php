<?php

declare(strict_types=1);

namespace vakata\websocket;

class ServerClient
{
    /**
     *
     * @param resource $socket
     * @param array<string,string> $headers
     * @param string $resource
     * @param array<string,string> $cookies
     * @param Server $server
     * @return void
     */
    public function __construct(
        $socket,
        $headers,
        $resource,
        $cookies,
        $server
    ) {
        $this->server = $server;
        $this->socket = $socket;
    }
    public function send(string $data): bool
    {
        return $this->server->send($this->socket, $data);
    }
    public function disconnect(): void
    {
        $this->server->disconnectClient($this->socket);
    }
}
