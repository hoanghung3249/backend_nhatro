<?php

return [
    'motel.motels' => [
        'index' => 'motel::motels.list resource',
        'create' => 'motel::motels.create resource',
        'edit' => 'motel::motels.edit resource',
        'destroy' => 'motel::motels.destroy resource',
    ],
// append
    'room.room' => [
        'index' => 'Danh sách phòng',
        'create' => 'Tạo phòng',
        'edit' => 'Chỉnh sửa phòng',
        'destroy' => 'Xoá phòng',
    ],
];
