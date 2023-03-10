<?php

namespace VolodymyrKlymniuk\StdLib\FrequentField\Traits;

trait EmailTrait
{
    /**
     * @var null|string
     */
    protected $email;

    /**
     * @return null|string
     */
    public function getEmail():? string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     *
     * @return $this
     */
    public function setEmail(string $email = null)
    {
        $this->email = $email;

        return $this;
    }
}