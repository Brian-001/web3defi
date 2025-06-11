<?php
namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'notify_applications' => ['nullable', Rule::in(['on'])],
        ])->validateWithBag('updateProfileInformation');

        $updateData = [
            'name' => trim($input['name']),
            'email' => trim($input['email']),
            'notify_applications' => filled($input['notify_applications']),
        ];

        try {
            if (!empty($input['avatar'])) {
                $user->updateProfilePhoto($input['avatar']);
            }
        } catch (\Exception $e) {
            logger()->error('Avatar upload failed', ['error' => $e->getMessage()]);
        }

        if ($updateData['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $updateData);
        } else {
            $user->forceFill($updateData)->save();
        }


    }


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