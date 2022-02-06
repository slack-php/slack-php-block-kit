<?php

declare(strict_types=1);

namespace SlackPhp\BlockKit\Validation;

use Closure;
use Exception;
use SlackPhp\BlockKit\Component;
use SlackPhp\BlockKit\Reflector;

class Validator
{
    private ?Closure $preValidation = null;

    public function __construct(
        private Component $component,
    ) {}

    public function addPreValidation(callable $preValidation): void
    {
        $this->preValidation = $preValidation(...);
    }

    public function validate(?Context $context = null): void
    {
        $context ??= new Context();
        $context->add($this->component);

        try {
            $this->doPreValidation();

            $class = Reflector::component($this->component);
            $requirements = Reflector::requirementRules($class);

            foreach ($class->getProperties() as $classProperty) {
                $value = $classProperty->getValue($this->component);
                $field = Reflector::propertyAttribute($classProperty)?->field ?? $classProperty->getName();

                foreach (Reflector::propertyRules($classProperty) as $rule) {
                    $rule->check($this->component, $field, $value);
                }

                foreach ($requirements as $requirement) {
                    $requirement->track($field, $value);
                }

                $this->validateSubComponents($value, $context);
            }

            foreach ($requirements as $requirement) {
                $requirement->check($this->component);
            }
        } catch (ValidationException $prev) {
            throw $prev->withContext($context);
        } catch (Exception $prev) {
            $exception = new ValidationException('Unexpected error occurred during validation', [], $prev);
            throw $exception->withContext($context);
        }
    }

    private function doPreValidation(): void
    {
        $preValidate = $this->preValidation ?? null;

        if ($preValidate) {
            $preValidate();
        }
    }

    private function validateSubComponents(mixed $value, Context $context): void
    {
        if ($value instanceof Component) {
            $value->validate(clone $context);
        } elseif (is_iterable($value)) {
            foreach ($value as $index => $item) {
                if ($item instanceof Component) {
                    $itemContext = clone $context;
                    $context->addIndex($index);
                    $item->validate($itemContext);
                }
            }
        }
    }
}
