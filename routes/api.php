<?php

use App\Events\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\API\MultipleUploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'middleware' => 'api',
    'namespace'  => 'App\Http\Controllers',
    'prefix'     => 'auth',
],function($router) {
    Route::post('login','AuthController@login');

    Route::post('register','AuthController@register');

    Route::post('register_admin_users','Register_Admin_Users@register_admin_users');

    Route::post('logout','AuthController@logout');

    Route::get('profile','AuthController@profile');

    Route::post('refresh','AuthController@refresh'); 

    Route::get('totalusers', 'CountsController@get_total_users');

    Route::get('totalmen', 'CountsController@get_total_men');

    Route::get('totalwomen', 'CountsController@get_total_women');

    Route::get('totalsuccessful_profiles', 'CountsController@get_total_no_successful_profiles');

    Route::get('allprofiles', 'AdminGetAllProfiles@get_all_profiles');

    Route::get('useravatar', 'GetUserAvatarController@getuseravatar');

    Route::get('loggedin_user_profile', 'GetCurrentUserProfileController@get_profile_for_current_user');

    Route::apiresource('profiles','ProfilesController');

    Route::apiresource('chats','ChatsController');

    Route::get('chats_to_reply_to', 'GetAllChatsToReplyToByAUserController@get_all_chats_toberepliedto_byauser');
    
    Route::get('get_replies_auser_makes', 'GetAllRepliesAUserMadeController@get_all_replies_auser_makes');
    

    Route::get('postwith_maxid', 'GetPostWithMaximumIdForLoggedInUserController@get_post_with_maxid');

    Route::get('allchats', 'AdminGellAllChatsController@get_all_chats_by_admin');

    Route::get('alluseravatar', 'GetallUserAvatarsController@get_all_user_avatar');

    Route::get('get_my_replies', 'GetReliesToWhatIPostedController@get_replies_to_what_i_posted');
    
    Route::apiresource('chats_reply','Chat_replyController');

    //route to test websockets

    Route::get('broadcast', 'InvokeNewMessageEventController@getNewMessage');


    
}
);





    








