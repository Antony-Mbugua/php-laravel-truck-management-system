<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserServicePdf;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userServicePdf;

    public function __construct(UserServicePdf $userServicePdf)
    {
        $this->userServicePdf = $userServicePdf;
    }

   
    public function downloadUserPdf($id)
    {
        $user = User::where('id', $id)->firstOrFail(); 
    
        return $this->userServicePdf->generateUserPdf($user);
    }
        public function downloadAllUsersPdf()
    {

        $users = User::all();


        return $this->userServicePdf->generateMultipleUsersPdf($users);
    }
}