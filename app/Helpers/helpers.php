<?php

if (!function_exists('getNextSort')) {
    function getNextSort($column) {
        $currentSort = request('sort', 'id'); // Orden por defecto: ID
        $currentOrder = request('direction', 'asc'); // Dirección por defecto: Ascendente

        if ($currentSort !== $column) {
            return ['sort' => $column, 'direction' => 'desc']; // Primer clic → Descendente
        }

        if ($currentOrder === 'desc') {
            return ['sort' => $column, 'direction' => 'asc']; // Segundo clic → Ascendente
        }

        return ['sort' => null, 'direction' => null]; // Tercer clic → Sin ordenar
    }
}

if (!function_exists('getRatingColor')) {
    function getRatingColor($rating) {
        return match ($rating) {
            5 => '#28a745',
            4 => '#28a745',
            3 => '#d4a017',
            2 => '#dc3545',
            1 => '#dc3545',
            default => '#6c757d',
        };
    }
}
