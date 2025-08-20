<?php
include_once __DIR__ . '/../config/db.php';

class toDo
{
    private $pdo;

    public $id;
    public $title;
    public $description;
    public $is_done;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function read()
    {
        $query = "SELECT * FROM todos";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        $this->title = filter_var($this->title, FILTER_SANITIZE_STRING);
        $this->description = filter_var($this->description, FILTER_SANITIZE_STRING);
        $this->is_done = $this->is_done ? 1 : 0;

        $query = "INSERT INTO todos (title, description, is_done) VALUES (:title, :description, :is_done)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":is_done", $this->is_done, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update()
    {
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);
        $this->title = filter_var($this->title, FILTER_SANITIZE_STRING);
        $this->description = filter_var($this->description, FILTER_SANITIZE_STRING);
        $this->is_done = $this->is_done ? 1 : 0;

        if ($this->id > 0) {
            $query = "UPDATE todos SET title=:title, description=:description, is_done=:is_done WHERE id=:id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':is_done', $this->is_done, PDO::PARAM_INT);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function delete()
    {
        $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);

        if ($this->id > 0) {
            $query = "DELETE FROM todos WHERE id=:id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }
}