<?php

namespace App\Factory;

use App\Entity\BudgetEntry;
use App\Repository\BudgetEntryRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<BudgetEntry>
 *
 * @method        BudgetEntry|Proxy                     create(array|callable $attributes = [])
 * @method static BudgetEntry|Proxy                     createOne(array $attributes = [])
 * @method static BudgetEntry|Proxy                     find(object|array|mixed $criteria)
 * @method static BudgetEntry|Proxy                     findOrCreate(array $attributes)
 * @method static BudgetEntry|Proxy                     first(string $sortedField = 'id')
 * @method static BudgetEntry|Proxy                     last(string $sortedField = 'id')
 * @method static BudgetEntry|Proxy                     random(array $attributes = [])
 * @method static BudgetEntry|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BudgetEntryRepository|RepositoryProxy repository()
 * @method static BudgetEntry[]|Proxy[]                 all()
 * @method static BudgetEntry[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static BudgetEntry[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static BudgetEntry[]|Proxy[]                 findBy(array $attributes)
 * @method static BudgetEntry[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static BudgetEntry[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class BudgetEntryFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'name'  => self::faker()->word(),
            'value' => self::faker()->numberBetween(5000, 10000),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this// ->afterInstantiate(function(BudgetEntry $budgetEntry): void {})
        ;
    }

    protected static function getClass(): string
    {
        return BudgetEntry::class;
    }
}
