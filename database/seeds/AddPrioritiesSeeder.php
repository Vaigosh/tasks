<?php

use Illuminate\Database\Seeder;
use \App\Priority;
use \Illuminate\Support\Facades\DB;

class AddPrioritiesSeeder extends Seeder
{
    private $data = [
        [
            'id' => 1,
            'title' => 'Низкий',
        ],
        [
            'id' => 2,
            'title' => 'Средний',
        ],
        [
            'id' => 3,
            'title' => 'Высокий',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Priority::all()->count() >= 3) {
            return;
        }
        DB::table('priorities')->insert($this->data);
    }
}
