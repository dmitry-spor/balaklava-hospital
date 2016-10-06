<?php

use Illuminate\Database\Seeder;

class DischargesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 5) as $day)
            foreach (range(1, 40) as $index) {
                DB::table('discharges')->insert([
                    'inspection_date' => '2016-10-'.$day,
                    'result_text' => 'результат осмотра в виде текста \'все норм\'',
                    'patient_id' => $index,
                    'doctor_id' => 4 * (($index % 3) + 1)
                ]);
            }
    }
}
