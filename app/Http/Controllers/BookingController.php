<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Member;
use App\Models\Jasa;
use App\Models\Kapster;
use Carbon\Carbon;

use App\Services\WAService;

class BookingController extends Controller
{
    public function store(Request $request, WAService $waService)
    {
        $request->validate([
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'layanan' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required|string',
            'catatan' => 'nullable|string',
            'barber' => 'nullable|string',
        ]);

        // Find or create member
        $member = Member::firstOrCreate(
            ['nomor_wa' => $request->no_hp],
            ['nama' => $request->nama, 'alamat' => null]
        );

        // Find jasa by name (assuming 'layanan' is the name)
        $jasa = Jasa::where('nama', $request->layanan)->first();

        // Find kapster if selected
        $kapster = null;
        if ($request->barber) {
            $kapster = Kapster::where('nama', $request->barber)->first();
        }

        // Create transaksi with status 'menunggu'
        $transaksi = Transaksi::create([
            'nama' => $member->nama,
            'no_hp' => $member->nomor_wa,
            'tanggal' => $request->tanggal,
            'jasa_id' => $jasa ? $jasa->id : null,
            'jumlah' => 1,
            'total_harga' => $jasa ? $jasa->harga : 0,
            'status' => 'menunggu',
            'kapster_id' => $kapster ? $kapster->id : null,
            'catatan' => $request->catatan,
        ]);

        // Attach jasa if found
        if ($jasa) {
            $transaksi->jasa()->attach($jasa->id);
        }

        // Kirim konfirmasi WA
        $waService->sendBookingConfirmation($transaksi);

        return response()->json(['success' => true, 'message' => 'Booking berhasil!']);
    }
}
