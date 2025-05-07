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
        // Skip header
        if ($this->rowNumber === 1) {
            $this->rowNumber++;
            return null;
        }

        $this->rowNumber++;

        // Validasi kolom wajib
        if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
            // Skip baris yang tidak valid
            return null;
        }

        return new User([
            'name'              => $row[0],
            'email'             => $row[1],
            'password'          => Hash::make($row[2]),
            'phone_number'      => isset($row[3]) ? (str_starts_with($row[3], '0') ? $row[3] : '0' . $row[3]) : null,
            'role'              => 'student',
            'status'            => 'active',
            'email_verified_at' => now(),
            'photo'             => null,
            'experience'        => null,
        ]);
    }

}
