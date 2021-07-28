<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GetallUserAvatarsController extends Controller
{
    
    public function get_all_user_avatar(){

        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $images = [];
        $files = Storage::disk('s3')->files('users');
        foreach ($files as $file) {
        $images[] = [
        'src' => $url . $file
        ];
        }

        return compact('images');
    }
}
