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

class Categoria extends Dato
{
    use Identificable;

    private string $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }
}

class persona extends Dato
{
    use Identificable;

    private string $nombre;
    private string $Apellidos;
    private bool $estrella;
    private int $personaCategoriaId;


    public function __construct(int $id, string $nombre, string $Apellidos, bool $estrella , int $personaCategoriaId)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setApellidos($Apellidos);
        $this->setEstrella($estrella);
        $this->setPersonaCategoriaId($personaCategoriaId);

    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->Apellidos;
    }

    public function setApellidos(string $Apellidos)
    {
        $this->Apellidos = $Apellidos;
    }

    public function getEstrella(): bool
    {
        return $this->estrella;
    }

    public function setEstrella(bool $estrella)
    {
        $this->estrella = $estrella;
    }

    public function getPersonaCategoriaId(): int
    {
        return $this->personaCategoriaId;
    }

    public function setPersonaCategoriaId(int $personaCategoriaId)
    {
        $this->personaCategoriaId = $personaCategoriaId;
    }


}