<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class AdminAuthRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->adminUserSeeder();
        $this->roleSeeder();
        $this->authSeeder();
    }

    protected function adminUserSeeder(){
        $user = [
            [
                'id'             => 1,
                'name'           => 'zhanglong',
                'password'       => Hash::make(123456),// password_hash('123456', PASSWORD_BCRYPT),
                'create_user_id' => '0',
                'email'          => '1428804176@qq.com'
            ],
            [
                'id'             => 2,
                'name'           => 'shengyulong',
                'password'       => Hash::make(123456),// password_hash('123456', PASSWORD_BCRYPT),
                'create_user_id' => '0',
                'email'          => 'shengyulong@qq.com'
            ]
        ];
        if (\App\Http\Models\Backend\Users::count() == 0) {
            DB::table('users')->insert($user);
        }
    }

    protected function roleSeeder(){
        $role_user = [
            [
                'user_id' => 1,
                'role_id' => 1
            ], [
                'user_id' => 1,
                'role_id' => 2
            ], [
                'user_id' => 1,
                'role_id' => 3
            ], [
                'user_id' => 1,
                'role_id' => 4
            ], [
                'user_id' => 1,
                'role_id' => 5
            ],
            [
                'user_id' => 2,
                'role_id' => 1
            ], [
                'user_id' => 2,
                'role_id' => 2
            ], [
                'user_id' => 2,
                'role_id' => 3
            ], [
                'user_id' => 2,
                'role_id' => 4
            ], [
                'user_id' => 2,
                'role_id' => 5
            ],
        ];

        $roles = [
            [
                'id'=>1,
                'name'=>'超级管理员',
            ], [
                'id'=>2,
                'name'=>'栏目管理员'
            ],[
                'id'=>3,
                'name'=>'角色管理员'
            ],[
                'id'=>4,
                'name'=>'会员管理员'
            ],[
                'id'=>5,
                'name'=>'评论管理员'
            ]
        ];

        if (\App\Http\Models\Backend\UserRole::count() == 0) {
            DB::table('user_role')->insert($role_user);
        }

        if (\App\Http\Models\Backend\Roles::count() == 0) {
            DB::table('roles')->insert($roles);
        }
    }

    protected function authSeeder(){
        $auths = [
            [
                'id'=>1,
                'prm'=>'column',
                'name'=>'栏目'
            ],
            [
                'id'=>3,
                'prm'=>'admin',
                'name'=>'管理员'
            ],
            [
                'id'=>2,
                'prm'=>'role',
                'name'=>'角色'
            ],[
                'id'=>4,
                'prm'=>'member',
                'name'=>'会员'
            ],[
                'id'=>5,
                'prm'=>'post',
                'name'=>'帖子'
            ]
        ];
        if(!\App\Http\Models\Backend\Auths::count()){
            DB::table('auths')->truncate();
            DB::table('auths')->insert($auths);
        }

        $role_auth =
            [
                ['id'=>1,'role_id'=>1,'auth_id'=>1],
                ['id'=>2,'role_id'=>1,'auth_id'=>2],
                ['id'=>3,'role_id'=>1,'auth_id'=>3],
                ['id'=>4,'role_id'=>1,'auth_id'=>4],
                ['id'=>5,'role_id'=>1,'auth_id'=>5],
                ['id'=>6,'role_id'=>2,'auth_id'=>2],
                ['id'=>7,'role_id'=>3,'auth_id'=>3],
                ['id'=>8,'role_id'=>4,'auth_id'=>4],
                ['id'=>9,'role_id'=>5,'auth_id'=>5],

        ];
        
        DB::table('role_auth')->insert($role_auth);
        
    }
}
