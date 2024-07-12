<?php
namespace App\Core\Domain;

use ReflectionClass;

class CoreModel {
    protected $table;
    protected $columns;

    public function __construct(string $table, array $columns) {
        $this->table = $table;
        $this->columns = $columns;
    }

    public function reflect(): array {
        $map = array();
        $destructure = new ReflectionClass(self::class);
        $classProperties = $destructure->getProperties();

        foreach($this->columns as $column) {
            $map = array();

            if (!array_key_exists($column, $classProperties)) continue; // Si las propiedades no tienen la clave de la columna (saltamos)
            if (!$classProperties[$column]) continue; // Si el valor del atributo es nulo (saltamos)

            $map[$column] = [
                'data' => $this->{$column},
                'key' => $column,
                'placeholder' => ":$column"
            ];

            return $map;
        }
    }
}

/* 
Controller.php || UseCase.php || CommandHandler.php

$repository = new UserRepository();
$user = new User();

$repository->save($user): bool;
$repository->update($user): bool;

$repository->delete($id): bool;
$repository->find($id): User;
$repository->findAll(): array<User>;

$repository->findUserIdByEmail($email): User;

*/

/* 
Repository.php (CoreModel $model)

save () {
    $data -> $model->reflect()
    $keys -> 
    $placeholders -> 
}

update () {
    "UPDATE $model::TABLE SET email = :email WHERE id = :id"
    placeholders [':email]
}

*/

/* 

const TABLE_COLUMNS = ['id', 'name', 'username', 'password']
foreach(self::TABLE_COLUMNS)

    // Revisar si la clave existe en el array de propiedades
    // Revisar si el valor no es nulo
        // Añadir al array de mapeado

[
    'id' => [
        'data' => null,
        'key' => 'id',
        'placeholder' => ':id'
    ],

]
*/