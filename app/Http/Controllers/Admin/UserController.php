<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $users = User::Paginate(PAGINATION_COUNT);
        return  view('users.index', compact('users'));
    }

    public function makeAdmin(User $user){
        try {
            DB::beginTransaction();
            $user->role = 'admin';
            $user->save();
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User make as admin successfully');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Try it later');
        }
    }

    public function edit(User $user)
    {
        $profile = $user->profile;
        return view('users.profile', compact('user', 'profile'));
    }

    public function update(User $user,UserRequest $request){
        try {
            $profile = $user->profile;
            DB::beginTransaction();
            if(!$profile){
                UserProfile::create([
                    'user_id'=> $user->id,
                ]);
            }
            $data = $request->all();
            if ($request->hasFile('picture')) {
                removeOldImage($profile->picture, 'profilesPicture');
                $imageName = uploadImage('profilesPicture', $request->file('picture'));
                $data['picture'] = $imageName;
            }
            $profile->update($data);
            DB::commit();
            return redirect()->route('users.index')->with(['success' => 'Profile updated successfully']);
        } catch (\Exception $e) {
            // return $e;
            return redirect()->route('users.index')->with(['error', 'Try it later']);
        }
    }
}
