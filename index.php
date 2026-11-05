<?php

// Arreglo para guardar las transacciones
$transacciones = array();

// Funcion para registrar una sola transaccion y agregarlo al arreglo
function registrarTransaccion($id, $descripcion, $monto) {
    global $transacciones;

    $nuevaTransaccion = array(
        'id' => $id,
        'descripcion' => $descripcion,
        'monto' => $monto
    );

    array_push($transacciones, $nuevaTransaccion);
}

// Funcion para generar y mostrar el estado de cuenta
function generarEstadoDeCuenta() {
    global $transacciones;

    $montoTotalContado = 0;

    // Calcular el total de contado sumando los montos
    foreach ($transacciones as $transaccion) {
        $montoTotalContado = $montoTotalContado + $transaccion['monto'];
    }

    // Calcular el interes (2.6%)
    $montoConInteres = $montoTotalContado + ($montoTotalContado * 0.026);

    // Calcular el cashback (0.1% sobre monto de contado) va a la tarjeta para la proxima compra
    $cashBack = $montoTotalContado * 0.001;

    // Calcular el monto final a pagar
    $montoFinalPagar = $montoConInteres;

    // Montar la info en una variable de texto
    $texto = "--------------------------------------------------\n";
    $texto .= "               ESTADO DE CUENTA                   \n";
    $texto .= "--------------------------------------------------\n";

    foreach ($transacciones as $transaccion) {
        $texto .= "ID: " . $transaccion['id'] . " | " . $transaccion['descripcion'] . " | Monto: " . $transaccion['monto'] . "\n";
    }

    $texto .= "--------------------------------------------------\n";
    $texto .= "Monto Total de Contado: " . $montoTotalContado . "\n";
    $texto .= "Monto con Interes (2.6%): " . $montoConInteres . "\n";
    $texto .= "Cash Back (0.1%): " . $cashBack . "\n";
    $texto .= "--------------------------------------------------\n";
    $texto .= "Monto Final a Pagar: " . $montoFinalPagar . "\n";
    $texto .= "--------------------------------------------------\n";
    //Se deja el cashback para que el usuario lo aplique en su proxima compra

    // Guardar en el archivo de texto
    $archivo = fopen("estado_cuenta.txt", "w");
    fwrite($archivo, $texto);
    fclose($archivo);

    // Mostrar en pantalla dentro de etiquetas pre para mantener los saltos de linea
    echo "<pre>";
    echo $texto;
    echo "</pre>";
}

// --- Registrar transacciones de prueba ---
registrarTransaccion(1, "Super Cazu", 15000);
registrarTransaccion(2, "Gasolinera EGS", 42000);
registrarTransaccion(3, "Gimnasio Mundial", 45000);
registrarTransaccion(4, "Google One", 8900);
registrarTransaccion(5, "Farmacia Saba", 12500);

// Generar el estado de cuenta
generarEstadoDeCuenta();

?>