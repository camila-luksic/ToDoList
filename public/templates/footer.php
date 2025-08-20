<!-- Modal para agregar tarea -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addForm">
        <div class="modal-header">
          <h5 class="modal-title">Agregar Tarea</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="addTitle" class="form-label">Título</label>
            <input type="text" id="addTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="addDescription" class="form-label">Descripción</label>
            <textarea id="addDescription" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success" id="saveTodoBtn" data-bs-dismiss="modal">Guardar</button>

        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para editar tarea -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editForm">
        <div class="modal-header">
          <h5 class="modal-title">Editar Tarea</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editId">
          <div class="mb-3">
            <label for="editTitle" class="form-label">Título</label>
            <input type="text" id="editTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="editDescription" class="form-label">Descripción</label>
            <textarea id="editDescription" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning" data-bs-dismiss="modal">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script src="js/main.js"></script>
</body>
</html>