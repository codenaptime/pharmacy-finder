<?php

use Illuminate\Database\Seeder;
use JeroenZwart\CsvSeeder\CsvSeeder;

class PharmacySeeder extends CsvSeeder
{
    
    public function __construct()
    {
        $this->delimiter = ',';
        $this->file = '/database/seeds/csvs/pharmacies.csv';
        $this->mapping = ['name', 'address','city', 'state', 'zip', 'latitude', 'longitude'];
        $this->tablename = 'pharmacies';
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();
        parent::run();
    }
}
