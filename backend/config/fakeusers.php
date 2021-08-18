<?php
return [
    'users' => [
        0 => [
            'id' => 1,
            'uuid' => '58f9d95f-12e8-435b-a559-0c6272901231',
            'avatar' => 'https://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46',
            'name' => '斯派克',
            'email' => 'spike@example.com',
            'groups' => [
                [
                    'id' => 1,
                    'name' => '机械',
                    'pivot' => [
                        'user_id' => 1,
                        'group_id' => 1,
                        'power' => 2,
                    ],
                ],
                [
                    'id' => 2,
                    'name' => '电控',
                    'pivot' => [
                        'user_id' => 1,
                        'group_id' => 2,
                        'power' => 2,
                    ],
                ],
                [
                    'id' => 3,
                    'name' => '视觉',
                    'pivot' => [
                        'user_id' => 1,
                        'group_id' => 3,
                        'power' => 2,
                    ],
                ],
                [
                    'id' => 4,
                    'name' => '宣传',
                    'pivot' => [
                        'user_id' => 1,
                        'group_id' => 4,
                        'power' => 2,
                    ],
                ],
                [
                    'id' => 5,
                    'name' => '运营',
                    'pivot' => [
                        'user_id' => 1,
                        'group_id' => 5,
                        'power' => 2,
                    ],
                ],
                [
                    'id' => 6,
                    'name' => '项目',
                    'pivot' => [
                        'user_id' => 1,
                        'group_id' => 6,
                        'power' => 2,
                    ],
                ],
                [
                    'id' => 7,
                    'name' => '信息',
                    'pivot' => [
                        'user_id' => 1,
                        'group_id' => 7,
                        'power' => 2,
                    ],
                ],
            ],
        ],
        [
            'id' => 2,
            'uuid' => '4ce32aff-e12e-4e9e-ba1d-1ba1f3dec134',
            'avatar' => 'https://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46',
            'name' => '汤姆',
            'email' => 'tom@example.com',
            'groups' => [
                [
                    'id' => 1,
                    'name' => '机械',
                    'pivot' => [
                        'user_id' => 2,
                        'group_id' => 1,
                        'power' => 2,
                    ],
                ],
                [
                    'id' => 2,
                    'name' => '电控',
                    'pivot' => [
                        'user_id' => 2,
                        'group_id' => 2,
                        'power' => 1,
                    ],
                ],
            ],
        ],
        [
            'id' => 3,
            'uuid' => 'cc00951f-c4ab-4d5a-8180-765042ae5647',
            'avatar' => 'https://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46',
            'name' => '杰瑞',
            'email' => 'jerry@example.com',
            'groups' => [
                [
                    'id' => 1,
                    'name' => '机械',
                    'pivot' => [
                        'user_id' => 3,
                        'group_id' => 1,
                        'power' => 1,
                    ],
                ],
            ],
        ],
    ]
];
