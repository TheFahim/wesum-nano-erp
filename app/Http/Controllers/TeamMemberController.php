<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\File as FileRule;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $team_members = TeamMember::latest()->get();

        // return $team_member;

        return view('dashboard.team_members.index', compact('team_members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.team_members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $team_member_data = $request->validate([
            'name' => ['required', 'min:3'],
            'member_type' => ['required','integer'],
            'designation' => ['required', 'min:3'],
            'social' => ['array','nullable'],
            'description' => ['min:3','nullable'],
            'image' => ['nullable', 'max:2048', FileRule::types(['png', 'jpg', 'jpeg', 'svg', 'gif', 'webp'])],
        ]);

        if ($request->hasFile('image')) {
            $team_member_data['image'] = $this->fileSave($request->file('image'), 'uploads/team_members','team_member');
        }

        TeamMember::create([
            'name' => $request->name,
            'member_type' => $request->member_type,
            'designation' => $request->designation,
            'social' => array_filter($request->social, function ($val) {
                return $val['site'] && $val['url'];
            }),
            'description' => $request->description,
            'image' => $team_member_data['image'] ?? ''
        ]);

        return redirect()->route('teams.index')->with('success', 'Entry Listed');
    }

    /**
     * Display the specified resource.
     */
    public function show(TeamMember $teamMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamMember $team)
    {
        return view('dashboard.team_members.edit', ['teamMember' => $team]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamMember $team)
    {
        $team_member_data = $request->validate([
            'name' => ['required', 'min:3'],
            'member_type' => ['required','integer'],
            'designation' => ['required', 'min:3'],
            'social' => ['array','nullable'],
            'description' => ['min:3','nullable'],
            'image' => ['nullable', 'max:2048', FileRule::types(['png', 'jpg', 'jpeg', 'svg', 'gif', 'webp'])],
        ]);


        $team_member_data['image'] = $this->fileUpdate($request->file('image'), 'uploads/team_members', $team->image, 'team_member');

        $team->update([
            'name' => $request->name,
            'member_type' => $request->member_type,
            'designation' => $request->designation,
            'social' => array_filter($request->social, function ($val) {
                return $val['site'] && $val['url'];
            }),
            'description' => $request->description,
            'image' => $team_member_data['image'] ?? ""
        ]);

        return redirect()->route('teams.index')->with('success', 'Entry Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamMember $team)
    {
        if (File::exists($team->image)) {
            File::delete($team->image);
        }
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Entry Deleted');
    }
}
