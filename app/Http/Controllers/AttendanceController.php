<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
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
        $panitia = Auth::guard('panitia')->user();

        $attendances = Attendance::with('peserta')
            ->where('panitia_id', $panitia->id)
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
                ];
            })
        ]);
    }
}
