<?php
namespace JSantos\Model;

use Silex\Application;

abstract class Repository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $table = '';

    /**
    * @var array
    */
    protected $join = [];
    
    /**
     * @var int
     */
    protected $primaryKey;

    /**
     * Repository constructor.
     * @param Application|null $app
     */
    public function __construct(Application $app = null)
    {
        $this->app = !is_null($app)? $app : '';
    }

    /**
     * @param Application $app
     * @return Repository
     */
    public function setApplication(Application $app): self
    {
        $this->app = $app;
        return $this;
    }

    /**
     * @param array $fields
     * @return array
     */
    public function getAll(array $fields = ['*']) : array
    {
        $fields = implode(',',$fields);
        $sql = 'SELECT '.$fields.' FROM '.$this->table;
        $prepare = $this->app['connection']->prepare($sql);
        return self::run($prepare);
    }

    /**
     * @param int $id
     * @param array $fields
     * @return array
     */
    public function get(int $id, array $fields = ['*']) : array
    {
        $fields = implode(',',$fields);
        $sql = 'SELECT '.$fields.' FROM '.$this->table.' WHERE '.$this->primaryKey .' = '.$id;
        $prepare = $this->app['connection']->prepare($sql);
        return self::run($prepare, true);
    }

    /**
     * @param array $data
     * @return bool|int
     */
    public function insert(array $data)
    {
        $columns = array_keys($data);
        $fields = implode(',',$columns);
        $binds = ':'.implode(',:',$columns);

        $sql = 'INSERT INTO '.$this->table .'('.$fields.',created_at,updated_at) VALUES ('.$binds.',now(),now())';

        try {
            $this->app['connection']->beginTransaction();

            $prepare = $this->app['connection']->prepare($sql);

            foreach ($data as $key => $value) {
                $prepare->bindValue(':'.$key, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            }

            if (!$prepare->execute()) {
                return false;
            }
            $lastID = $this->app['connection']->lastInsertId();
            $this->app['connection']->commit();

        } catch (\PDOException $e) {
            $this->app['connection']->rollBack();
            return false;
        }
        return $lastID;
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id) : bool
    {
        $fields = '';

        foreach ($data as $key => $value) {
            $fields .= !empty($fields) ? ','.$key.'=:'.$key : $key.'=:'.$key;
        }

        $sql = 'UPDATE '.$this->table .' SET '.$fields. ',updated_at=now() WHERE '. $this->primaryKey .' = '.$id;

        try {
            $this->app['connection']->beginTransaction();

            $prepare = $this->app['connection']->prepare($sql);

            foreach ($data as $key => $value) {
                $prepare->bindValue(':' . $key, $value, is_int($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
            }

            $prepare->execute();

            $this->app['connection']->commit();

        } catch (\PDOException $e) {
            $this->app['connection']->rollBack();
            return false;
        }
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool
    {
        $sql = 'DELETE FROM '.$this->table.' WHERE '.$this->primaryKey .'='. $id;
        try {
            $prepare = $this->app['connection']->prepare($sql);
            $prepare->execute();
        } catch (\PDOException $e)  {
            return false;
        }
        return true;
    }

    /**
     * @param $prepare
     * @param bool $one
     * @return array
     */
    public static function run($prepare, $one = false) : array
    {
        $prepare->execute();

        if ($one) {
            return $prepare->fetch(\PDO::FETCH_ASSOC);
        }
        return $prepare->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $fields
     * @param int $id
     * @return array
     */
    public function runJoin(array $fields = ['*'], int $id) : array
    {
        $sql = 'SELECT '.implode(',', $fields).' FROM '. $this->table;

        if (count($this->join)) {
            $sql .= $table.$this->getJoin();
        }
        $sql .= ' WHERE '.$this->primaryKey.'='.$id;
        return self::run($sql);
    }

    /**
     * @param string $table
     * @param array $expression
     * @return Repository
     */
    public function setJoin(string $table, array $expression) : self
    {
        array_push($this->join, [$table => $expression]);
        return $this;
    }

    /**
     * @return string
     */
    public function getJoin() : string
    {
        $sql = '';
        foreach ($this->join as $tables) {
            foreach ($tables as $table => $expression) {
                foreach ($expression as $column => $foreignKey) {
                    $sql .= ' INNER JOIN '.$table.' ON '.$table.'.'.$column.'='.$foreignKey;
                }
            }
        }
        return $sql;
    }
}