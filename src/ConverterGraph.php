<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Converter\Convertible;
use Fhaculty\Graph\Edge\Base;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Graphp\Algorithms\ShortestPath\Dijkstra;

class ConverterGraph
{
    private $converterGraph;

    public function __construct(Graph $converterGraph)
    {
        $this->converterGraph = $converterGraph;
    }

    /**
     * @param string $fromFqcn
     * @param string $toFqcn
     *
     * @return Convertible[]
     */
    public function getConverterChain(string $fromFqcn, string $toFqcn): array
    {
        $fromVertex = $this->findVertex($fromFqcn);
        $toVertex = $this->findVertex($toFqcn);

        $walk = (new Dijkstra($fromVertex))->getWalkTo($toVertex);

        $converters = [];

        /** @var Base $edge */
        foreach ($walk->getEdges() as $edge) {
            $converters[] = $edge->getAttribute(Factory::GRAPH_EDGE_KEY_CONVERTER);
        }

        return $converters;
    }

    /**
     * @param string $key
     *
     * @return Vertex
     *
     * @throws \RuntimeException
     */
    private function findVertex(string $key): Vertex
    {
        $vertices = array_filter($this->converterGraph->getVertices()->getVector(), function (Vertex $vertex) use ($key) {
            return $vertex->getId() === $key;
        });

        if (1 !== \count($vertices)) {
            throw new \RuntimeException('did not find vertex by '.$key);
        }

        return array_pop($vertices);
    }
}
