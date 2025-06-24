@extends('layouts.dashboard-superadmin')
@section('content')
    <!-- Cards Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 pt-1">
        <!-- Card Jumlah Mentor -->
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-red-500">
            <div class="p-2 bg-red-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Mentor</h2>
                <p class="text-md font-semibold text-red-500">{{ $jumlahMentor }} Mentor</p>
            </div>
        </div>
        <!-- Card Jumlah Peserta -->
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-yellow-500">
            <div class="p-2 bg-yellow-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Peserta</h2>
                <p class="text-md font-semibold text-yellow-500">{{ $jumlahPeserta }} Peserta</p>
            </div>
        </div>
         <!-- Card Jumlah Kursus -->
         <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-blue-500">
            <div class="p-2 bg-blue-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Kursus</h2>
                <p class="text-md font-semibold text-blue-500">{{ $jumlahKursus }} Kursus</p>
            </div>
        </div>
        <!-- Card Jumlah Peserta -->
        <div class="bg-white rounded-lg shadow-md p-5 flex items-center border border-gray-200 border-l-4 border-l-green-500">
            <div class="p-2 bg-green-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-md font-semibold text-gray-700">Jumlah Kategori</h2>
                <p class="text-md font-semibold text-green-500">{{ $jumlahKategori }} Kategori</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols gap-6 mt-10">
        <div class="bg-white border border-gray-200 shadow-md p-4 rounded-md">
            <p class="text-gray-700 text-md font-semibold mb-2">Log Aktivitas</p>
            <!-- Tabel log aktivitas -->
            <div class="overflow-x-auto overflow-hidden">
                <div class="min-w-full max-h-64 overflow-y-auto scrollbar-hide">
                    <table class="min-w-full border-separate border-spacing-0 text-sm" id="userTable">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600">
                                <th class="py-2 border-b border-l border-t border-gray-200 rounded-tl-lg">Nama</th>
                                <th class="py-2 border-b border-t border-gray-200">Waktu Login</th>
                                <th class="py-2 border-b border-t border-gray-200">IP Address</th>
                                <th class="py-2 border-b border-t border-gray-200">Status</th>
                                <th class="py-2 border-b border-t border-r border-gray-200 rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                @php
                                    $lastLogin = \Carbon\Carbon::parse($log->logged_in_at);
                                    $now = \Carbon\Carbon::now();
                                    $isOnline = is_null($log->logged_out_at);
                                @endphp
                                <tr class="bg-white hover:bg-gray-50 user-row">
                                    <td class="px-4 py-2 border-b border-l border-gray-200 text-gray-600 whitespace-nowrap">{{ $log->admin->name }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-gray-600 whitespace-nowrap">{{ $lastLogin->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-gray-600 whitespace-nowrap">{{ $log->ip_address }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-gray-600 whitespace-nowrap">
                                        @if ($isOnline)
                                            <div class="flex items-center gap-2">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                                </span>
                                                Online
                                            </div>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-gray-500"></span>
                                                </span>
                                                Ofline
                                            </div> (Logout {{ \Carbon\Carbon::parse($log->logged_out_at)->diffForHumans() }})
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center border-b border-r border-gray-200 text-gray-600">
                                        <button 
                                            onclick="openModal({{ $log->id }})"
                                            data-log='@json($log)'
                                            class="text-blue-500 hover:text-blue-400"
                                        >Lihat</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <!-- Modal Pop-up -->
                        <div id="logModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
                            <div id="modal-content" class="bg-white w-full mx-4 md:mx-0 max-w-sm md:max-w-xl rounded-xl shadow-lg p-6 relative transition-transform duration-300 scale-95 opacity-0">
                                <h2 class="text-md font-semibold text-gray-700 mb-1 text-center">Detail Login Admin</h2>
                                <div class="w-16 h-1 bg-gray-600 mx-auto mb-4 rounded"></div>
                                <div class="grid grid-cols-[max-content_1ch_auto] gap-x-2 text-sm text-gray-700">
                                    <div class="text-left font-medium">Nama</div>
                                    <div>:</div>
                                    <div id="modal-name"></div>

                                    <div class="text-left font-medium">Role</div>
                                    <div>:</div>
                                    <div id="modal-role"></div>

                                    <div class="text-left font-medium">IP Address</div>
                                    <div>:</div>
                                    <div id="modal-ip"></div>

                                    <div class="text-left font-medium">Waktu Login</div>
                                    <div>:</div>
                                    <div id="modal-time"></div>

                                    <!-- <div class="col-span-3"><hr class="my-2"></div> -->

                                    <div class="text-left font-medium">Sistem Operasi</div>
                                    <div>:</div>
                                    <div id="modal-os"></div>

                                    <div class="text-left font-medium">Browser</div>
                                    <div>:</div>
                                    <div id="modal-browser"></div>

                                    <div class="text-left font-medium">Perangkat</div>
                                    <div>:</div>
                                    <div id="modal-device"></div>

                                    <div class="text-left font-medium">User Agent</div>
                                    <div>:</div>
                                    <div id="modal-agent" class="text-xs break-words"></div>
                                </div>
                                <!-- button tutup modal -->
                                <button onclick="closeModal()" class="absolute top-7 right-4 text-gray-500 hover:text-gray-400 text-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 8.586L15.95 2.636a1 1 0 111.414 1.414L11.414 10l5.95 5.95a1 1 0 01-1.414 1.414L10 11.414l-5.95 5.95a1 1 0 01-1.414-1.414L8.586 10 2.636 4.05a1 1 0 011.414-1.414L10 8.586z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <script>
                            function parseUserAgent(ua) {
                                let os = 'Tidak diketahui';
                                let browser = 'Tidak diketahui';
                                let device = 'Desktop';

                                // Deteksi OS
                                if (/Windows NT 10/.test(ua)) os = 'Windows 10';
                                else if (/Windows NT 6.3/.test(ua)) os = 'Windows 8.1';
                                else if (/Windows NT 6.1/.test(ua)) os = 'Windows 7';
                                else if (/Mac OS X/.test(ua)) os = 'macOS';
                                else if (/Android/.test(ua)) os = 'Android';
                                else if (/iPhone/.test(ua)) os = 'iOS';

                                // Deteksi Browser
                                if (/Chrome\/([0-9.]+)/.test(ua)) browser = 'Chrome ' + ua.match(/Chrome\/([0-9.]+)/)[1];
                                else if (/Firefox\/([0-9.]+)/.test(ua)) browser = 'Firefox ' + ua.match(/Firefox\/([0-9.]+)/)[1];
                                else if (/Safari\/([0-9.]+)/.test(ua)) browser = 'Safari';
                                else if (/Edg\/([0-9.]+)/.test(ua)) browser = 'Edge ' + ua.match(/Edg\/([0-9.]+)/)[1];

                                // Deteksi device
                                if (/Mobile|Android|iPhone/.test(ua)) device = 'Mobile';

                                return { os, browser, device };
                            }

                            function openModal(logId) {
                                const button = document.querySelector(`button[onclick="openModal(${logId})"]`);
                                const logData = JSON.parse(button.getAttribute('data-log'));
                                const parsedUA = parseUserAgent(logData.user_agent);

                                // Isi konten
                                document.getElementById('modal-name').textContent = logData.admin.name;
                                document.getElementById('modal-role').textContent = logData.role;
                                document.getElementById('modal-ip').textContent = logData.ip_address;
                                document.getElementById('modal-time').textContent = new Date(logData.logged_in_at).toLocaleString();
                                document.getElementById('modal-os').textContent = parsedUA.os;
                                document.getElementById('modal-browser').textContent = parsedUA.browser;
                                document.getElementById('modal-device').textContent = parsedUA.device;
                                document.getElementById('modal-agent').textContent = logData.user_agent;

                                const modal = document.getElementById('logModal');
                                const content = document.getElementById('modal-content');

                                modal.classList.remove('hidden');
                                modal.classList.add('flex');

                                // Tambah animasi masuk
                                setTimeout(() => {
                                    content.classList.remove('scale-95', 'opacity-0');
                                    content.classList.add('scale-100', 'opacity-100');
                                }, 10); // kasih sedikit delay agar transisinya terasa
                            }

                            function closeModal() {
                                const modal = document.getElementById('logModal');
                                const content = document.getElementById('modal-content');

                                // Tambah animasi keluar
                                content.classList.remove('scale-100', 'opacity-100');
                                content.classList.add('scale-95', 'opacity-0');

                                // Tunggu selesai transisi lalu sembunyikan
                                setTimeout(() => {
                                    modal.classList.add('hidden');
                                    modal.classList.remove('flex');
                                }, 300); // sama seperti duration-300 di Tailwind
                            }
                        </script>
                </div>
            </div>
        </div>

    </div>

    <!-- Grafik Perkembangan Pengguna Bulanan -->
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 mb-6 mt-10">
        <div class="flex flex-col items-center mb-4">
            <div class="flex items-center space-x-4">
                <h2 class="text-md font-semibold inline-block pb-1 text-gray-700">
                    Statistik Pengguna
                </h2>
                <div x-data="{ open: false, selected: '{{ $year }}' }" class="relative w-20">
                    <button @click="open = !open" class="w-full px-2 py-1 leading-tight border rounded-md bg-white flex justify-between items-center focus:outline-none focus:ring-1 focus:ring-sky-200">
                        <span x-text="selected" class="text-gray-700 text-sm"></span>
                        <svg class="w-4 h-4 ml-2 transform transition-transform duration-300 ease-in-out" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" class="absolute mt-1 w-full bg-white border rounded-md shadow-lg z-10 max-h-24 overflow-y-auto">
                        @foreach ($years as $availableYear)
                            <a 
                                href="?year={{ $availableYear }}"
                                @click="selected = '{{ $availableYear }}'; open = false"
                                class="block px-4 py-2 text-sm text-gray-700 text-center hover:bg-sky-100 {{ $availableYear == $year ? 'bg-sky-50 font-semibold' : '' }}"
                            >
                                {{ $availableYear }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Wrapper responsif: selalu punya height! -->
        <div class="relative w-full h-64 sm:h-80 md:h-80 lg:h-80">
          <canvas id="userGrowthChart" class="absolute inset-0 w-full h-full"></canvas>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('userGrowthChart').getContext('2d');

    const userGrowthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthNames) !!},
            datasets: [
                {
                    label: 'Mentor',
                    data: {!! json_encode($mentorGrowthData) !!},
                    borderColor: '#0ea5e9', // sky-500
                    backgroundColor: 'rgba(14,165,233,0.1)',
                    borderWidth: 2, // <= lebih tipis (default biasanya 3)
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 5,
                },
                {
                    label: 'Peserta',
                    data: {!! json_encode($pesertaGrowthData) !!},
                    borderColor: '#10b981', // emerald-500
                    borderWidth: 2, // <= lebih tipis (default biasanya 3)
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 5,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
   
@endsection