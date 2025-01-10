<?php

require_once 'base\cx_database.php';

enableErrorLog();

// Función para conectar a la base de datos
function obtenerConexion(): ?PDO {
    try {
        return createConnection();
    } catch (Exception $e) {
        error_log("Error al conectar con la base de datos: " . $e->getMessage());
        return null;
    }
}

// Función para obtener las fechas ordenadas
function obtenerFechas(PDO $conn): array {
    $query = "SELECT id, fecha, descripcion FROM fecha ORDER BY fecha ASC";
    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error al obtener las fechas: " . $e->getMessage());
        return [];
    }
}

// Función para verificar si una fecha está dentro de un plazo
function estaEnPlazo(DateTime $fechaActual, DateTime $inicio, DateTime $fin): bool {
    return $fechaActual >= $inicio && $fechaActual <= $fin;
}

// Función para calcular los días restantes para que termine un plazo
function diasRestantesEnPlazo(DateTime $fechaActual, DateTime $inicio, DateTime $fin): ?int {
    if (estaEnPlazo($fechaActual, $inicio, $fin)) {
        $diferencia = $fechaActual->diff($fin);
        return $diferencia->days;
    }
    return null; // No está en el plazo
}

// Función principal para verificar plazos y generar mensajes
function verificarPlazos(PDO $conn) {
    $fechas = obtenerFechas($conn);

    if (count($fechas) < 3) {
        echo "<div style='color: red;'>Error: No hay suficientes fechas definidas en la base de datos.</div>";
        return;
    }

    $fechaActual = new DateTime();

    // Primer plazo
    $inicioPrimerPlazo = new DateTime($fechas[0]['fecha']);
    $finPrimerPlazo = (new DateTime($fechas[1]['fecha']))->modify('-1 day');
    $diasRestantes = diasRestantesEnPlazo($fechaActual, $inicioPrimerPlazo, $finPrimerPlazo);

    if ($diasRestantes !== null) {
        echo "<div>Actualmente estamos en el primer plazo: <strong>{$fechas[0]['descripcion']}</strong>. 
              Quedan <strong>$diasRestantes días</strong> para que termine.</div>";
        return;
    }

    // Segundo plazo
    $inicioSegundoPlazo = new DateTime($fechas[1]['fecha']);
    $finSegundoPlazo = (new DateTime($fechas[2]['fecha']))->modify('-1 day');
    $diasRestantes = diasRestantesEnPlazo($fechaActual, $inicioSegundoPlazo, $finSegundoPlazo);

    if ($diasRestantes !== null) {
        echo "<div>Actualmente estamos en el segundo plazo: <strong>{$fechas[1]['descripcion']}</strong>. 
              Quedan <strong>$diasRestantes días</strong> para que termine.</div>";
        return;
    }

    // Fuera de los plazos definidos
    echo "<div>No estamos en ningún plazo activo.</div>";
}

// Ejecutar el programa
$conn = obtenerConexion();
if ($conn) {
    verificarPlazos($conn);
} else {
    echo "<div style='color: red;'>Error: No se pudo conectar a la base de datos.</div>";
}
?>