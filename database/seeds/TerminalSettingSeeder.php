<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TerminalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTerminalSettings();
    }


    public function createTerminalSettings()
    {
        $terminal = [
            [
                'id'    => 1,
                'name'  => '帖子是否要审核',
                'key'   => 'post',
                'value' => '1',
                'type'  => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'id'    => 2,
                'name'  => '评论是否要审核',
                'key'   => 'comment',
                'value' => '1',
                'type'  => '1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'    => 3,
                'name'  => '英皇金融JPG',
                'key'   => 'jpg',
                'value' => '0',
                'type'  => '2',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'    => 4,
                'name'  => '英皇金融PDF',
                'key'   => 'pdf',
                'value' => '0',
                'type'  => '2',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

        ];
        if (!\App\Http\Models\Backend\TerminalSettings::count()) {
            DB::table('terminal_settings')->truncate();
            DB::table('terminal_settings')->insert($terminal);
        }
    }
}
