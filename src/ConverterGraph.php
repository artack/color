<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Converter\ConverterInterface;

use function count;

use Fhaculty\Graph\Edge\Base;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Graphp\Algorithms\ShortestPath\Dijkstra;
use RuntimeException;
use Webmozart\Assert\Assert;

class ConverterGraph
{
    private Graph $converterGraph;

    public function __construct(Graph $converterGraph)
    {
        $this->converterGraph = $converterGraph;
    }

    /**
     * @return array<ConverterInterface>|ConverterInterface[]
     */
    public function getConverterChain(string $fromFqcn, string $toFqcn): array
    {
        $fromVertexId = (int) array_search($fromFqcn, Factory::getColors());
        $toVertexId = (int) array_search($toFqcn, Factory::getColors());

        $fromVertex = $this->findVertex($fromVertexId);
        $toVertex = $this->findVertex($toVertexId);

        $walk = (new Dijkstra($fromVertex))->getWalkTo($toVertex);

        $converters = [];

        /** @var Base $edge */
        foreach ($walk->getEdges() as $edge) {
            $converter = $edge->getAttribute(Factory::GRAPH_EDGE_KEY_CONVERTER);
            Assert::isInstanceOf($converter, ConverterInterface::class, sprintf('converter should be an instance of [%s]', ConverterInterface::class));

            $converters[] = $converter;
        }

        return $converters;
    }

    private function findVertex(int $key): Vertex
    {
        $vertices = array_filter($this->converterGraph->getVertices()->getVector(), static function (Vertex $vertex) use ($key) {
            return $vertex->getId() === $key;
        });

        if (1 !== count($vertices)) {
            throw new RuntimeException('did not find vertex by '.$key);
        }

        return array_pop($vertices);
    }
}
