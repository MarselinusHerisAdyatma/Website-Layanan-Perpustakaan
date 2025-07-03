<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;
use App\Models\Profession;
use App\Models\Education;
use App\Models\Gender;
use App\Models\VisitPurpose;
use App\Models\Location;
use App\Models\Status;
use Carbon\Carbon;

class SyncLegacyData extends Command
{
    protected $signature = 'data:sync-legacy';
    protected $description = 'Sinkronisasi data pengunjung dari database legacy InliSLite';

    private $relationMap = [
        ['legacy_table' => 'master_pekerjaan',    'model' => Profession::class,   'legacy_id' => 'id', 'legacy_name' => 'Pekerjaan'],
        ['legacy_table' => 'master_pendidikan',   'model' => Education::class,    'legacy_id' => 'id', 'legacy_name' => 'Nama'],
        ['legacy_table' => 'jenis_kelamin',       'model' => Gender::class,       'legacy_id' => 'ID', 'legacy_name' => 'Name'],
        ['legacy_table' => 'tujuan_kunjungan',    'model' => VisitPurpose::class, 'legacy_id' => 'ID', 'legacy_name' => 'TujuanKunjungan'],
        ['legacy_table' => 'locations',           'model' => Location::class,     'legacy_id' => 'ID', 'legacy_name' => 'Name'],
        ['legacy_table' => 'status_anggota',      'model' => Status::class,       'legacy_id' => 'id', 'legacy_name' => 'Nama'],
    ];

    public function handle()
    {
        $this->info('Memulai sinkronisasi data dari database legacy...');
        $this->line('----------------------------------------------------');

        foreach ($this->relationMap as $map) {
            $this->syncRelationalTable($map['legacy_table'], $map['model'], $map['legacy_id'], $map['legacy_name']);
        }
        
        $this->line('----------------------------------------------------');

        $this->syncVisitorsTable();

        $this->info('Sinkronisasi data selesai dengan sukses!');
        return 0;
    }

    private function syncRelationalTable($legacyTableName, $modelClass, $legacyIdColumn, $legacyNameColumn)
    {
        $this->line("-> Menyinkronkan: {$legacyTableName}");
        try {
            $legacyData = DB::connection('mysql_xampp')->table($legacyTableName)->get();
            foreach ($legacyData as $data) {
                $modelClass::updateOrCreate(
                    ['legacy_id' => $data->$legacyIdColumn],
                    ['name' => $data->$legacyNameColumn]
                );
            }
            $this->info("   [OK] Sinkronisasi '{$legacyTableName}' selesai.");
        } catch (\Exception $e) {
            $this->error("   [GAGAL] Gagal mengakses tabel atau kolom di '{$legacyTableName}'. Pesan: " . $e->getMessage());
        }
    }

    private function syncVisitorsTable()
    {
        $this->line('-> Menyinkronkan tabel utama memberguesses...');

        $professions = Profession::pluck('id', 'legacy_id');
        $educations = Education::pluck('id', 'legacy_id');
        $genders = Gender::pluck('id', 'legacy_id');
        $visitPurposes = VisitPurpose::pluck('id', 'legacy_id');
        $locations = Location::pluck('id', 'legacy_id');
        $statuses = Status::pluck('id', 'legacy_id');

        DB::connection('mysql_xampp')->table('memberguesses')->whereNotNull('NoPengunjung')->orderBy('ID')->chunk(200, function ($visitors) use ($professions, $educations, $genders, $visitPurposes, $locations, $statuses) {
            foreach ($visitors as $data) {
                Visitor::updateOrCreate(
                    ['visitor_number' => $data->NoPengunjung],
                    [
                        'name' => $data->Nama,
                        'address' => $data->Alamat,
                        'student_id' => $data->NoAnggota,
                        'notes' => trim($data->Deskripsi . ' ' . $data->Information),
                        'visited_at' => Carbon::parse($data->CreateDate),
                        
                        'gender_id' => $genders[$data->JenisKelamin_id] ?? null,
                        'profession_id' => $professions[$data->Profesi_id] ?? null,
                        'education_id' => $educations[$data->PendidikanTerakhir_id] ?? null,
                        'visit_purpose_id' => $visitPurposes[$data->TujuanKunjungan_Id] ?? null,
                        'location_id' => $locations[$data->Location_Id] ?? null,
                        'status_id' => $statuses[$data->Status_id] ?? null,
                    ]
                );
            }
            $this->line('   ...200 data pengunjung diproses.');
        });
        
        $this->info("   [OK] Sinkronisasi tabel pengunjung utama selesai.");
    }
}