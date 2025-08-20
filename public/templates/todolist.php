<div class="container mt-5">
    <h1 class="mb-4">Lista de Tareas</h1>
    <button class="btn btn-primary mb-3" id="addTodoBtn">Agregar Tarea</button>

    <ul class="list-group" id="todoList">
        <?php if (!empty($todos)): ?>
            <?php foreach($todos as $todo): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center" id="todo-<?= $todo['id'] ?>">
                <div class="task-info">
                    <strong><?= htmlspecialchars($todo['title']) ?></strong> - <?= htmlspecialchars($todo['description']) ?>
                    <span class="status">[<?= $todo['is_done'] ? '✓ Hecho' : '✗ Pendiente' ?>]</span>
                </div>
                <div class="task-actions"
                     data-id="<?= $todo['id'] ?>"
                     data-title="<?= htmlspecialchars($todo['title']) ?>"
                     data-description="<?= htmlspecialchars($todo['description']) ?>"
                     data-is_done="<?= $todo['is_done'] ?>">
                    <button class="btn btn-sm btn-success me-1 toggle-btn">
                        <?= $todo['is_done'] ? 'Desmarcar' : 'Marcar' ?>
                    </button>
                    <button class="btn btn-sm btn-warning me-1 edit-btn">Editar</button>
                    <button class="btn btn-sm btn-danger delete-btn">Eliminar</button>
                </div>
            </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item text-center">No hay tareas para mostrar.</li>
        <?php endif; ?>
    </ul>
</div>