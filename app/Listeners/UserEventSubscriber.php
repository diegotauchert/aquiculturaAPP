<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Listeners;

class UserEventSubscriber
{

    /**
     * Handle user login events.
     */
    public function onUserLogin($event)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $session = session_id();
        $info = $_SERVER['HTTP_USER_AGENT'];

        if ($event->guard == 'gestor') {
            auth()->guard('gestor')->user()->registerLogs(
                    null,
                    $ip,
                    $session,
                    $info,
                    1);
            $tokenAccess = bcrypt(date('YmdHms'));

            $user = auth()->guard('gestor')->user();
            $user->token_access = $tokenAccess;
            $user->save();

            session()->put('access_token', $tokenAccess);
        }
    }

    /**
     * Handle user fail events.
     */
    public function onUserFailed($event)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $session = session_id();
        $info = $_SERVER['HTTP_USER_AGENT'];

        if ($event->guard == 'gestor') {
            if (empty(auth()->guard('gestor')->user())) {
                $user = \App\Models\Usuario::where('login', '=', $event->credentials['login'])
                        ->first();

                if (empty($user)) {
                    $user = new \App\Models\User;
                }

                $user->registerLogs(
                        'u: ' . $event->credentials['login'] . ' | s: ' . $event->credentials['password'],
                        $ip,
                        $session,
                        $info,
                        1,
                        2
                );
            }
        }
    }

    /**
     * Handle user logout events.
     */
    public function onUserLogout($event)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $session = session_id();
        $info = $_SERVER['HTTP_USER_AGENT'];

        if ($event->guard == 'gestor') {
            auth()->guard('gestor')->user()->registerLogs(
                    null,
                    $ip,
                    $session,
                    $info,
                    3
            );
        }
    }

    /**
     * Handle user passwordReset events.
     */
    public function onUserPasswordReset($event)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $session = session_id();
        $info = $_SERVER['HTTP_USER_AGENT'];

        if ($event->guard == 'gestor') {
            auth()->guard('gestor')->user()->registerLogs(
                    null,
                    $ip,
                    $session,
                    $info,
                    2
            );
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
                'Illuminate\Auth\Events\Login',
                'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
                'Illuminate\Auth\Events\Failed',
                'App\Listeners\UserEventSubscriber@onUserFailed'
        );

        $events->listen(
                'Illuminate\Auth\Events\Logout',
                'App\Listeners\UserEventSubscriber@onUserLogout'
        );

        $events->listen(
                'Illuminate\Auth\Events\PasswordReset',
                'App\Listeners\UserEventSubscriber@onUserPasswordReset'
        );
    }

}
