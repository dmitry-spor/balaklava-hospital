<?php

use Illuminate\Database\Seeder;

class OperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(2, 4) as $day) {
            foreach (range(1, 20) as $index) {
                DB::table('operations')->insert([
                    'operation_date' => '2016-10-' . $day,
                    'operation_name' => 'название операции .. №' . ($index - 19),
                    'preliminary_epicrisis' => 'у пациента что-то болело, это надо было удалить/поправить',
                    'result' => 'операция прошла успешно',
                    'patient_id' => $index,
                    'doctor_id' => 3 + ((($index - 1) % 4) * 4)
                ]);
            }
        }
    }
}