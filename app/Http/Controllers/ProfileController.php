<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Get the profile of the logged in user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $user = Auth::guard('api')->user();
        $profile = $user->profile;
        return response()->json([
            'profile' => $profile,
            'status' => 'success'
        ], 200);
    }

    /**
     * Update or create a profile for logged in user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user->profile == null) {
            $profile = new Profile();
            $user->profile()->save($profile);
        }

        $profile = $user->profile;
        $profile->first_name = $request->post('first_name');
        $profile->last_name = $request->post('last_name');
        $profile->phone_number = $request->post('phone_number');
        $profile->mobile_number = $request->post('mobile_number');
        $profile->address = $request->post('address');
        $profile->city = $request->post('city');
        $profile->state = $request->post('state');
        $profile->zip = $request->post('zip');
        $profile->profile_pic = $request->post('profile_pic');
        $profile->save();

        return response()->json([
            'profile' => $profile,
            'status' => 'success'
        ], 200);
    }
}
