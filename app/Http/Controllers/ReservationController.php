<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Schedule;

class ReservationController extends Controller
{
    // Menampilkan semua data reservasi
    public function index()
    {
        $reservations = Reservation::with(['user', 'schedule', 'payment'])->get();
        return view('admin.reservation.index', compact('reservations'));
    }

    // Menampilkan form tambah data reservasi
    public function create()
    {
        $users = User::all();
        $schedules = Schedule::all();
        return view('admin.reservation.create', compact('users', 'schedules'));
    }

    // Menyimpan data reservasi baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'method' => 'required|string',
            'amount' => 'required|numeric',
            'status' => 'required|string',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'paid_at' => 'nullable|date',
        ]);

        $data = $request->only(['user_id', 'schedule_id', 'method', 'amount', 'status', 'paid_at']);

        // Upload bukti pembayaran jika ada
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/payment_proof'), $filename);
            $data['payment_proof'] = 'uploads/payment_proof/' . $filename;
        }

        Reservation::create($data);

        return redirect()->route('reservation.index')->with('success', 'Reservasi berhasil ditambahkan!');
    }

    // Menampilkan form edit reservasi
    public function edit(Reservation $reservation)
    {
        $users = User::all();
        $schedules = Schedule::all();
        return view('admin.reservation.edit', compact('reservation', 'users', 'schedules'));
    }

    // Memperbarui data reservasi
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'method' => 'required|string',
            'amount' => 'required|numeric',
            'status' => 'required|string',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'paid_at' => 'nullable|date',
        ]);

        $data = $request->only(['user_id', 'schedule_id', 'method', 'amount', 'status', 'paid_at']);

        // Jika upload bukti baru, hapus yang lama
        if ($request->hasFile('payment_proof')) {
            if ($reservation->payment_proof && file_exists(public_path($reservation->payment_proof))) {
                unlink(public_path($reservation->payment_proof));
            }
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/payment_proof'), $filename);
            $data['payment_proof'] = 'uploads/payment_proof/' . $filename;
        }

        $reservation->update($data);

        return redirect()->route('reservation.index')->with('success', 'Reservasi berhasil diperbarui!');
    }

    // Menghapus data reservasi
    public function destroy(Reservation $reservation)
    {
        if ($reservation->payment_proof && file_exists(public_path($reservation->payment_proof))) {
            unlink(public_path($reservation->payment_proof));
        }

        $reservation->delete();

        return redirect()->route('reservation.index')->with('success', 'Reservasi berhasil dihapus!');
    }
}
