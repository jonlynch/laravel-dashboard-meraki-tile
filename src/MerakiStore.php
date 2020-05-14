<?php

namespace JonLynch\MerakiTile;

use Spatie\Dashboard\Models\Tile;

class MerakiStore
{
    private Tile $tile;

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("meraki");
    }

    public function setStatus(array $data): self
    {
        $this->tile->putData('meraki', $data);

        return $this;
    }

    public function status(): array
    {
        return $this->tile->getData('meraki') ?? [];
    }
}
