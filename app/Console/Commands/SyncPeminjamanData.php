<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\PeminjamanBuku;

class SyncPeminjamanData extends Command
{
    protected $signature = 'data:sync-peminjaman';
    protected $description = 'Sinkronisasi data peminjaman buku dari SQL Server';

    public function handle()
    {
        $this->info('Memulai sinkronisasi data peminjaman...');

        // Gunakan koneksi dari .env atau session (jika dinamis, tinggal ubah di sini)
        $connection = DB::connection('sqlsrv_elib_local'); // atau dari session

        // Query utama
        $query = "
            SELECT
                Circ.ItemNo,
                Circ.ChkODate,
                Circ.DueDate,
                Circ.ChkIDate,
                Patron.FName,
                CLevel.[Desc] as Fakultas,
                Title.TitKey AS Judul
            FROM
                CMCirculation AS Circ
            INNER JOIN CItem AS Item ON Circ.ItemNo = Item.ItemNo
            INNER JOIN EBib AS Bib ON Item.ItemBib = Bib.BibId
            LEFT JOIN ETit AS Title ON Bib.BibId = Title.TitId -- LEFT JOIN agar tetap ambil data walau tidak ada judul
            INNER JOIN CPatron AS Patron ON Circ.ID = Patron.ID
            INNER JOIN CLevel ON Patron.[Level] = CLevel.LvlCode
        ";

        try {
            $records = $connection->table(DB::raw("({$query}) as sub"))
                                  ->orderBy('ChkODate')
                                  ->get();

            $this->info('Jumlah data ditemukan: ' . $records->count());

            $processed = 0;

            foreach ($records as $record) {
                PeminjamanBuku::updateOrCreate(
                    [
                        'item_no'   => $record->ItemNo,
                        'loan_date' => $record->ChkODate,
                    ],
                    [
                        'book_title'       => isset($record->Judul) ? ltrim(str_replace(['\a', '\b', '\c'], ' ', $record->Judul)) : 'Judul Tidak Tersedia',
                        'borrower_name'    => $record->FName ?? 'Tidak diketahui',
                        'borrower_faculty' => $record->Fakultas ?? 'Tidak diketahui',
                        'due_date'         => $record->DueDate,
                        'return_date'      => $record->ChkIDate,
                    ]
                );

                $processed++;
                if ($processed % 100 === 0) {
                    $this->line("...{$processed} data diproses");
                }
            }

            $this->info("Sinkronisasi selesai! Total data diproses: $processed");

        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
        }

        return 0;
    }
}
