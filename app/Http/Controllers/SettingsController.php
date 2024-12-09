<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    // public function usersSettings()
    // {
    //     // Dummy data for users settings
    //     $users = [
    //         [
    //             'id' => 1,
    //             'name' => 'John Doe',
    //             'email' => 'john@example.com',
    //         ],
    //         [
    //             'id' => 2,
    //             'name' => 'Jane Smith',
    //             'email' => 'jane@example.com',
    //         ],
    //         // Add more dummy data as needed
    //     ];

    //     return view('settings', compact('users'));
    // }

    // public function implementationStatus()
    // {
    //     // Dummy data for implementation status
    //     $data_recommendations = [
    //         [
    //             'report_numbers' => 'R123',
    //             'report_title' => 'Recommendation 1',
    //             'implementation_status' => 'Fully Implemented',
    //         ],
    //         [
    //             'report_numbers' => 'R124',
    //             'report_title' => 'Recommendation 2',
    //             'implementation_status' => 'Partially Implemented',
    //         ],
    //         // Add more dummy data as needed
    //     ];

    //     return view('settings', compact('data_recommendations'));
    // }

    // public function acceptanceStatus()
    // {
    //     // Dummy data for acceptance status
    //     $data_acceptance = [
    //         [
    //             'report_numbers' => 'R123',
    //             'report_title' => 'Recommendation 1',
    //             'acceptance_status' => 'Accepted',
    //         ],
    //         [
    //             'report_numbers' => 'R124',
    //             'report_title' => 'Recommendation 2',
    //             'acceptance_status' => 'Denied',
    //         ],
    //         // Add more dummy data as needed
    //     ];

    //     return view('settings', compact('data_acceptance'));
    // }

    // public function saiConfirmation()
    // {
    //     // Dummy data for SAI confirmation
    //     $data_confirmation = [
    //         [
    //             'report_numbers' => 'R123',
    //             'report_title' => 'Recommendation 1',
    //             'sai_confirmation' => 'Yes',
    //         ],
    //         [
    //             'report_numbers' => 'R124',
    //             'report_title' => 'Recommendation 2',
    //             'sai_confirmation' => 'No',
    //         ],
    //         // Add more dummy data as needed
    //     ];

    //     return view('settings', compact('data_confirmation'));
    // }

     // User CRUD methods

     public function createUser()
     {
        // Dummy data for users settings
        $users = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
            ],
        ];

        return view('settings', compact('users'));
        //  return view('settings');
     }
 
     public function storeUser(Request $request)
     {
         // Implement user creation logic here
     }
 
     public function editUser($id)
     {
         // Implement user editing logic here
     }
 
     public function updateUser(Request $request, $id)
     {
         // Implement user updating logic here
     }
 
     public function deleteUser($id)
     {
         // Implement user deletion logic here
     }
 
     // Recommendation status update methods
 
     public function updateImplementationStatus(Request $request)
     {
         // Implement implementation status update logic here
     }
 
     public function updateAcceptanceStatus(Request $request)
     {
         // Implement acceptance status update logic here
     }
 
     public function updateSAIConfirmation(Request $request)
     {
         // Implement SAI confirmation status update logic here
     }

     

    public function listUsers()
    {
        $users = User::all(); 

        return view('settings', compact('users'));
    }

}

