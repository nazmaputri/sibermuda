<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    private $rowNumber = 1;

    public function model(array $row)
    {
        // Skip baris pertama
        if ($this->rowNumber === 1) {
            $this->rowNumber++;
            return null;
        }

        $this->rowNumber++;

        return new User([
            'name'              => $row[0],
            'email'             => $row[1],
            'password'          => Hash::make($row[2]),
            'phone_number'      => $row[3],
            'role'              => 'student',
            'status'            => 'active',
            'email_verified_at' => now(),
            'photo'             => null,
            'experience'        => null,
        ]);
    }
}
