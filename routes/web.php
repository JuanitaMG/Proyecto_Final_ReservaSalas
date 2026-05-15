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



Route::get('/', function () {

    return redirect('/login');

});


Route::get('/spaces', [

    SpaceController::class,
    'index'

]);



Route::get('/calendar', [

    ReservationController::class,
    'calendar'

]);



Route::get('/availability', [

    AvailabilityController::class,
    'index'

]);



Route::middleware(['auth'])->group(function () {

   

    Route::get('/dashboard', function () {

        
        if (auth()->user()->role === 'admin') {

            return redirect('/admin');

        }

        
        return redirect('/spaces');

    });



    Route::middleware(['admin'])->group(function () {

     
        Route::get('/admin', function () {

            

            $recentReservations = Reservation::with([
                'space',
                'user'
            ])
            ->latest()
            ->take(5)
            ->get();

           

            $reservationsBySpace = Space::withCount('reservations')
                ->get()
                ->map(function ($space) {

                    return [

                        'name' => $space->name,

                        'total' => $space->reservations_count

                    ];

                });

           

            $topSpace = Space::withCount('reservations')
                ->orderByDesc('reservations_count')
                ->first();

         

            $topUser = User::withCount('reservations')
                ->orderByDesc('reservations_count')
                ->first();

           

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

      
        Route::get('/spaces/create', [

            SpaceController::class,
            'create'

        ]);

      
        Route::post('/spaces', [

            SpaceController::class,
            'store'

        ]);

        
        Route::get('/spaces/{id}/edit', [

            SpaceController::class,
            'edit'

        ]);

        
        Route::put('/spaces/{id}', [

            SpaceController::class,
            'update'

        ]);

        
        Route::delete('/spaces/{id}', [

            SpaceController::class,
            'destroy'

        ]);


        
        Route::post('/reservations/{id}/approve', [

            ReservationController::class,
            'approve'

        ]);

        
        Route::post('/reservations/{id}/reject', [

            ReservationController::class,
            'reject'

        ]);

        
        Route::post('/reservations/{id}/cancel', [

            ReservationController::class,
            'cancel'

        ]);

       
        Route::get('/blocked-slots', [

            BlockedSlotController::class,
            'index'

        ]);

        
        Route::post('/blocked-slots', [

            BlockedSlotController::class,
            'store'

        ]);

        
        Route::delete('/blocked-slots/{id}', [

            BlockedSlotController::class,
            'destroy'

        ]);

        Route::get('/availabilities', [

            AvailabilityController::class,
            'index'

        ]);

      
        Route::post('/availabilities', [

            AvailabilityController::class,
            'store'

        ]);

  
        Route::delete('/availabilities/{id}', [

            AvailabilityController::class,
            'destroy'

        ]);

    });

    

   
    Route::get('/reservations', [

        ReservationController::class,
        'index'

    ]);

    
    Route::get('/reservations/create', [

        ReservationController::class,
        'create'

    ]);

   
    Route::post('/reservations', [

        ReservationController::class,
        'store'

    ]);

   
    Route::post('/reservations/check', [

        ReservationController::class,
        'checkAvailability'

    ]);

  

    Route::get('/reservations/pdf', [

        ReservationController::class,
        'exportPdf'

    ]);

  
    Route::get('/reservations/{id}/edit', [

        ReservationController::class,
        'edit'

    ]);

   
    Route::put('/reservations/{id}', [

        ReservationController::class,
        'update'

    ]);

    Route::delete('/reservations/{id}', [

        ReservationController::class,
        'destroy'

    ]);

});



Route::get('/spaces/{slug}', [

    SpaceController::class,
    'show'

]);