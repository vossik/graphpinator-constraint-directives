<?php

declare(strict_types = 1);

namespace Graphpinator\ConstraintDirectives;

abstract class FieldConstraintDirective extends \Graphpinator\Directive\Directive
    implements \Graphpinator\Directive\Contract\FieldDefinitionLocation, \Graphpinator\Directive\Contract\ArgumentDefinitionLocation
{
    public function __construct(
        protected ConstraintDirectiveAccessor $constraintDirectiveAccessor,
    ) {}

    final public function validateVariance(
        ?\Graphpinator\Value\ArgumentValueSet $biggerSet,
        ?\Graphpinator\Value\ArgumentValueSet $smallerSet,
    ) : void
    {
        if ($biggerSet === null) {
            return;
        }

        if ($smallerSet === null) {
            throw new \Exception();
        }

        $this->specificValidateVariance($biggerSet, $smallerSet);
    }

    public function resolveFieldDefinitionBefore(
        \Graphpinator\Value\ResolvedValue $parentValue,
        \Graphpinator\Value\ArgumentValueSet $arguments,
    ) : void
    {
        // nothing here
    }

    public function resolveFieldDefinitionAfter(
        \Graphpinator\Value\ResolvedValue $resolvedValue,
        \Graphpinator\Value\ArgumentValueSet $arguments,
    ) : void
    {
        // nothing here
    }

    public function resolveFieldDefinitionValue(
        \Graphpinator\Value\FieldValue $fieldValue,
        \Graphpinator\Value\ArgumentValueSet $arguments,
    ) : void
    {
        $this->validateValue($fieldValue->getValue(), $arguments);
    }

    public function resolveArgumentDefinition(
        \Graphpinator\Value\ArgumentValue $argumentValue,
        \Graphpinator\Value\ArgumentValueSet $arguments,
    ) : void
    {
        $this->validateValue($argumentValue->getValue(), $arguments);
    }

    abstract protected function validateValue(
        \Graphpinator\Value\Value $value,
        \Graphpinator\Value\ArgumentValueSet $arguments,
    ) : void;

    abstract protected function specificValidateVariance(
        \Graphpinator\Value\ArgumentValueSet $biggerSet,
        \Graphpinator\Value\ArgumentValueSet $smallerSet,
    ) : void;
}
