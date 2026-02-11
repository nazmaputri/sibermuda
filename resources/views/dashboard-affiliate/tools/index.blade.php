@extends('layouts.dashboard-affiliate')
@section('title', 'Marketing Tools')
@section('content')
    {{-- Header Section --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Marketing Tools</h1>
        <p class="text-gray-600 mt-1">Berbagai tools dan materi promosi untuk membantu Anda</p>
    </div>

    {{-- Link Generator --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Link Generator</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg p-5">
                {{-- Kode Referral --}}
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Kode Referral Anda:</label>
                    <div class="flex items-center bg-white border-2 border-gray-300 rounded-lg px-4 py-3">
                        <code id="affiliate-code" class="flex-1 text-lg font-mono font-bold text-gray-800">
                            {{ $affiliateCode }}
                        </code>
                        <button onclick="copyCode()" class="ml-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Salin
                        </button>
                    </div>
                </div>

                {{-- Link Umum --}}
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Link Referral Umum:</label>
                    <div class="flex items-center bg-white border-2 border-gray-300 rounded-lg px-4 py-3">
                        <code id="affiliate-link" class="flex-1 text-sm font-mono text-gray-700 truncate">
                            {{ $affiliateLink }}
                        </code>
                        <button onclick="copyLink('affiliate-link')" class="ml-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Salin
                        </button>
                    </div>
                </div>

                {{-- Link Custom untuk Kursus Tertentu --}}
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Generate Link untuk Kursus Tertentu:</label>
                    <div class="flex gap-2">
                        <input type="text" id="course-slug"
                            class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Masukkan slug kursus (contoh: web-development)">
                        <button onclick="generateCourseLink()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition">
                            Generate
                        </button>
                    </div>
                    <div id="course-link-result" class="mt-3 hidden">
                        <div class="flex items-center bg-white border-2 border-gray-300 rounded-lg px-4 py-3">
                            <code id="course-link" class="flex-1 text-sm font-mono text-gray-700 truncate"></code>
                            <button onclick="copyLink('course-link')" class="ml-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Salin
                            </button>
                        </div>
                    </div>
                </div>

                {{-- QR Code --}}
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">QR Code Link Referral:</label>
                    <div class="bg-white border-2 border-gray-300 rounded-lg p-4 flex items-center justify-center">
                        <div class="text-center">
                            <div class="bg-gray-100 p-4 rounded-lg inline-block">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($affiliateLink) }}"
                                     alt="QR Code"
                                     class="w-48 h-48">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Scan untuk akses link referral</p>
                            <button onclick="downloadQR()" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm">
                                Download QR Code
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Banner Promosi --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6 mb-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Banner Promosi</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($banners as $banner)
            <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition">
                <div class="mb-3">
                    <h3 class="font-semibold text-gray-800">{{ $banner->nama }}</h3>
                    <p class="text-sm text-gray-500">{{ $banner->kategori }} ({{ $banner->ukuran }})</p>
                </div>
                <div class="bg-gray-100 rounded-lg p-4 mb-3 flex items-center justify-center">
                    <img src="{{ $banner->image }}" alt="{{ $banner->nama }}" class="max-w-full h-auto">
                </div>
                <div class="flex gap-2">
                    <button onclick="downloadBanner('{{ $banner->image }}', '{{ $banner->nama }}')"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download
                    </button>
                    <button onclick="copyBannerCode('{{ $banner->image }}')"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition text-sm flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Copy HTML
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Template Social Media --}}
    <div class="bg-white shadow-md border border-gray-200 rounded-lg p-6">
        <div class="flex flex-col items-center mb-4">
            <h2 class="text-lg font-semibold inline-block pb-1 text-gray-700">Template Social Media</h2>
            <div class="border-b-2 w-full mt-1"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($templates as $template)
            <div class="border-2 border-gray-200 rounded-lg p-5 hover:border-blue-500 transition">
                <div class="flex items-center mb-3">
                    @if($template->platform == 'Instagram')
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </div>
                    @elseif($template->platform == 'Facebook')
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                    @elseif($template->platform == 'Twitter/X')
                        <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </div>
                    @else
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="ml-3">
                        <h3 class="font-semibold text-gray-800">{{ $template->judul }}</h3>
                        <p class="text-xs text-gray-500">{{ $template->platform }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-3">
                    <pre id="template-{{ $template->id }}" class="text-sm text-gray-700 whitespace-pre-wrap font-sans">{{ $template->konten }}</pre>
                </div>
                <button onclick="copyTemplate('template-{{ $template->id }}')"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copy Template
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        // Copy Kode Referral
        function copyCode() {
            const code = document.getElementById('affiliate-code').textContent.trim();
            navigator.clipboard.writeText(code).then(() => {
                showNotification('Kode referral berhasil disalin!');
            });
        }

        // Copy Link
        function copyLink(elementId) {
            const link = document.getElementById(elementId).textContent.trim();
            navigator.clipboard.writeText(link).then(() => {
                showNotification('Link berhasil disalin!');
            });
        }

        // Generate Course Link
        function generateCourseLink() {
            const courseSlug = document.getElementById('course-slug').value.trim();
            if (!courseSlug) {
                alert('Masukkan slug kursus terlebih dahulu');
                return;
            }

            const baseUrl = '{{ url("/kursus") }}';
            const refCode = '{{ $affiliateCode }}';
            const courseLink = `${baseUrl}/${courseSlug}?ref=${refCode}`;

            document.getElementById('course-link').textContent = courseLink;
            document.getElementById('course-link-result').classList.remove('hidden');
        }

        // Download QR Code
        function downloadQR() {
            const qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode($affiliateLink) }}';
            const link = document.createElement('a');
            link.href = qrUrl;
            link.download = 'qr-code-affiliate.png';
            link.click();
            showNotification('QR Code berhasil diunduh!');
        }

        // Download Banner
        function downloadBanner(imageUrl, bannerName) {
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = bannerName.replace(/\s+/g, '-').toLowerCase() + '.png';
            link.click();
            showNotification('Banner berhasil diunduh!');
        }

        // Copy Banner HTML Code
        function copyBannerCode(imageUrl) {
            const refLink = '{{ $affiliateLink }}';
            const htmlCode = `<a href="${refLink}" target="_blank">\n  <img src="${imageUrl}" alt="Banner Promosi" />\n</a>`;
            navigator.clipboard.writeText(htmlCode).then(() => {
                showNotification('HTML code banner berhasil disalin!');
            });
        }

        // Copy Template
        function copyTemplate(templateId) {
            const template = document.getElementById(templateId).textContent;
            navigator.clipboard.writeText(template).then(() => {
                showNotification('Template berhasil disalin!');
            });
        }

        // Show Notification
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
@endsection
