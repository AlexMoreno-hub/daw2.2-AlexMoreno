<?php

abstract class Dato
{
}

trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class colores extends Dato
{
    use Identificable;

    private string $color;
    private string $descripcion;

    public function __construct(int $id, string $color, string $descripcion)
    {
        $this->setId($id);
        $this->setColor($color);
        $this->setDescripcion($descripcion);
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color)
    {
        $this->color = $color;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;
    }
}

