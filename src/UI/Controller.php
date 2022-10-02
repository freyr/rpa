<?php

namespace Freyr\RPA\UI;

use Freyr\RPA\BoundedContext\Application\RegisterMethaneLevelCommandHandler;
use Freyr\RPA\BoundedContext\DomainModel\Command\RegisterTemperatureCommand;


class Controller
{

    public function storeTemperature(
        $request,
        $response,
        RegisterMethaneLevelCommandHandler $handler): Response
    {
        $command = new RegisterTemperatureCommand($request->post('temperature'));
        $handler($command);

        return $response->withStatusCode(200);
    }
}
