<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
       
        $totalReservations = Reservation::count();

        $approvedReservations = Reservation::where(
            'status',
            'approved'
        )->count();

        $pendingReservations = Reservation::where(
            'status',
            'pending'
        )->count();

        $rejectedReservations = Reservation::where(
            'status',
            'rejected'
        )->count();

       
        $totalSpaces = Space::count();

        $totalUsers = User::count();

        

        $recentReservations = Reservation::with([
            'user',
            'space'
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

     

        $approvalRate = $totalReservations > 0

            ? round(
                ($approvedReservations / $totalReservations) * 100
            )

            : 0;

       

        return inertia('Admin/Dashboard', [

            'totalSpaces' => $totalSpaces,

            'totalReservations' => $totalReservations,

            'approvedReservations' => $approvedReservations,

            'pendingReservations' => $pendingReservations,

            'rejectedReservations' => $rejectedReservations,

            'totalUsers' => $totalUsers,

            'recentReservations' => $recentReservations,

            'reservationsBySpace' => $reservationsBySpace,

            'topSpace' => $topSpace,

            'topUser' => $topUser,

            'approvalRate' => $approvalRate

        ]);
    }
}