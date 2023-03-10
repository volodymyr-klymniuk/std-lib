<?php
declare(strict_types=1);

namespace VolodymyrKlymniuk\StdLib\Arrays;

class StubArrayComparator
{
    /**
     * @var ArrayComparator|StubArrayComparator
     */
    private $parent;

    /**
     * @param ArrayComparator|StubArrayComparator $parent
     */
    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return ArrayComparator|StubArrayComparator
     */
    public function compare()
    {
        return $this->parent;
    }

    /**
     * @return self
     */
    public function fail(): self
    {
        return $this;
    }

    /**
     * @return self
     */
    public function float(): self
    {
        return $this;
    }

    /**
     * @param string $key
     *
     * @return self
     */
    public function skip(string $key): self
    {
        return $this;
    }

    /**
     * @return self
     */
    public function skipNulls(): self
    {
        return $this;
    }

    /**
     * @param string $key
     *
     * @return self
     */
    public function subArray(string $key): self
    {
        return $this;
    }

    /**
     * @param string $key
     *
     * @return ArrayComparator|StubArrayComparator
     */
    public function subObject(string $key): self
    {
        return new StubArrayComparator($this);
    }

    /**
     * @param string        $key
     * @param \Closure|null $comparisonFoo
     *
     * @return StubArrayComparator
     */
    public function subArrayOfObject(string $key, \Closure $comparisonFoo = null): self
    {
        return $this;
    }
}