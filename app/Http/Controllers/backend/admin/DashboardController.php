<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthenticationMiddleware;
use App\Http\Middleware\BackendAuthenticationMiddleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            BackendAuthenticationMiddleware::class,
            AdminAuthenticationMiddleware::class
        ];
    }

    public function dashboard()
    {
        $data = [];

        // Basic page info
        $data['active_menu'] = 'dashboard';
        $data['page_title']  = 'Dashboard';

        // Default values (so blade never breaks)
        $data['single_room']       = 0;
        $data['super_deluxe_room'] = 0;
        $data['double_room']       = 0;
        $data['alpha_room']        = 0;
        $data['royal_suite']       = 0;
        $data['king_appt']         = 0;

        $data['total_guests']    = 0;
        $data['total_invoice']   = 0;
        $data['total_accounts']  = 0;

        // ✅ Detect tables/columns and fill counts
        try {
            // 1) Detect rooms table
            $roomsTable = $this->firstExistingTable([
                'rooms', 'room', 'room_manage', 'room_manages', 'room_lists', 'room_list',
                'hotel_rooms', 'tbl_rooms'
            ]);

            // 2) Detect room type column
            $roomTypeColumn = $roomsTable
                ? $this->firstExistingColumn($roomsTable, ['room_type', 'type', 'category', 'name', 'title'])
                : null;

            // 3) Count room types (case-insensitive)
            if ($roomsTable && $roomTypeColumn) {
                $data['single_room']       = $this->countByTypeCI($roomsTable, $roomTypeColumn, ['SINGLE ROOM', 'Single Room']);
                $data['super_deluxe_room'] = $this->countByTypeCI($roomsTable, $roomTypeColumn, ['SUPER DELUXE ROOM', 'Super Deluxe Room']);
                $data['double_room']       = $this->countByTypeCI($roomsTable, $roomTypeColumn, ['DOUBLE ROOM', 'Double Room']);
                $data['alpha_room']        = $this->countByTypeCI($roomsTable, $roomTypeColumn, ['ALPHA ROOM', 'Alpha Room']);
                $data['royal_suite']       = $this->countByTypeCI($roomsTable, $roomTypeColumn, ['ROYAL SUITE', 'Royal Suite']);
                $data['king_appt']         = $this->countByTypeCI($roomsTable, $roomTypeColumn, ['KING APPT', 'King Appt', 'KING APARTMENT', 'King Apartment']);
            }

            // 4) Detect guests/invoices/accounts tables and count rows
            $guestsTable = $this->firstExistingTable(['guests', 'guest', 'guest_lists', 'guest_list', 'customers', 'clients']);
            if ($guestsTable) {
                $data['total_guests'] = DB::table($guestsTable)->count();
            }

            $invoicesTable = $this->firstExistingTable(['invoices', 'invoice', 'invoice_lists', 'invoice_list', 'billings', 'bills']);
            if ($invoicesTable) {
                $data['total_invoice'] = DB::table($invoicesTable)->count();
            }

            $accountsTable = $this->firstExistingTable(['accounts', 'account', 'account_lists', 'account_list', 'transactions', 'payments']);
            if ($accountsTable) {
                $data['total_accounts'] = DB::table($accountsTable)->count();
            }

        } catch (\Throwable $e) {
            // keep defaults (0) if anything fails
        }

        return view('backend.admin.pages.dashboard', compact('data'));
    }

    /**
     * Return first table name that exists in DB, otherwise null.
     */
    private function firstExistingTable(array $candidates): ?string
    {
        foreach ($candidates as $table) {
            if (Schema::hasTable($table)) {
                return $table;
            }
        }
        return null;
    }

    /**
     * Return first column name that exists for a given table, otherwise null.
     */
    private function firstExistingColumn(string $table, array $candidates): ?string
    {
        foreach ($candidates as $col) {
            if (Schema::hasColumn($table, $col)) {
                return $col;
            }
        }
        return null;
    }

    /**
     * Case-insensitive count helper:
     * Tries multiple possible labels (e.g., "SINGLE ROOM", "Single Room").
     */
    private function countByTypeCI(string $table, string $column, array $labels): int
    {
        // Use LOWER() so it works regardless of DB collation/case
        $lowered = array_map(fn ($v) => mb_strtolower($v), $labels);

        return DB::table($table)
            ->whereIn(DB::raw("LOWER($column)"), $lowered)
            ->count();
    }
}
