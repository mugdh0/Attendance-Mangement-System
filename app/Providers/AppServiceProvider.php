<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;
use App\Role;
use App\Message;
use App\AppSettings;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        

        // $authUser = User::where('id', $id)->first();

        View::composer('back-end.include.sidebar', function ($view) {
            $total_user=User::select('id')->count()-1;

            $view->with('total_user', $total_user);

        });
        
            View::composer('back-end.include.sidebar', function ($view) {
                $id = Auth::id();
                $authUser = User::where('id', $id)->first();
    
                $view->with('authUser', $authUser);
    
            });
      
            View::composer('back-end.include.header', function ($view) {
                $id = Auth::id();
                $noOfMsgReceived0=Message::where('msg_receiver',Auth::user()->email)
                ->where('notification_status','Unseen')->count();
                $noOfMsgReceived1=Message::Where('cc',Auth::user()->email)
                ->where('notification_status','Unseen')->count();
                $noOfMsgReceived=$noOfMsgReceived0+$noOfMsgReceived1;
    // dd($noOfMsgReceived);
                $view->with('noOfMsgReceived', $noOfMsgReceived);
    
            });
            View::composer('back-end.include.header', function ($view) {
                $id = Auth::id();
                
                $email = Auth::user()->email;
                $unseenEmail=Message::where(function ($query) use ($email)  {
                    $query->where('msg_receiver',$email)
                          ->orWhere('cc',$email);
                })->where('notification_status','Unseen')->take(4)->get();
                $view->with('unseenEmail', $unseenEmail);
    
            });
            View::composer('back-end.include.header', function ($view) {
            
                $obj_setting=AppSettings::first();
                $view->with('obj_setting', $obj_setting);
    
            });
        

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
