<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class JournalController extends Controller
{
    /**
     * Tampilkan halaman utama jurnal dengan kalender dan entri terpilih.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Ambil semua jurnal bulan & tahun tertentu
        $journals = Journal::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // Ambil thumbnail untuk setiap jurnal yang punya gambar
        $thumbnails = $journals
            ->filter(fn($j) => $j->image_path)
            ->mapWithKeys(fn($j) => [$j->date->toDateString() => $j->image_path]);

        // Tangani pemilihan hari tertentu
        $selectedDay = $request->input('selected');
        $selectedJournal = null;
        $selectedDayLabel = null;

        if ($selectedDay) {
            $date = Carbon::parse($selectedDay)->startOfDay();

            $selectedJournal = Journal::where('user_id', $user->id)
                ->whereDate('date', $date)
                ->first();

            $selectedDayLabel = $date->translatedFormat('l, d F Y');
        }

        $editMode = $request->boolean('edit');

        // Tombol navigasi pilihan bulan
        $prevMonth = \Carbon\Carbon::create($year, $month, 1)->subMonth();
        $nextMonth = \Carbon\Carbon::create($year, $month, 1)->addMonth();

        // Siapkan data kalender
        $start = Carbon::create($year, $month)->startOfMonth();
        $end = $start->copy()->endOfMonth();
        $firstDayOfWeek = $start->dayOfWeek;
        $daysInMonth = $start->daysInMonth;
        $calendarStartDate = $start->copy()->subDays($firstDayOfWeek);

        $monthYearLabel = strtoupper(Carbon::create()->month($month)->year($year)->translatedFormat('F Y'));

        // Opsi bulan untuk dropdown
        $monthOptions = collect(range(1, 12))->mapWithKeys(fn($m) => [
            $m => Carbon::create()->month($m)->translatedFormat('F')
        ]);

        // Susun kalender mingguan
        $weeks = [];
        $date = $calendarStartDate->copy();

        for ($week = 0; $week < 6; $week++) {
            $weekRow = [];

            for ($day = 0; $day < 7; $day++) {
                $currentDate = $date->copy();
                $key = $currentDate->toDateString();
                $journal = $journals->first(fn($j) => $j->date->toDateString() === $key);

                $weekRow[] = [
                    'date' => $currentDate,
                    'inMonth' => $currentDate->month == $month,
                    'thumbnail' => $journal?->image_path,
                    'hasJournal' => !!$journal,
                    'content' => $journal?->content,
                ];

                $date->addDay();
            }

            $weeks[] = $weekRow;
        }

        // Kirim data ke view
        return view('journal.index', compact(
            'journals',
            'thumbnails',
            'selectedDay',
            'selectedJournal',
            'month',
            'year',
            'weeks',
            'calendarStartDate',
            'daysInMonth',
            'monthYearLabel',
            'monthOptions',
            'selectedDayLabel',
            'editMode'
        ));
    }

    /**
     * Tampilkan form untuk membuat jurnal baru.
     */
    public function create(Request $request)
    {
        $date = $request->input('date');
        return view('journal.create', compact('date'));
    }

    /**
     * Simpan jurnal baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $user = Auth::user();
        $journalDate = Carbon::parse($request->date)->startOfDay();

        // Cegah input untuk tanggal masa depan
        if ($journalDate->isFuture()) {
            return redirect()->route('journal.index');
        }

        // Cek apakah jurnal sudah ada di tanggal tersebut
        $existing = Journal::where('user_id', $user->id)
            ->whereDate('date', $request->date)
            ->first();

        if ($existing) {
            return redirect()->route('journal.index');
        }

        // Simpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('journal_images', 'public');
        }

        // Simpan jurnal
        Journal::create([
            'user_id' => $user->id,
            'date' => $request->date,
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('journal.index');
    }

    /**
     * Tampilkan detail jurnal.
     */
    public function show(Journal $journal)
    {
        $this->authorize('view', $journal);
        return view('journal.show', compact('journal'));
    }

    /**
     * Tampilkan form edit jurnal.
     */
    public function edit(Journal $journal)
    {
        $this->authorize('update', $journal);
        return view('journal.edit', compact('journal'));
    }

    /**
     * Update jurnal yang ada.
     */
    public function update(Request $request, Journal $journal)
    {
        $this->authorize('update', $journal);

        $request->validate([
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = ['content' => $request->content];

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($journal->image_path) {
                Storage::disk('public')->delete($journal->image_path);
            }

            // Simpan gambar baru
            $data['image_path'] = $request->file('image')->store('journal_images', 'public');
        }

        $journal->update($data);

        return redirect()->route('journal.index');
    }

    /**
     * Hapus jurnal beserta gambar jika ada.
     */
    public function destroy(Journal $journal)
    {
        $this->authorize('delete', $journal);

        if ($journal->image_path) {
            Storage::disk('public')->delete($journal->image_path);
        }

        $journal->delete();

        return redirect()->route('journal.index');
    }
}
