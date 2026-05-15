<?php

use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

use App\Models\Space;
use App\Models\User;
use App\Models\Reservation;

use App\Http\Controllers\SpaceController;
use App\Http\Controllers\BlockedSlotController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AvailabilityController;

/*
|--------------------------------------------------------------------------
| RUTA PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect('/login');

});

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
| Estas rutas se pueden ver sin iniciar sesión
*/

/*
|--------------------------------------------------------------------------
| SALAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/spaces', [

    SpaceController::class,
    'index'

]);

/*
|--------------------------------------------------------------------------
| CALENDARIO PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get('/calendar', [

    ReservationController::class,
    'calendar'

]);

/*
|--------------------------------------------------------------------------
| DISPONIBILIDAD EN TIEMPO REAL
|--------------------------------------------------------------------------
*/

Route::get('/availability', [

    AvailabilityController::class,
    'index'

]);

/*
|--------------------------------------------------------------------------
| RUTAS AUTENTICADAS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | REDIRECCIÓN DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        // 👑 ADMIN
        if (auth()->user()->role === 'admin') {

            return redirect('/admin');

        }

        // 👤 USER
        return redirect('/spaces');

    });

    /*
    |--------------------------------------------------------------------------
    | RUTAS SOLO ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware(['admin'])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | PANEL ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get('/admin', function () {

            /*
            |--------------------------------------------------------------------------
            | ACTIVIDAD RECIENTE
            |--------------------------------------------------------------------------
            */

            $recentReservations = Reservation::with([
                'space',
                'user'
            ])
            ->latest()
            ->take(5)
            ->get();

            /*
            |--------------------------------------------------------------------------
            | RESERVAS POR SALA
            |--------------------------------------------------------------------------
            */

            $reservationsBySpace = Space::withCount('reservations')
                ->get()
                ->map(function ($space) {

                    return [

                        'name' => $space->name,

                        'total' => $space->reservations_count

                    ];

                });

            /*
            |--------------------------------------------------------------------------
            | SALA MÁS USADA
            |--------------------------------------------------------------------------
            */

            $topSpace = Space::withCount('reservations')
                ->orderByDesc('reservations_count')
                ->first();

            /*
            |--------------------------------------------------------------------------
            | USUARIO MÁS ACTIVO
            |--------------------------------------------------------------------------
            */

            $topUser = User::withCount('reservations')
                ->orderByDesc('reservations_count')
                ->first();

            /*
            |--------------------------------------------------------------------------
            | PORCENTAJE APROBADAS
            |--------------------------------------------------------------------------
            */

            $approvalRate = Reservation::count() > 0

                ? round(
                    (
                        Reservation::where(
                            'status',
                            'approved'
                        )->count()

                        / Reservation::count()
                    ) * 100
                )

                : 0;

            /*
            |--------------------------------------------------------------------------
            | DASHBOARD
            |--------------------------------------------------------------------------
            */

            return Inertia::render('Admin/Dashboard', [

                'totalSpaces' => Space::count(),

                'totalReservations' => Reservation::count(),

                'approvedReservations' => Reservation::where(
                    'status',
                    'approved'
                )->count(),

                'pendingReservations' => Reservation::where(
                    'status',
                    'pending'
                )->count(),

                'rejectedReservations' => Reservation::where(
                    'status',
                    'rejected'
                )->count(),

                'cancelledReservations' => Reservation::where(
                    'status',
                    'cancelled'
                )->count(),

                'totalUsers' => User::count(),

                'recentReservations' => $recentReservations,

                'reservationsBySpace' => $reservationsBySpace,

                'topSpace' => $topSpace,

                'topUser' => $topUser,

                'approvalRate' => $approvalRate

            ]);

        });

        /*
        |--------------------------------------------------------------------------
        | CRUD SALAS
        |--------------------------------------------------------------------------
        */

        // CREAR
        Route::get('/spaces/create', [

            SpaceController::class,
            'create'

        ]);

        // GUARDAR
        Route::post('/spaces', [

            SpaceController::class,
            'store'

        ]);

        // EDITAR
        Route::get('/spaces/{id}/edit', [

            SpaceController::class,
            'edit'

        ]);

        // ACTUALIZAR
        Route::put('/spaces/{id}', [

            SpaceController::class,
            'update'

        ]);

        // ELIMINAR
        Route::delete('/spaces/{id}', [

            SpaceController::class,
            'destroy'

        ]);

        /*
        |--------------------------------------------------------------------------
        | APROBAR / RECHAZAR / CANCELAR RESERVAS
        |--------------------------------------------------------------------------
        */

        // APROBAR
        Route::post('/reservations/{id}/approve', [

            ReservationController::class,
            'approve'

        ]);

        // RECHAZAR
        Route::post('/reservations/{id}/reject', [

            ReservationController::class,
            'reject'

        ]);

        // CANCELAR
        Route::post('/reservations/{id}/cancel', [

            ReservationController::class,
            'cancel'

        ]);

        /*
        |--------------------------------------------------------------------------
        | BLOQUEOS
        |--------------------------------------------------------------------------
        */

        // LISTAR
        Route::get('/blocked-slots', [

            BlockedSlotController::class,
            'index'

        ]);

        // CREAR
        Route::post('/blocked-slots', [

            BlockedSlotController::class,
            'store'

        ]);

        // ELIMINAR
        Route::delete('/blocked-slots/{id}', [

            BlockedSlotController::class,
            'destroy'

        ]);

    });

    /*
    |--------------------------------------------------------------------------
    | RESERVAS (SOLO LOGUEADOS)
    |--------------------------------------------------------------------------
    */

    // LISTAR
    Route::get('/reservations', [

        ReservationController::class,
        'index'

    ]);

    // FORMULARIO CREAR
    Route::get('/reservations/create', [

        ReservationController::class,
        'create'

    ]);

    // GUARDAR
    Route::post('/reservations', [

        ReservationController::class,
        'store'

    ]);

    /*
    |--------------------------------------------------------------------------
    | VERIFICAR DISPONIBILIDAD
    |--------------------------------------------------------------------------
    */

    Route::post('/reservations/check', [

        ReservationController::class,
        'checkAvailability'

    ]);

    /*
    |--------------------------------------------------------------------------
    | EXPORTAR PDF
    |--------------------------------------------------------------------------
    */

    Route::get('/reservations/pdf', [

        ReservationController::class,
        'exportPdf'

    ]);

    /*
    |--------------------------------------------------------------------------
    | CRUD RESERVAS
    |--------------------------------------------------------------------------
    */

    // EDITAR
    Route::get('/reservations/{id}/edit', [

        ReservationController::class,
        'edit'

    ]);

    // ACTUALIZAR
    Route::put('/reservations/{id}', [

        ReservationController::class,
        'update'

    ]);

    // ELIMINAR
    Route::delete('/reservations/{id}', [

        ReservationController::class,
        'destroy'

    ]);

});