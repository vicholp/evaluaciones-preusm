<?php

namespace App\Utils;

use Illuminate\Support\Str;

class Rut
{
    private string $rut;
    private string $dv;

    public function __construct(string $rut, string $dv)
    {
        $this->rut = $rut;
        $this->dv = Str::upper($dv);
    }

    public function __toString(): string
    {
        return $this->getFullRut();
    }

    public function __toArray(): array
    {
        return [
            $this->rut,
            Str::upper($this->dv),
        ];
    }

    public function getRut(): string
    {
        return $this->rut;
    }

    public function getDv(): string
    {
        return Str::upper($this->dv);
    }

    public function getFullRut(): string
    {
        return $this->getRut() . '-' . $this->getDv();
    }

    public function isValid(): bool
    {
        return $this->getDv() == self::calculateDv($this->rut);
    }

    public static function calculateDv(string $rut): string
    {
        $rut = strrev($rut);
        $sum = 0;
        $multiplier = 2;

        for ($i = 0; $i < strlen($rut); ++$i) {
            $digit = (int) $rut[$i];
            $product = $digit * $multiplier;
            $sum += $product;
            $multiplier = $multiplier == 7 ? 2 : $multiplier + 1;
        }

        $mod = $sum % 11;
        $dv = 11 - $mod;

        if ($dv == 11) {
            return '0';
        }

        if ($dv == 10) {
            return 'K';
        }

        return (string) $dv;
    }

    public static function fromString(string $rut): self
    {
        $rut = str_replace('.', '', $rut);
        $rut = str_replace('-', '', $rut);

        $dv = substr($rut, -1);
        $rut = substr($rut, 0, -1);

        return new self($rut, Str::upper($dv));
    }

    public static function fromArray(array $row): self
    {
        $rut = $row[0];
        $dv = $row[1];

        return new self($rut, Str::upper($dv));
    }
}
