<?php

class usuarioModel extends Model
{
    public $id, $name, $username, $email;
    public $created_at, $updated_at;

    /**
     * Agregrar un registro de usuario
     */
    public function add()
    {
        $sql = 'INSERT INTO tests (name, username, email, created_at) VALUES(:name, :username, :email, :created_at)';
        $user = [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->created_at
        ];

        try {
            return ($this->id = parent::query($sql, $user)) ? $this->id : false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Actualizar el registro del usuario
     */
    public function update()
    {
        $sql = 'UPDATE tests SET name=:name, username=:username, email=:email WHERE id=:id';
        $user = [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email
        ];

        try {
            return (parent::query($sql, $user)) ? true : false;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
