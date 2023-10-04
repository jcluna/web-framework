<?php

class Db
{
    private $link, $engine, $host, $name, $user, $password, $charset;

    /**
     * Crear instancia de la clase Db
     * @return $this
     */
    public function __construct()
    {
        $this->engine = IS_LOCAL ? LDB_ENGINE : DB_ENGINE;
        $this->host = IS_LOCAL ? LDB_HOST : DB_HOST;
        $this->name = IS_LOCAL ? LDB_NAME : DB_NAME;
        $this->user = IS_LOCAL ? LDB_USR : DB_USR;
        $this->password = IS_LOCAL ? LDB_PWD : DB_PWD;
        $this->charset = IS_LOCAL ? LDB_CHARSET : DB_CHARSET;
        return $this;
    }

    /**
     * Abrir conexión a la base de datos
     * @return PDO
     */
    private function connect()
    {
        try {
            $this->link = new PDO(
                $this->engine .
                    ':host=' . $this->host .
                    ';dbname=' . $this->name .
                    ';charset=' . $this->charset,
                $this->user,
                $this->password
            );
            return $this->link;
        } catch (PDOException $e) {
            die(sprintf('No hay conexión a la base de datos, hubo un error: %s', $e->getMessage()));
        }
    }

    /**
     * Ejecutar instrucción SQL en la base de datos
     * @param string $sql
     * @param array $params
     * @return void
     */
    public static function query($sql, $params = [])
    {
        $db = new self();
        $link = $db->connect();
        $link->beginTransaction();
        $query = $link->prepare($sql);

        if (!$query->execute($params)) {
            $link->rollBack();
            $error = $query->errorInfo();
            throw new Exception($error[2]);
        }

        if (strpos($sql, 'SELECT') !== false) {
            return $query->rowCount() > 0 ? $query->fetchAll() : false;
        } elseif (strpos($sql, 'INSERT') !== false) {
            $id = $link->lastInsertId();
            if ($link->inTransaction()) {
                $link->commit();
            }
            return $id;
        } elseif (strpos($sql, 'UPDATE') !== false) {
            if ($link->inTransaction()) {
                $link->commit();
            }
            return true;
        } elseif (strpos($sql, 'DELETE') !== false) {
            if ($query->rowCount() > 0) {
                if ($link->inTransaction()) {
                    $link->commit();
                }
                return true;
            }

            if ($link->inTransaction()) {
                $link->rollBack();
            }
            return false;
        } else {
            if ($link->inTransaction()) {
                $link->commit();
            }

            return true;
        }
    }
}
