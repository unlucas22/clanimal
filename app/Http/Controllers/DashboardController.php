<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Hashids;

class DashboardController extends Controller
{
    public function showClient(Request $req)
    {
        $client = Client::with(['pets', 'users'])->where('id', Hashids::decode($req->hashid))->firstOrFail();

        return view('livewire.dashboard.show.client', [
            'client' => $client,
            'pets' => $client->pets,
            'pet_photos_count' => $client->pets->count()
        ]);
    }
}
