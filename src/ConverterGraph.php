<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Converter\ConverterInterface;
use Artack\Color\Exception\InvalidArgumentException;
use Fhaculty\Graph\Edge\Base;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Graphp\Algorithms\ShortestPath\Dijkstra;
use RuntimeException;

final readonly class ConverterGraph
{
    public function __construct(
        private Graph $converterGraph,
    ) {
    }

    /**
     * @return array<int, ConverterInterface>
     */
    public function getConverterChain(string $fromFqcn, string $toFqcn): array
    {
        $fromVertexId = (int) array_search($fromFqcn, Factory::getColors(), true);
        $toVertexId = (int) array_search($toFqcn, Factory::getColors(), true);

        $walk = (new Dijkstra($this->findVertex($fromVertexId)))->getWalkTo($this->findVertex($toVertexId));

        $converters = [];

        /** @var Base $edge */
        foreach ($walk->getEdges() as $edge) {
            $converter = $edge->getAttribute(Factory::GRAPH_EDGE_KEY_CONVERTER);

            if (!$converter instanceof ConverterInterface) {
                throw new InvalidArgumentException(sprintf('converter should be an instance of [%s]', ConverterInterface::class));
            }

            $converters[] = $converter;
        }

        return $converters;
    }

    private function findVertex(int $key): Vertex
    {
        $vertices = array_filter(
            $this->converterGraph->getVertices()->getVector(),
            static fn (Vertex $vertex): bool => $vertex->getId() === $key,
        );

        if (1 !== count($vertices)) {
            throw new RuntimeException('did not find vertex by '.$key);
        }

        return array_pop($vertices);
    }
}
