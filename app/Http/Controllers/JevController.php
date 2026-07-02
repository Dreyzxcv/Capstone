<?php

namespace App\Http\Controllers;

use App\Actions\IssueJev;
use App\Http\Requests\StoreJevRequest;
use App\Models\Asset;
use Illuminate\Http\RedirectResponse;

class JevController extends Controller
{
    public function store(StoreJevRequest $request, Asset $asset, IssueJev $issueJev): RedirectResponse
    {
        $this->authorize('create', \App\Models\Jev::class);

        $issueJev->execute(
            $asset,
            $request->validated('jev_number'),
            $request->user(),
        );

        return back()->with('success', 'JEV created and linked to asset.');
    }
}
