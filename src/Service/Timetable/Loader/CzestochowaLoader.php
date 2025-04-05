<?php

namespace App\Service\Timetable\Loader;

use App\DTO\Loader\Arrival;
use App\DTO\Loader\DirectedStops;
use App\DTO\Loader\Direction;
use App\DTO\Loader\Line;
use App\DTO\Loader\Stop;
use App\Service\Http\Fetch;
use App\Service\Timetable\Loader as MainTimetablesLoader;
use PHPHtmlParser\Dom;

class CzestochowaLoader extends MainTimetablesLoader
{
    private const BASE_URL = 'https://www.czestochowa.pl/rozklady-jazdy';

    public function __construct(
        private Fetch $fetch,
    )
    {}

    public function getLines(): array
    {
        $response = $this->fetch->url(self::BASE_URL);
        $dom = new Dom;
        $dom->loadStr($response);
        $routes = $dom->find('a.route');
        $lines = [];

        foreach ($routes as $route) {
            $line = new Line(
                number: trim($route->text),
                url: $route->getAttribute('href'),
            );

            $lines[] = $line;
        }

        return $lines;
    }

    public function getLineStops(Line $line): array
    {
        $response = $this->fetch->url($line->url);
        $dom = new Dom;
        $dom->loadStr($response);
        $domStops = $dom->find('table.schedule');
        $directedStops = [];

        foreach ($domStops as $domStop) {
            $directionName = $domStop->find('thead tr th span')->text;
            $direction = new Direction(
                line: $line,
                name: trim($directionName),
            );
            $stops = [];

            $domStops = $domStop->find('a.bus-stop');

            foreach ($domStops as $domStop) {
                $stop = new Stop(
                    direction: $direction,
                    name: trim($domStop->text),
                    url: $domStop->getAttribute('href'),
                );

                $stops[] = $stop;
            }

            $directedStops[] = new DirectedStops(
                direction: $direction,
                stops: $stops,
            );
        }

        return $directedStops;
    }

    public function getStopArrivals(Stop $stop): array
    {
        $response = $this->fetch->url($stop->url);
        $dom = new Dom;
        $dom->loadStr($response);
        $arrivals = [];
        $domTableRows = $dom->find('table.schedule tbody tr');

        foreach ($domTableRows as $domTableRow) {
            $arrivalHourDom = $domTableRow->find('th[scope="row"]');
            $arrivalHour = $this->sanitizeNumberInput($arrivalHourDom->text);
            $arrivalMinutesDom = $domTableRow->find('td span.minute');
            foreach ($arrivalMinutesDom as $arrivalMinuteDom) {
                $arrivalMinutes = $this->sanitizeNumberInput($arrivalMinuteDom->text);
                $arrival = new Arrival(
                    stop: $stop,
                    hour: intval($arrivalHour),
                    minute: intval($arrivalMinutes),
                );
                $arrivals[] = $arrival;
            }
        }

        return $arrivals;
    }

    private function sanitizeNumberInput(string $input): string
    {
        $input = trim($input);
        return $input;
    }
}