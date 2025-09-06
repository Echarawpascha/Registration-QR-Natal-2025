<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function showScanForm()
    {
        return view('panitia.scan');
    }

    public function scanBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $barcode = $request->barcode;
        $panitia = Auth::guard('panitia')->user();

        // Find peserta by barcode
        $peserta = Peserta::where('barcode', $barcode)->first();

        if (!$peserta) {
            return response()->json([
                'success' => false,
                'message' => 'Barcode tidak ditemukan atau tidak valid.',
            ], 404);
        }

        // Remove check for peserta is_confirmed here, scanning is the confirmation step
        // if (!$peserta->is_confirmed) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Peserta belum dikonfirmasi.',
        //     ], 400);
        // }

        // Check if attendance already exists for today
        $existingAttendance = Attendance::where('peserta_id', $peserta->id)
            ->whereDate('event_date', today())
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta sudah tercatat hadir hari ini.',
                'data' => [
                    'peserta' => $peserta->name,
                    'scanned_at' => $existingAttendance->scanned_at->format('H:i:s'),
                ]
            ], 409);
        }

        // Create new attendance record
        $attendance = Attendance::create([
            'panitia_id' => $panitia->id,
            'peserta_id' => $peserta->id,
            'event_date' => today(),
            'status' => 'present',
            'scanned_at' => now(),
        ]);

        // Update peserta is_confirmed to true after scanning
        if (!$peserta->is_confirmed) {
            $peserta->is_confirmed = true;
            $peserta->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dicatat!',
            'data' => [
                'peserta' => $peserta->name,
                'scanned_at' => $attendance->scanned_at->format('H:i:s'),
            ]
        ]);
    }

    public function getTodayAttendances()
    {
        $attendances = Attendance::with('peserta')
            ->whereDate('event_date', today())
            ->orderBy('scanned_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attendances->map(function ($attendance) {
                return [
                    'peserta_name' => $attendance->peserta->name,
                    'scanned_at' => $attendance->scanned_at->format('H:i:s'),
                    'status' => $attendance->status,
                    'profile_image' => $attendance->peserta->profile_image ? asset('storage/' . $attendance->peserta->profile_image) : asset('storage/profile_images/profile.png'),
                    'phone' => $attendance->peserta->phone,
                    'email' => $attendance->peserta->email,
                    'church_origin' => $attendance->peserta->church_origin,
                ];
            })
        ]);
    }

    public function showAttendanceList()
    {
        return view('panitia.attendance-list');
    }

    public function downloadPdf()
    {
        $attendances = Attendance::with('peserta')
            ->whereDate('event_date', today())
            ->orderBy('scanned_at', 'desc')
            ->get();

        $data = $attendances->map(function ($attendance) {
            return [
                'peserta_name' => $attendance->peserta->name,
                'scanned_at' => $attendance->scanned_at->format('H:i:s'),
                'status' => $attendance->status,
                'phone' => $attendance->peserta->phone,
                'email' => $attendance->peserta->email,
                'church_origin' => $attendance->peserta->church_origin,
            ];
        });

        $pdf = \PDF::loadView('panitia.attendance-pdf', compact('data'));

        return $pdf->download('daftar_absensi_hari_ini_' . now()->format('Y-m-d') . '.pdf');
    }
}
