<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Send a notification to a specific collection of users.
     */
    public static function sendToUsers($users, string $title, string $message, string $type, ?string $actionUrl = null)
    {
        // Automatically include Super Admins
        $superAdmins = User::role('Super Admin')->get();
        
        if ($users instanceof \Illuminate\Support\Collection) {
            $recipients = $users->merge($superAdmins)->unique('id');
        } elseif (is_array($users)) {
            $recipients = collect($users)->merge($superAdmins)->unique('id');
        } else {
            $recipients = collect([$users])->merge($superAdmins)->unique('id');
        }

        Notification::send($recipients, new SystemNotification($title, $message, $type, $actionUrl));
    }

    /**
     * Send a notification to a single user.
     */
    public static function sendToUser(User $user, string $title, string $message, string $type, ?string $actionUrl = null)
    {
        // Re-use sendToUsers to ensure Super Admins are also included
        self::sendToUsers(collect([$user]), $title, $message, $type, $actionUrl);
    }

    /**
     * Send a notification to users that have a specific role or array of roles.
     */
    public static function sendToRole(string|array $roleNames, string $title, string $message, string $type, ?string $actionUrl = null)
    {
        $users = User::role($roleNames)->get();
        if ($users->isNotEmpty()) {
            self::sendToUsers($users, $title, $message, $type, $actionUrl);
        }
    }

    /**
     * Send a notification to users that have a specific permission.
     */
    public static function sendToPermission(string $permission, string $title, string $message, string $type, ?string $actionUrl = null)
    {
        $users = User::permission($permission)->get();
        if ($users->isNotEmpty()) {
            self::sendToUsers($users, $title, $message, $type, $actionUrl);
        }
    }
}
