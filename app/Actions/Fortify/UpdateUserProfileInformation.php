<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'notify_applications' => ['nullable', 'boolean'],
        ])->validateWithBag('updateProfileInformation');

        //Prepare Data to update
        $updateData = [
            'name' => $input['name'],
            'email' => $input['email'],
            'notify_applications' => isset($input['notify_applications']) ? (bool) $input['notify_applications'] : false,
        ];

        //Handle Avatar Upload
        if (isset($input['avatar']) && $input['avatar']) {
            $user->updateProfilePhoto($input['avatar']);
            $updateData['profile_photo_path'] = $user->profile_photo_path; //Ensure the path is updated
        }

        //Check if the email has changed and if the user must verify their email
        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $updateData);
        } else {
            $user->forceFill($updateData)->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'notify_applications' => $input['notify_applications'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
