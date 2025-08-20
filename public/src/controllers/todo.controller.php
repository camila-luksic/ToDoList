<?php
include_once __DIR__ . '/../models/todo.model.php';

class TodoController
{
    private $todo;

    public function __construct()
    {
        $this->todo = new toDo();
    }

    public function getAll()
    {
        $stmt = $this->todo->read();
        $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($todos) {
            return ["message" => "ok", "data" => $todos];
        } else {
            return ["message" => "No to-dos found.", "data" => []];
        }
    }

    public function create($data)
    {
        if (!empty($data['title'])) {
            $this->todo->title = $data['title'];
            $this->todo->description = $data['description'] ?? '';
            $this->todo->is_done = !empty($data['is_done']) ? 1 : 0;

            if ($this->todo->create()) {
                return ["message" => "To do was created."];
            } else {
                return ["message" => "Unable to create to do."];
            }
        } else {
            return ["message" => "Data incomplete."];
        }
    }

    public function update($id, $data)
    {
        if (!empty($data['title'])) {
            $this->todo->id = $id;
            $this->todo->title = $data['title'];
            $this->todo->description = $data['description'] ?? '';
            $this->todo->is_done = !empty($data['is_done']) ? 1 : 0;

            if ($this->todo->update()) {
                return ["message" => "To do was updated."];
            } else {
                return ["message" => "Unable to update to do."];
            }
        } else {
            return ["message" => "Data incomplete."];
        }
    }

    public function delete($id)
    {
        $this->todo->id = $id;

        if ($this->todo->delete()) {
            return ["message" => "To do was deleted."];
        } else {
            return ["message" => "Unable to delete to do."];
        }
    }
}
