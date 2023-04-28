<?php declare(strict_types=1);

namespace Nuwave\Lighthouse\Schema\Directives;

use Illuminate\Contracts\Database\Query\Builder;
use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;

class NeqDirective extends BaseDirective implements ArgBuilderDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
"""
Use the client given value to add an not-equal conditional to a database query.
"""
directive @neq(
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
        return $builder->where(
            $this->directiveArgValue('key', $this->nodeName()),
            '<>',
            $value,
        );
    }
}
