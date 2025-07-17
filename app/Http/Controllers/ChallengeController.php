<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challenge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ChallengeTask;
use App\Models\User;

class ChallengeController extends Controller
{
    public function index()
    {
        return view('challenges.index', [
            'joinedChallenges' => auth()->user()->joinedChallenges,
        ]);
    }

    public function available()
    {
        $availableChallenges = Challenge::whereDoesntHave('participants', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('challenges.available', compact('availableChallenges'));
    }

    public function created()
    {
        $myChallenges = Challenge::where('creator_id', auth()->id())->get();

        return view('challenges.created', compact('myChallenges'));
    }

    public function join($id)
    {
        try {
            $userId = Auth::id();
            $today = Carbon::today();

            DB::table('challenge_user')->updateOrInsert([
                'user_id' => $userId,
                'challenge_id' => $id,
            ], [
                'joined_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $taskExists = ChallengeTask::where('user_id', $userId)
                ->where('challenge_id', $id)
                ->whereDate('date', $today)
                ->exists();

            if (!$taskExists) {
                ChallengeTask::create([
                    'user_id' => $userId,
                    'challenge_id' => $id,
                    'date' => $today,
                    'is_completed' => false,
                ]);
            }

            return back()->with('success', 'You have successfully joined the challenge.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to join the challenge. Please try again.');
        }
    }

    public function create()
    {
        return view('challenges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:time,task',
            'target_days' => 'required|integer|min:1',
            'target_seconds' => 'nullable|required_if:type,time|integer|min:60',
        ]);

        try {
            Challenge::create([
                'creator_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'target_seconds' => $request->type === 'time' ? $request->target_seconds : null,
                'target_days' => $request->target_days,
            ]);

            return redirect()->route('challenges.index')->with('success', 'Challenge created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create challenge. Please try again.');
        }
    }

    public function uploadProof(Request $request, Challenge $challenge)
    {
        $request->validate([
            'proof' => 'required|image|max:2048',
        ]);

        $task = ChallengeTask::where('challenge_id', $challenge->id)
            ->where('user_id', auth()->id())
            ->whereDate('date', now()->toDateString())
            ->first();

        if (!$task) {
            return back()->with('error', 'Task not found or not scheduled for today.');
        }

        try {
            $path = $request->file('proof')->store('proofs', 'public');
            $task->proof_image = $path;
            $task->save();

            return back()->with('success', 'Proof uploaded successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to upload proof. Please try again.');
        }
    }


    public function leave(Challenge $challenge)
    {
        try {
            $challenge->participants()->detach(auth()->id());
            return back()->with('success', 'You have left the challenge.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to leave the challenge.');
        }
    }

    public function show(Challenge $challenge)
    {
        $challenge->load([
            'participants' => function ($q) use ($challenge) {
                $q->withCount(['challengeTasks as completed_days' => function ($query) use ($challenge) {
                    $query->where('challenge_id', $challenge->id)
                        ->where('is_completed', true);
                }])->with(['characters' => function ($char) {
                    $char->orderByDesc('character_user.created_at');
                }]);
            },
            'tasks.user'
        ]);

        $submittedTasks = $challenge->tasks()->whereNotNull('proof_image')->with('user')->get();

        return view('challenges.show', compact('challenge', 'submittedTasks'));
    }

    public function destroy($id)
    {
        try {
            $challenge = Challenge::where('creator_id', auth()->id())->findOrFail($id);
            $challenge->delete();

            return redirect()->route('challenges.index')->with('success', 'Challenge deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('challenges.index')->with('error', 'Failed to delete the challenge.');
        }
    }

    public function removeParticipant(Challenge $challenge, User $user)
    {
        if (auth()->id() !== $challenge->creator_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        try {
            $challenge->participants()->detach($user->id);
            $challenge->tasks()->where('user_id', $user->id)->delete();

            return redirect()->back()->with('success', 'Participant removed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove participant.');
        }
    }

    public function participants(Challenge $challenge)
    {
        $challenge->load(['participants.characters', 'creator']);

        return view('challenges._participants', compact('challenge'));
    }
}
