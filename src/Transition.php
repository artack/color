<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Color\Color;
use Artack\Color\Exception\InvalidArgumentException;
use Artack\Color\Transition\TransitionInterface;
use RuntimeException;

final readonly class Transition
{
    /**
     * @var array<int, TransitionInterface>
     */
    private array $transitions;

    /**
     * @param array<int, TransitionInterface> $transitions
     */
    public function __construct(array $transitions, private Converter $converter)
    {
        $this->transitions = array_values($transitions);
    }

    public function interpolate(string $fqcn, Color $startColor, Color $endColor, float $value, float $max): Color
    {
        if ($max < 0) {
            throw new InvalidArgumentException('max needs to be 0 or greater');
        }

        if ($value < 0 || $value > $max) {
            throw new InvalidArgumentException('value needs to be in the range of 0 to max');
        }

        if ($startColor::class !== $fqcn) {
            $startColor = $this->converter->convert($startColor, $fqcn);
        }

        if ($endColor::class !== $fqcn) {
            $endColor = $this->converter->convert($endColor, $fqcn);
        }

        return $this->getTransition($fqcn)->interpolate($startColor, $endColor, $value, $max);
    }

    private function getTransition(string $fqcn): TransitionInterface
    {
        foreach ($this->transitions as $transition) {
            if ($transition->supports($fqcn)) {
                return $transition;
            }
        }

        throw new RuntimeException('no transition found getTransition');
    }
}
