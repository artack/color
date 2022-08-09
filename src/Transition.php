<?php

declare(strict_types=1);

namespace Artack\Color;

use Artack\Color\Color\Color;
use Artack\Color\Transition\TransitionInterface;

use function get_class;

use RuntimeException;
use Webmozart\Assert\Assert;

class Transition
{
    /**
     * @var array<int, TransitionInterface>
     */
    private array $transitions = [];

    private Converter $converter;

    /**
     * @param array<int, TransitionInterface> $transitions
     */
    public function __construct(array $transitions, Converter $converter)
    {
        foreach ($transitions as $transition) {
            $this->addTransition($transition);
        }

        $this->converter = $converter;
    }

    private function addTransition(TransitionInterface $transition): void
    {
        $this->transitions[] = $transition;
    }

    public function interpolate(string $fqcn, Color $startColor, Color $endColor, float $value, float $max): Color
    {
        Assert::greaterThanEq($max, 0, 'max needs to be 0 or greater');
        Assert::range($value, 0, $max, 'value needs to be in the range of 0 to max');
        Assert::lessThanEq($value, $max, 'value needs to be less or equal than max');

        if (get_class($startColor) !== $fqcn) {
            $startColor = $this->converter->convert($startColor, $fqcn);
        }

        if (get_class($endColor) !== $fqcn) {
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
