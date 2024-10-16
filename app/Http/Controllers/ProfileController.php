<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Address;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\HomePage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request, $slug = null): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'slug' => $slug
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, $slug = null): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($slug) {
            $homePage = HomePage::where('slug', $slug)->firstOrFail();
        } else {
            $homePage = HomePage::firstOrFail(); 
            $slug = $homePage->slug;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit', ['slug' => $slug])->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function address(Request $request)
    {
        $user = Auth::user();
        $address = $user->addresses;

        return view('profile.address', [
            'address' => $address,
        ]);
    }

    public function orders(Request $request)
    {
        $user = Auth::user();
        $orders = $user->orders->sortByDesc('created_at');

        return view('profile.orders', [
            'orders' => $orders,
        ]);
    }

    public function addressRemove($id)
    {
        $user = Auth::user();

        $address = Address::where('id', $id)->where('user_id', $user->id)->first();

        if ($address) {
            $address->delete();
        }
        $address_list = $user->addresses;

        return view('profile.address', [
            'address' => $address_list,
        ]);
    }

    public function addressSave(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'postal_code' => 'required',
            'address' => 'required',
            'complement' => 'required',
            'city' => 'required',
            'acronym_state' => 'required',
            'country' => 'required',
        ]);

        $address = new Address;

        $address->postal_code = $data['postal_code'];
        $address->address = $data['address'];
        $address->complement = $data['complement'];
        $address->city = $data['city'];
        $address->state = State::where('acronym_state', $data['acronym_state'])->first()->state;
        $address->acronym_state = $data['acronym_state'];
        $address->country = $data['country'];
        $address->user_id = $user->id;
        $address->save();

        $address_list = $user->addresses;

        return view('profile.address', [
            'address' => $address_list,
        ]);
    }
}
