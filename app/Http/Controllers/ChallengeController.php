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
        $userId = Auth::id();
        $today = Carbon::today();

        // Masukkan ke pivot table
        DB::table('challenge_user')->updateOrInsert([
            'user_id' => $userId,
            'challenge_id' => $id,
        ], [
            'joined_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Cek apakah task untuk hari ini sudah ada
        $taskExists = ChallengeTask::where('user_id', $userId)
            ->where('challenge_id', $id)
            ->whereDate('date', $today)
            ->exists();

        // Kalau belum ada, buat task baru untuk hari ini
        if (!$taskExists) {
            ChallengeTask::create([
                'user_id' => $userId,
                'challenge_id' => $id,
                'date' => $today,
                'is_completed' => false,
            ]);
        }

        return back()->with('success', 'Challenge joined successfully!');
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

        Challenge::create([
            'creator_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'target_seconds' => $request->type === 'time' ? $request->target_seconds : null,
            'target_days' => $request->target_days,
        ]);

        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully!');
    }

    public function uploadProof(Request $request, Challenge $challenge)
    {
        $request->validate([
            'proof' => 'required|image|max:2048', // pastikan validasi sesuai
        ]);

        // Ambil task hari ini milik user untuk challenge ini
        $task = ChallengeTask::where('challenge_id', $challenge->id)
            ->where('user_id', auth()->id())
            ->whereDate('date', now()->toDateString())
            ->first();

        if (!$task) {
            return back()->with('error', 'Task not found or not for today.');
        }

        // Simpan file
        $path = $request->file('proof')->store('proofs', 'public');

        // Update task dengan path proof_image
        $task->proof_image = $path;
        $task->save();

        return back()->with('success', 'Proof uploaded successfully.');
    }

    public function leave(Challenge $challenge)
    {
        $user = auth()->user();

        // Hapus dari challenge_user pivot table
        $challenge->participants()->detach($user->id);

        return back()->with('success', 'You have left the challenge.');
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
        $challenge = Challenge::where('creator_id', auth()->id())->findOrFail($id);
        $challenge->delete();

        return redirect()->route('challenges.index')->with('status', 'Challenge deleted successfully.');
    }

    public function removeParticipant(Challenge $challenge, User $user)
    {
        // Pastikan hanya creator yang bisa menghapus
        if (auth()->id() !== $challenge->creator_id) {
            abort(403);
        }

        // Hapus partisipasi user dari challenge (misal: pivot table atau progress)
        $challenge->participants()->detach($user->id);

        // Jika kamu juga ingin hapus task / progress mereka:
        $challenge->tasks()->where('user_id', $user->id)->delete();

        return redirect()->back()->with('success', 'Participant removed successfully.');
    }

    public function participants(Challenge $challenge)
    {
        $challenge->load(['participants.characters', 'creator']);

        return view('challenges._participants', compact('challenge'));
    }
}
