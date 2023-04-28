<?php declare(strict_types=1);

namespace Nuwave\Lighthouse\Schema\Directives;

use Illuminate\Contracts\Database\Query\Builder;
use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;

class WhereBetweenDirective extends BaseDirective implements ArgBuilderDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
"""
Verify that a column's value is between two values.

The type of the input value this is defined upon should be
an `input` object with two fields.
"""
directive @whereBetween(
  """
  Specify the database column to compare.
  Only required if database column has a different name than the attribute in your schema.
  """
  key: String
) repeatable on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
GRAPHQL;
    }

    public function handleBuilder(Builder $builder, $value): Builder
    {
        return $builder->whereBetween(
            $this->directiveArgValue('key', $this->nodeName()),
            $value,
        );
    }
}
