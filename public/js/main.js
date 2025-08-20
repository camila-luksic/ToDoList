document.addEventListener('DOMContentLoaded', () => {

    const apiUrl = 'http://localhost:8081/todoApp/public/todos';
    const todoList = document.getElementById('todoList');
    const addModalElement = document.getElementById('addModal');
    const editModalElement = document.getElementById('editModal');


    async function apiRequest(method, endpoint, data = null) {
        const options = {
            method: method,
            headers: {'Content-Type': 'application/json'}
        };
        if (data) options.body = JSON.stringify(data);
        const url = `${apiUrl}${endpoint}`;
        try {
            const response = await fetch(url, options);
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Error en la solicitud a la API.');
            }
            if (response.status === 204) return null;
            return await response.json();
        } catch (error) {
            console.error('Error de API:', error);
            alertify.error('Hubo un error: ' + error.message);
            throw error;
        }
    }

    function createTodoElement(todo) {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.id = `todo-${todo.id}`;
        li.innerHTML = `
            <div class="task-info">
                <strong>${todo.title}</strong> - ${todo.description}
                <span class="status">[${todo.is_done ? '✓ Hecho' : '✗ Pendiente'}]</span>
            </div>
            <div class="task-actions"
                 data-id="${todo.id}"
                 data-title="${todo.title}"
                 data-description="${todo.description}"
                 data-is_done="${todo.is_done}">
                <button class="btn btn-sm btn-success me-1 toggle-btn">
                    ${todo.is_done ? 'Desmarcar' : 'Marcar'}
                </button>
                <button class="btn btn-sm btn-warning me-1 edit-btn">Editar</button>
                <button class="btn btn-sm btn-danger delete-btn">Eliminar</button>
            </div>
        `;
        return li;
    }

    function updateTodoElement(id, newTitle, newDescription, newIsDone) {
        const li = document.getElementById(`todo-${id}`);
        if (!li) return;
        li.querySelector('.task-info').innerHTML = `<strong>${newTitle}</strong> - ${newDescription}<span class="status">[${newIsDone ? '✓ Hecho' : '✗ Pendiente'}]</span>`;
        const actionsDiv = li.querySelector('.task-actions');
        actionsDiv.dataset.title = newTitle;
        actionsDiv.dataset.description = newDescription;
        actionsDiv.dataset.is_done = newIsDone;
        const toggleBtn = li.querySelector('.toggle-btn');
        toggleBtn.innerText = newIsDone ? 'Desmarcar' : 'Marcar';
    }

    document.getElementById('addForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const title = document.getElementById('addTitle').value.trim();
        const description = document.getElementById('addDescription').value.trim();
        if (!title) {
            alertify.warning('El título es obligatorio.');
            return;
        }
        try {
            const todo = await apiRequest('POST', '', { title, description, is_done: 0 });
            if (todo) {
                const newLi = createTodoElement(todo.data);
                todoList.appendChild(newLi);
                alertify.success('Tarea agregada exitosamente.');
                document.getElementById('addModal').classList.remove('show');
                document.querySelector('.modal-backdrop').remove();
                document.body.classList.remove('modal-open');
                document.getElementById('addForm').reset();
            }
        } catch (error) {  }
    });


    document.getElementById('editForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('editId').value;
        const title = document.getElementById('editTitle').value.trim();
        const description = document.getElementById('editDescription').value.trim();
        if (!title) {
            alertify.warning('El título es obligatorio.');
            return;
        }
        try {
            await apiRequest('PUT', `/${id}`, { title, description });
            updateTodoElement(id, title, description);
            alertify.success('Tarea actualizada exitosamente.');
            const modal = new bootstrap.Modal(editModalElement);
            modal.hide();
        } catch (error) {  }
    });

    todoList.addEventListener('click', async function(e) {
        const targetBtn = e.target;
        const taskActionsDiv = targetBtn.closest('.task-actions');
        if (!taskActionsDiv) return;
        const id = taskActionsDiv.dataset.id;
        const title = taskActionsDiv.dataset.title;
        const description = taskActionsDiv.dataset.description;
        const isDone = taskActionsDiv.dataset.is_done === '1';
        if (targetBtn.classList.contains('toggle-btn')) {
            const newIsDone = isDone ? 0 : 1;
            try {
                await apiRequest('PUT', `/${id}`, { title, description, is_done: newIsDone });
                updateTodoElement(id, title, description, newIsDone);
                alertify.success('Estado de la tarea actualizado.');
            } catch (error) {  }
        } else if (targetBtn.classList.contains('delete-btn')) {
            if (await confirmDelete()) {
                try {
                    await apiRequest('DELETE', `/${id}`);
                    document.getElementById(`todo-${id}`).remove();
                    alertify.success('Tarea eliminada exitosamente.');
                } catch (error) { }
            }
        } else if (targetBtn.classList.contains('edit-btn')) {
            document.getElementById('editId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
            const modal = new bootstrap.Modal(editModalElement);
            modal.show();
        }
    });

    document.getElementById('addTodoBtn').addEventListener('click', function() {
        const modal = new bootstrap.Modal(addModalElement);
        modal.show();
    });

    function confirmDelete() {
        return new Promise((resolve) => {
            alertify.confirm("Confirmar Eliminación", "¿Estás seguro de que deseas eliminar esta tarea?", () => resolve(true), () => resolve(false));
        });
    }

});