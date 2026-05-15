<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva</title>
</head>
<body style="font-family: Arial; padding: 30px;">

    <h1>
        ReservasPro
    </h1>

    <p>
        Hola {{ $reservation->user->name }}
    </p>

    <p>
        {{ $messageText }}
    </p>

    <hr>

    <h3>Detalle de la reserva</h3>

    <p>
        <strong>Sala:</strong>
        {{ $reservation->space->name }}
    </p>

    <p>
        <strong>Fecha:</strong>
        {{ $reservation->date }}
    </p>

    <p>
        <strong>Horario:</strong>
        {{ $reservation->start_time }}
        -
        {{ $reservation->end_time }}
    </p>

</body>
</html>