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

    protected function adminUserSeeder()
    {
        $user = [
            [
                'id'             => 1,
                'name'           => 'zhanglong',
                'password'       => Hash::make(123456),// password_hash('123456', PASSWORD_BCRYPT),
                'create_user_id' => '0',
                'email'          => '1428804176@qq.com',
                'created_at'     => date("Y-m-d H:i:s"),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'id'             => 2,
                'name'           => 'shengyulong',
                'password'       => Hash::make(123456),// password_hash('123456', PASSWORD_BCRYPT),
                'create_user_id' => '0',
                'email'          => 'shengyulong@qq.com',
                'created_at'     => date("Y-m-d H:i:s"),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];
        if (\App\Http\Models\Backend\Users::count() == 0) {
            DB::table('users')->insert($user);
        }
    }

    protected function roleSeeder()
    {
        $role_user = [
            [
                'user_id'    => 1,
                'role_id'    => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'user_id'    => 1,
                'role_id'    => 2,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'user_id'    => 1,
                'role_id'    => 3,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'user_id'    => 1,
                'role_id'    => 4,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'user_id'    => 1,
                'role_id'    => 5,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'    => 2,
                'role_id'    => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'user_id'    => 2,
                'role_id'    => 4,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'user_id'    => 2,
                'role_id'    => 5,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $roles = [
            [
                'id'          => 1,
                'name'        => '超级管理员',
                'super_admin' => '1',
                'created_at'  => date("Y-m-d H:i:s"),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 2,
                'name'        => '栏目管理员',
                'super_admin' => '0',
                'created_at'  => date("Y-m-d H:i:s"),
                'updated_at'  => date('Y-m-d H:i:s'),
            ], [
                'id'          => 3,
                'name'        => '角色管理员',
                'super_admin' => '0',
                'created_at'  => date("Y-m-d H:i:s"),
                'updated_at'  => date('Y-m-d H:i:s'),
            ], [
                'id'          => 4,
                'name'        => '会员管理员',
                'super_admin' => '0',
                'created_at'  => date("Y-m-d H:i:s"),
                'updated_at'  => date('Y-m-d H:i:s'),
            ], [
                'id'          => 5,
                'name'        => '评论管理员',
                'super_admin' => '0',
                'created_at'  => date("Y-m-d H:i:s"),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 6,
                'name'        => '图表管理员',
                'super_admin' => '0',
                'created_at'  => date("Y-m-d H:i:s"),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 7,
                'name'        => '下载管理员',
                'super_admin' => '0',
                'created_at'  => date("Y-m-d H:i:s"),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]
        ];

        if (\App\Http\Models\Backend\UserRole::count() == 0) {
            DB::table('user_role')->insert($role_user);
        }

        if (\App\Http\Models\Backend\Roles::count() == 0) {
            DB::table('roles')->insert($roles);
        }

    }

    protected function authSeeder()
    {
        $auths = [
            [
                'id'         => 1,
                'prm'        => 'column',
                'name'       => '轮播图',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 3,
                'prm'        => 'user',
                'name'       => '用户',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 2,
                'prm'        => 'role',
                'name'       => '角色',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id'         => 4,
                'prm'        => 'member',
                'name'       => '会员',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ], [
                'id'         => 5,
                'prm'        => 'post',
                'name'       => '帖子',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],[
                'id'         => 6,
                'prm'        => 'setting',
                'name'       => '系统配置',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],[
                'id'         => 7,
                'prm'        => 'chart',
                'name'       => '图表',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
//            [
//                'id'         => 8,
//                'prm'        => 'about',
//                'name'       => '关于我们',
//                'created_at' => date("Y-m-d H:i:s"),
//                'updated_at' => date('Y-m-d H:i:s'),
//            ],
            [
                'id'         => 9,
                'prm'        => 'chart',
                'name'       => '下载',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 10,
                'prm'        => 'register',
                'name'       => '下载',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 11,
                'prm'        => 'analog',
                'name'       => '模拟表单',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id'         => 9,
                'prm'        => 'file',
                'name'       => '文件',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        if (!\App\Http\Models\Backend\Auths::count()) {
            DB::table('auths')->truncate();
            DB::table('auths')->insert($auths);
        }

        $role_auth =
            [
                [
                    'id'         => 1,
                    'role_id'    => 1,
                    'auth_id'    => 1,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 2,
                    'role_id'    => 1,
                    'auth_id'    => 2,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 3,
                    'role_id'    => 1,
                    'auth_id'    => 3,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 4,
                    'role_id'    => 1,
                    'auth_id'    => 4,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 5,
                    'role_id'    => 1,
                    'auth_id'    => 5,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 5,
                    'role_id'    => 1,
                    'auth_id'    => 6,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 5,
                    'role_id'    => 1,
                    'auth_id'    => 7,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 5,
                    'role_id'    => 1,
                    'auth_id'    => 8,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 5,
                    'role_id'    => 1,
                    'auth_id'    => 9,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 5,
                    'role_id'    => 1,
                    'auth_id'    => 10,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 5,
                    'role_id'    => 1,
                    'auth_id'    => 11,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 5,
                    'role_id'    => 1,
                    'auth_id'    => 12,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],

                [
                    'id'         => 6,
                    'role_id'    => 2,
                    'auth_id'    => 2,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 7,
                    'role_id'    => 3,
                    'auth_id'    => 3,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 8,
                    'role_id'    => 4,
                    'auth_id'    => 4,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 9,
                    'role_id'    => 5,
                    'auth_id'    => 5,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 10,
                    'role_id'    => 1,
                    'auth_id'    => 6,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 11,
                    'role_id'    => 1,
                    'auth_id'    => 7,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'id'         => 12,
                    'role_id'    => 1,
                    'auth_id'    => 8,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ];
        DB::table('role_auth')->truncate();
        DB::table('role_auth')->insert($role_auth);

    }
}
