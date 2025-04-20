<!-- komponen untuk menampilkan lebih banyak rating di halaman detail kursus (roole peserta)-->

@foreach($rating as $rating)
    <div class="bg-white border border-gray-200 p-4 rounded-lg">
        <div class="flex items-center space-x-4">
            <img src="{{ $rating->user->profile_photo ? asset('storage/' . $rating->user->profile_photo) : asset('storage/default-profile.jpg') }}" 
                alt="User Profile" class="w-6 h-6 rounded-full object-cover">
            <div>
                <h4 class="text-sm font-semibold text-gray-700">{{ $rating->user->name }}</h4>
                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($rating->created_at)->format('d F Y') }}</span>
            </div>
        </div>
        <div class="flex items-center space-x-1 mt-2">
            @for ($i = 0; $i < 5; $i++)
                <span class="{{ $i < $rating->stars ? 'text-yellow-500' : 'text-gray-300' }}">&starf;</span>
            @endfor
        </div>
        <p class="text-gray-600 text-sm mt-2">{{ $rating->comment }}</p>
    </div>
@endforeach
