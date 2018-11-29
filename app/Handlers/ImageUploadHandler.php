<?php

namespace App\Handlers;

class ImageUploadHandler
{
    protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

    public function save($file, $folder, $max_width = false)
    {
        // 构建存储的文件夹规则，uploads/images/avatars/201709/21/
        $folder_name = "uploads/images/$folder/" . date('Ym', time()) . '/' . date('d', time()). '/';
        // 文件具体存储的物理路径
        $upload_path = public_path() . '/' . $folder_name;
        // 获取文件的后缀名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        // 拼接文件名称
        $filename = time() . '_' . str_random(10) . '.' . $extension;
        // 如果上传的不是图片将终止操作
        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }
        // 将图片移动到我们的目标存储路径中
        $file->move($upload_path, $filename);

        return [
            'path' => $folder_name.$filename
        ];
    }
}
