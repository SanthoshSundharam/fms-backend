<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Farmer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getAllUsers()
    {
        $users = User::where('role', 'user')
            ->withCount('farmers')
            ->latest()
            ->get();

        return response()->json([
            'users' => $users
        ], 200);
    }

    public function getAllFarmers()
    {
        $farmers = Farmer::with('user:id,name,email,mobile_number')
            ->latest()
            ->get();

        return response()->json([
            'farmers' => $farmers
        ], 200);
    }

    public function getUserFarmers($userId)
    {
        $user = User::with('farmers')->findOrFail($userId);

        return response()->json([
            'user' => $user,
            'farmers' => $user->farmers
        ], 200);
    }

    public function getStatistics()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalFarmers = Farmer::count();
        $totalAdmins = User::where('role', 'admin')->count();

        return response()->json([
            'statistics' => [
                'total_users' => $totalUsers,
                'total_farmers' => $totalFarmers,
                'total_admins' => $totalAdmins,
            ]
        ], 200);
    }
}