<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Reporte de Reservas
    </title>

    <style>

        body {

            font-family: DejaVu Sans, sans-serif;

            padding: 40px;

            color: #1f2937;

        }

        h1 {

            font-size: 34px;

            margin-bottom: 10px;

            color: #111827;

        }

        .subtitle {

            color: #6b7280;

            margin-bottom: 30px;

            font-size: 14px;

        }

        .stats {

            margin-bottom: 30px;

        }

        .stats-box {

            display: inline-block;

            width: 180px;

            padding: 15px;

            margin-right: 10px;

            border-radius: 12px;

            color: white;

            font-size: 14px;

        }

        .blue {

            background: #4f46e5;

        }

        .green {

            background: #22c55e;

        }

        .yellow {

            background: #f59e0b;

        }

        .red {

            background: #ef4444;

        }

        table {

            width: 100%;

            border-collapse: collapse;

            margin-top: 20px;

        }

        thead {

            background: #4f46e5;

            color: white;

        }

        th,
        td {

            padding: 14px;

            text-align: left;

            border-bottom: 1px solid #e5e7eb;

        }

        tbody tr:nth-child(even) {

            background: #f9fafb;

        }

        .status {

            padding: 6px 12px;

            border-radius: 999px;

            color: white;

            font-size: 12px;

            font-weight: bold;

            display: inline-block;

        }

        .approved {

            background: #22c55e;

        }

        .pending {

            background: #f59e0b;

        }

        .rejected {

            background: #ef4444;

        }

        .footer {

            margin-top: 40px;

            font-size: 12px;

            color: #6b7280;

        }

    </style>

</head>

<body>

    <!-- HEADER -->

    <h1>
        📄 Reporte de Reservas
    </h1>

    <p class="subtitle">

        Generado por:
        <strong>{{ $generatedBy }}</strong>

        <br><br>

        Fecha:
        {{ now()->format('d/m/Y H:i') }}

    </p>

    <!-- STATS -->

    <div class="stats">

        <div class="stats-box blue">

            <strong>Total reservas</strong>

            <br><br>

            {{ $totalReservations }}

        </div>

        <div class="stats-box green">

            <strong>Aprobadas</strong>

            <br><br>

            {{ $reservations->where('status', 'approved')->count() }}

        </div>

        <div class="stats-box yellow">

            <strong>Pendientes</strong>

            <br><br>

            {{ $reservations->where('status', 'pending')->count() }}

        </div>

        <div class="stats-box red">

            <strong>Rechazadas</strong>

            <br><br>

            {{ $reservations->where('status', 'rejected')->count() }}

        </div>

    </div>

    <!-- TABLA -->

    <table>

        <thead>

            <tr>

                <th>
                    Sala
                </th>

                <th>
                    Usuario
                </th>

                <th>
                    Fecha
                </th>

                <th>
                    Horario
                </th>

                <th>
                    Estado
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach ($reservations as $reservation)

                <tr>

                    <td>
                        {{ $reservation->space->name }}
                    </td>

                    <td>
                        {{ $reservation->user->name }}
                    </td>

                    <td>
                        {{ $reservation->date }}
                    </td>

                    <td>

                        {{ $reservation->start_time }}
                        -
                        {{ $reservation->end_time }}

                    </td>

                    <td>

                        @if ($reservation->status === 'approved')

                            <span class="status approved">
                                ✅ Aprobada
                            </span>

                        @elseif ($reservation->status === 'pending')

                            <span class="status pending">
                                ⏳ Pendiente
                            </span>

                        @else

                            <span class="status rejected">
                                ❌ Rechazada
                            </span>

                        @endif

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <!-- FOOTER -->

    <div class="footer">

        Reporte generado automáticamente por ReservasPro.

    </div>

</body>

</html>