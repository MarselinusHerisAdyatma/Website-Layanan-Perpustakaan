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

        $connection = DB::connection('sqlsrv');

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
            INNER JOIN ETit AS Title ON Bib.BibId = Title.TitId
            INNER JOIN CPatron AS Patron ON Circ.ID = Patron.ID
            INNER JOIN CLevel ON Patron.[Level] = CLevel.LvlCode
        ";

        $connection->table(DB::raw("({$query}) as sub"))->orderBy('ChkODate')->chunk(200, function ($records) {
            foreach ($records as $record) {
                PeminjamanBuku::updateOrCreate(
                    [
                        'item_no' => $record->ItemNo,
                        'loan_date' => $record->ChkODate,
                    ],

                    [
                        'book_title' => ltrim(str_replace(['\a', '\b', '\c'], ' ', $record->Judul)),
                        'borrower_name' => $record->FName,
                        'borrower_faculty' => $record->Fakultas,
                        'due_date' => $record->DueDate,
                        'return_date' => $record->ChkIDate,
                    ]
                );
            }
            $this->line('...200 data peminjaman diproses.');
        });

        $this->info('Sinkronisasi data peminjaman selesai!');
        return 0;
    }
}