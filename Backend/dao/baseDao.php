<?php
require_once 'config.php';




class BaseDao {
   protected $table;
   protected $connection;


   public function __construct($table) {
       $this->table = $table;
       $this->connection = Database::connect();
   }

   protected function query($query, $params)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params)
    {
        $results = $this->query($query, $params);
        return reset($results);
    }

   public function getAll() {
       $stmt = $this->connection->prepare("SELECT * FROM " . $this->table);
       $stmt->execute();
       return $stmt->fetchAll();
   }


   public function getById($id) {
       $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE id = :id");
       $stmt->bindParam(':id', $id);
       $stmt->execute();
       return $stmt->fetch();
   }


   public function insert($data) {
       $columns = implode(", ", array_keys($data));
       $placeholders = ":" . implode(", :", array_keys($data));
       $sql = "INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders)";
       $stmt = $this->connection->prepare($sql);
       return $stmt->execute($data);
   }


   public function update($id, $data) {
       $fields = "";
       foreach ($data as $key => $value) {
           $fields .= "$key = :$key, ";
       }
       $fields = rtrim($fields, ", ");
       $sql = "UPDATE " . $this->table . " SET $fields WHERE id = :id";
       $stmt = $this->connection->prepare($sql);
       $data['id'] = $id;
       return $stmt->execute($data);
   }


   public function delete($id) {
       $stmt = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
       $stmt->bindParam(':id', $id);
       return $stmt->execute();
   }
   public function add($entity)
    {
        $query = "INSERT INTO " . $this->table_name . " (";
        foreach ($entity as $column => $value) {
            $query .= $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach ($entity as $column => $value) {
            $query .= ":" . $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ")";

        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity);
        $entity['id'] = $this->connection->lastInsertId();
        return $entity;
    }
}
?>
