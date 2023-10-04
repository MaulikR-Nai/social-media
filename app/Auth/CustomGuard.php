<?php
namespace App\Auth;

use App\Models\User;
use Illuminate\Auth\SessionGuard;


class CustomGuard extends SessionGuard
{
    public function attempt(array $credentials = [], $remember = false)
    {
        if (empty($credentials) || !isset($credentials['email']) || !isset($credentials['api_token'])) {
            return false;
        }

        // Custom logic to authenticate based on email and api_token
        $user = User::where('email', $credentials['email'])
            ->where('api_token', $credentials['api_token'])
            ->first();

        if (!$user) {
            return false;
        }

        // Authenticate the user
        $this->setUser($user);
        return true;
    }
}
?>
