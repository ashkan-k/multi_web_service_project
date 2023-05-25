<?php

namespace Modules\Ticket\Tests;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class MainTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->Init();
    }

    //

    private function Init()
    {
        $this->super_user = User::create([
            'name' => 'اشکان کریمی',
            'email' => 'as@gmail.com',
            'password' => Hash::make('123'),
//            'phone_verified_at' => Carbon::now(),
            'is_admin' => true,
        ]);

        $this->simple_user = User::create([
            'name' => 'اشکان کریمی',
            'email' => 'wwwwwwww@gmail.com',
            'password' => Hash::make('123'),
//            'phone_verified_at' => Carbon::now(),
            'is_admin' => false,
        ]);
    }

    public function CreateFakeFile($path = 'avatar.png', $ext='png')
    {
        $stub = public_path($path);
        $name = Str::random(8) . '.' . $ext;
        $path = sys_get_temp_dir() . '/' . $name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, filesize($path), null, true);

        return $file;
    }
}
