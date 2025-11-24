<?php

namespace App\Http\Controllers\API\Profile;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProfileApiController extends Controller
{
    use ApiResponse;

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|string|date_format:Y-m-d',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:20048',
        ]);

        // Update only if provided
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->filled('dob')) {
            $user->dob = $request->dob;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            Helper::deleteFile($user->avatar);

            // Upload new file
            $filePath = Helper::uploadFile('avatars', $request->file('avatar'));
            $user->avatar = $filePath;
        }

        $user->save();

        return $this->sendResponse([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'dob' => $user->dob,
                'is_verified' => $user->is_verified ?? false,
                'avatar' => Helper::generateURL($user->avatar),
            ],
        ], 'Profile updated successfully.');
    }

    // change password
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        // Check current password
        if (! password_verify($request->current_password, $user->password)) {
            return $this->sendError('Current password is incorrect.');
        }

        // Update password
        $user->password = bcrypt($request->new_password);
        $user->save();
        $user->tokens()->delete();

        return $this->sendResponse([], 'Password changed successfully.');
    }

    // delete account
    public function deleteAccount(Request $request)
    {
        $user = auth()->user();

        // confirm password before deleting
        $request->validate([
            'password' => 'required|string',
        ]);

        if (! password_verify($request->password, $user->password)) {
            return $this->sendError('Password is incorrect.');
        }
        // Revoke all tokens (logout from all devices)
        $user->tokens()->delete();

        // Delete avatar if exists
        if ($user->avatar) {
            Helper::deleteFile($user->avatar);
        }

        // Delete user record
        $user->delete();

        return $this->sendResponse([], 'Account deleted successfully.');
    }
}
