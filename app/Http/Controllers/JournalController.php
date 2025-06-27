<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $journals = Journal::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $thumbnails = $journals
            ->filter(fn($j) => $j->image_path)
            ->mapWithKeys(fn($j) => [$j->date->toDateString() => $j->image_path]);

        $selectedDay = $request->input('selected');
        $selectedJournal = null;
        if ($selectedDay) {
            $selectedJournal = $journals->first(fn($j) => $j->date->toDateString() === $selectedDay);
        }

        return view('journal.index', [
            'journals' => $journals,
            'thumbnails' => $thumbnails,
            'selectedDay' => $selectedDay,
            'selectedJournal' => $selectedJournal,
            'month' => $month,
            'year' => $year,
        ]);
    }

    public function create(Request $request)
    {
        $date = $request->input('date');
        return view('journal.create', compact('date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg|max:5120', // max 5MB
        ]);

        $user = Auth::user();

        $existing = Journal::where('user_id', $user->id)
            ->whereDate('date', $request->date)
            ->first();

        if ($existing) {
            return redirect()->route('journal.index')->with('error', 'Sudah ada jurnal untuk tanggal tersebut.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('journal_images', 'public');
        }

        Journal::create([
            'user_id' => $user->id,
            'date' => $request->date,
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('journal.index')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function show(Journal $journal)
    {
        $this->authorize('view', $journal);
        return view('journal.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        $this->authorize('update', $journal);
        return view('journal.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $this->authorize('update', $journal);

        $request->validate([
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg|max:5120',
        ]);

        $data = [
            'content' => $request->content,
        ];

        if ($request->hasFile('image')) {
            if ($journal->image_path) {
                Storage::disk('public')->delete($journal->image_path);
            }
            $data['image_path'] = $request->file('image')->store('journal_images', 'public');
        }

        $journal->update($data);

        return redirect()->route('journal.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy(Journal $journal)
    {
        $this->authorize('delete', $journal);

        if ($journal->image_path) {
            Storage::disk('public')->delete($journal->image_path);
        }

        $journal->delete();

        return redirect()->route('journal.index')->with('success', 'Jurnal berhasil dihapus.');
    }
}
