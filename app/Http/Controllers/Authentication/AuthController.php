<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Transaction;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return back()->with('error', $validator->messages());
        }


        $count = User::count();
        if ($count > 0) {
            return back()->with('error', 'This program is only for a single user');
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to login with success message
        return redirect()->route('login')->with('success', 'Account created successfully');
    }



    public function login(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        // Handle validation errors
        // Handle validation errors
        if ($validator->fails()) {
            return back()->with('error', $validator->messages());
        }

        // Retrieve email and password from the request
        $email = $request->email;
        $password = $request->password;



        // Check if a user with the given email exists
        $user = User::where("email", $email)->first();

        // If user is found and password matches
        if ($user && Hash::check($password, $user->password)) {
            $request->session()->put('id', $user->id);
            $request->session()->put('name', $user->name);
            return redirect()->route('home')->with('success', 'User logged in successfully');
        } else {
            return back()->with('error', 'Invalid email or password');
        }
    }


    public function logout()
    {
        if (Session::has('name')) {
            Session::pull('name');
            return redirect()->route('login')->with('success', 'Logout successful');
        }
    }

    public function home()
    {
        // Total income
        $totalIncome = Transaction::where('type', 0)
                                  ->where('status', 1)
                                  ->sum('amount');
    
        // Total income for this year
        $yearlyIncome = Transaction::where('type', 0)
                                   ->where('status', 1)
                                   ->whereYear('date', date('Y'))
                                   ->sum('amount');
    
        // Total income for this month
        $monthlyIncome = Transaction::where('type', 0)
                                    ->where('status', 1)
                                    ->whereMonth('date', date('m'))
                                    ->whereYear('date', date('Y'))
                                    ->sum('amount');
        
        // Total income for today
        $dailyIncome = Transaction::where('type', 0)
                                  ->where('status', 1)
                                  ->whereDate('date', date('Y-m-d'))
                                  ->sum('amount');
    
        // Total expenses
        $totalExpenses = Transaction::where('type', 1)
                                     ->where('status', 1)
                                     ->sum('amount');
    
        // Total expenses for this year
        $yearlyExpenses = Transaction::where('type', 1)
                                      ->where('status', 1)
                                      ->whereYear('date', date('Y'))
                                      ->sum('amount');
    
        // Total expenses for this month
        $monthlyExpenses = Transaction::where('type', 1)
                                       ->where('status', 1)
                                       ->whereMonth('date', date('m'))
                                       ->whereYear('date', date('Y'))
                                       ->sum('amount');
    
        // Total expenses for today
        $dailyExpenses = Transaction::where('type', 1)
                                     ->where('status', 1)
                                     ->whereDate('date', date('Y-m-d'))
                                     ->sum('amount');
    
        // Pass all variables to the view
        return view('home', compact(
            'totalIncome', 'yearlyIncome', 'monthlyIncome', 'dailyIncome',
            'totalExpenses', 'yearlyExpenses', 'monthlyExpenses', 'dailyExpenses'
        ));
    }
    
}
