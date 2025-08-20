<?php

require_once __DIR__ . '/includes/api.php';

try {
    $todos = callAPI('GET', API_URL)['data'] ?? [];
} catch (Exception $e) {
    error_log("Error al cargar las tareas: " . $e->getMessage());
    $todos = [];
}

require_once __DIR__ . '/templates/header.php';
require_once __DIR__ . '/templates/todolist.php';
require_once __DIR__ . '/templates/footer.php';

?>