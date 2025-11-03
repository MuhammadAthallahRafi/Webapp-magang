@extends('layouts.pelamar')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Edit Formulir Pendaftaran Magang</h2>

    {{-- ✅ Error umum --}}
    @if (session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('form-pendaftaran.update', $pelamar->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            {{-- Nama --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" 
                       name="nama" 
                       value="{{ old('nama', $pelamar->nama) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                       required>
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                <select name="kelamin" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                        required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('kelamin', $pelamar->kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('kelamin', $pelamar->kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            {{-- NIK --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">NIK</label>
                <input 
                    type="text" 
                    name="nik" 
                    id="nik"
                    value="{{ old('nik', $pelamar->nik) }}" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors"
                    maxlength="16"
                    required
                >

                <div id="nik-error" class="text-red-500 text-sm mt-1 hidden"></div>
                <div id="nik-success" class="text-green-500 text-sm mt-1 hidden"></div>

                @error('nik')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Instansi Pendidikan --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">Instansi Pendidikan (Kampus atau SMK/SMA)</label>
                <input type="text" 
                       name="kampus" 
                       value="{{ old('kampus', $pelamar->kampus) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                       required>
            </div>

            {{-- Jurusan --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">Jurusan</label>
                <input type="text" 
                       name="jurusan" 
                       value="{{ old('jurusan', $pelamar->jurusan) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                       required>
            </div>

            {{-- No Telepon --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">No Telepon</label>
                <input type="text" 
                       name="no_telp" 
                       value="{{ old('no_telp', $pelamar->no_telp) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                       required>
            </div>

            {{-- Email --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">Email</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email', $pelamar->email) }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                       required>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">Alamat</label>
                <textarea name="alamat" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                          required>{{ old('alamat', $pelamar->alamat) }}</textarea>
            </div>

            {{-- Tanggal Mulai & Selesai --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Tanggal Mulai --}}
                <div>
                    <label for="tanggal_mulai" class="block font-medium text-gray-700 mb-2">Tanggal Mulai Magang *</label>
                    <input type="date" 
                           name="tanggal_mulai" 
                           id="tanggal_mulai"
                           value="{{ old('tanggal_mulai', $pelamar->tanggal_mulai ?? '') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors tanggal-input"
                           required>

                    <div id="tanggal_mulai-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    <div id="tanggal_mulai-success" class="text-green-500 text-sm mt-1 hidden"></div>

                    @error('tanggal_mulai')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tanggal Selesai --}}
                <div>
                    <label for="tanggal_selesai" class="block font-medium text-gray-700 mb-2">Tanggal Selesai Magang *</label>
                    <input type="date" 
                           name="tanggal_selesai" 
                           id="tanggal_selesai"
                           value="{{ old('tanggal_selesai', $pelamar->tanggal_selesai ?? '') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors tanggal-input"
                           required>

                    <div id="tanggal_selesai-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    <div id="tanggal_selesai-success" class="text-green-500 text-sm mt-1 hidden"></div>

                    @error('tanggal_selesai')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Info Durasi Magang --}}
            <div id="durasi-info" class="p-3 bg-blue-50 border border-blue-200 rounded-lg hidden">
                <p class="text-blue-700 text-sm">
                    <strong>Info Durasi Magang:</strong>
                    <span id="durasi-text"></span>
                </p>
            </div>

            {{-- Upload Files --}}
            <div class="space-y-4">
                {{-- Upload CV --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Upload CV (PDF)</label>
                    <input type="file" 
                           name="cv" 
                           id="cv"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors file-input" 
                           accept="application/pdf">
                    
                    <div id="cv-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    <div id="cv-success" class="text-green-500 text-sm mt-1 hidden"></div>

                    @if($pelamar->cv)
                        <p class="text-xs mt-1 text-gray-600">
                            File sekarang: 
                            <a href="{{ Storage::url($pelamar->cv) }}" target="_blank" class="text-blue-600 underline">Lihat CV</a>
                        </p>
                    @endif
                </div>

                {{-- Upload Transkrip --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Upload Transkrip (PDF)</label>
                    <input type="file" 
                           name="transkrip" 
                           id="transkrip"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors file-input" 
                           accept="application/pdf">
                    
                    <div id="transkrip-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    <div id="transkrip-success" class="text-green-500 text-sm mt-1 hidden"></div>

                    @if($pelamar->transkrip)
                        <p class="text-xs mt-1 text-gray-600">
                            File sekarang: 
                            <a href="{{ Storage::url($pelamar->transkrip) }}" target="_blank" class="text-blue-600 underline">Lihat Transkrip</a>
                        </p>
                    @endif
                </div>

                {{-- Upload Surat --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Upload Surat Pengantar (PDF)</label>
                    <input type="file" 
                           name="surat" 
                           id="surat"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors file-input" 
                           accept="application/pdf">
                    
                    <div id="surat-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    <div id="surat-success" class="text-green-500 text-sm mt-1 hidden"></div>

                    @if($pelamar->surat)
                        <p class="text-xs mt-1 text-gray-600">
                            File sekarang: 
                            <a href="{{ Storage::url($pelamar->surat) }}" target="_blank" class="text-blue-600 underline">Lihat Surat</a>
                        </p>
                    @endif
                </div>
            </div>

            {{-- Submit & Back Buttons --}}
            <div class="flex items-center justify-between pt-4 border-t">
                <button type="submit" 
                        id="submit-btn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 font-semibold">
                    Simpan Perubahan
                </button>

                <a href="{{ route('pelamar.center') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-lg transition duration-200">
                   ← Kembali
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const nikField = document.getElementById('nik');
    const tanggalMulaiField = document.getElementById('tanggal_mulai');
    const tanggalSelesaiField = document.getElementById('tanggal_selesai');
    const submitBtn = document.getElementById('submit-btn');
    const durasiInfo = document.getElementById('durasi-info');
    const durasiText = document.getElementById('durasi-text');
    
    // Validation state
    let isFormValid = false;

    // Initialize validation
    validateNIK();
    validateTanggal();
    updateSubmitButton();

    // NIK Validation
    nikField.addEventListener('input', validateNIK);

    function validateNIK() {
        const nikError = document.getElementById('nik-error');
        const nikSuccess = document.getElementById('nik-success');
        const value = nikField.value.trim();

        nikError.classList.add('hidden');
        nikSuccess.classList.add('hidden');
        nikField.classList.remove('border-red-500', 'border-green-500');

        if (!value) {
            showError(nikField, nikError, 'NIK harus diisi');
        } else if (!/^\d{16}$/.test(value)) {
            showError(nikField, nikError, 'NIK harus 16 digit angka');
        } else {
            showSuccess(nikField, nikSuccess, '✅ NIK valid');
        }
        
        updateFormValidity();
    }

    // Date Validation
    tanggalMulaiField.addEventListener('change', validateTanggal);
    tanggalSelesaiField.addEventListener('change', validateTanggal);

    function validateTanggal() {
        const startDate = new Date(tanggalMulaiField.value);
        const endDate = new Date(tanggalSelesaiField.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Reset all date messages
        resetDateValidation();

        let hasError = false;

        // Validate start date
        if (!tanggalMulaiField.value) {
            showDateError('tanggal_mulai', 'Tanggal mulai harus diisi');
            hasError = true;
        } else if (startDate <= today) {
            showDateError('tanggal_mulai', 'Tanggal mulai harus SETELAH hari ini');
            hasError = true;
        } else {
            showDateSuccess('tanggal_mulai', '✅ Tanggal mulai valid');
        }

        // Validate end date
        if (!tanggalSelesaiField.value) {
            showDateError('tanggal_selesai', 'Tanggal selesai harus diisi');
            hasError = true;
        } else if (tanggalMulaiField.value && endDate <= startDate) {
            showDateError('tanggal_selesai', 'Tanggal selesai harus SETELAH tanggal mulai');
            hasError = true;
        } else if (tanggalMulaiField.value) {
            // Calculate duration
            const diffTime = endDate - startDate;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            const diffMonths = Math.floor(diffDays / 30);
            
            if (diffMonths > 3) {
                showDateError('tanggal_selesai', 'Durasi magang maksimal 3 bulan');
                hasError = true;
            } else {
                showDateSuccess('tanggal_selesai', '✅ Tanggal selesai valid');
                showDurasiInfo(diffDays, diffMonths);
            }
        }

        if (!hasError && tanggalMulaiField.value && tanggalSelesaiField.value) {
            updateFormValidity();
        }
    }

    function resetDateValidation() {
        ['tanggal_mulai', 'tanggal_selesai'].forEach(field => {
            const errorEl = document.getElementById(`${field}-error`);
            const successEl = document.getElementById(`${field}-success`);
            const inputEl = document.getElementById(field);

            errorEl.classList.add('hidden');
            successEl.classList.add('hidden');
            inputEl.classList.remove('border-red-500', 'border-green-500');
        });
        durasiInfo.classList.add('hidden');
    }

    function showDateError(field, message) {
        const errorEl = document.getElementById(`${field}-error`);
        const inputEl = document.getElementById(field);
        showError(inputEl, errorEl, message);
    }

    function showDateSuccess(field, message) {
        const successEl = document.getElementById(`${field}-success`);
        const inputEl = document.getElementById(field);
        showSuccess(inputEl, successEl, message);
    }

    function showDurasiInfo(days, months) {
        durasiText.textContent = `Durasi magang: ${days} hari (${months} bulan)`;
        durasiInfo.classList.remove('hidden');
    }

    // File Validation
    document.querySelectorAll('.file-input').forEach(input => {
        input.addEventListener('change', function() {
            validateFile(this);
        });
    });

    function validateFile(fileInput) {
        const fieldName = fileInput.name;
        const errorEl = document.getElementById(`${fieldName}-error`);
        const successEl = document.getElementById(`${fieldName}-success`);

        errorEl.classList.add('hidden');
        successEl.classList.add('hidden');
        fileInput.classList.remove('border-red-500', 'border-green-500');

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileSize = file.size / 1024 / 1024; // MB
            const fileType = file.type;
            
            if (fileType !== 'application/pdf') {
                showError(fileInput, errorEl, 'File harus berupa PDF');
            } else if (fileSize > 2) {
                showError(fileInput, errorEl, 'Ukuran file maksimal 2MB');
            } else {
                showSuccess(fileInput, successEl, '✅ File valid');
            }
        }
    }

    // Helper functions
    function showError(input, errorEl, message) {
        errorEl.textContent = message;
        errorEl.classList.remove('hidden');
        input.classList.add('border-red-500');
        input.classList.remove('border-green-500');
    }

    function showSuccess(input, successEl, message) {
        successEl.textContent = message;
        successEl.classList.remove('hidden');
        input.classList.add('border-green-500');
        input.classList.remove('border-red-500');
    }

    function updateFormValidity() {
        const nikValid = nikField.value.length === 16 && /^\d+$/.test(nikField.value);
        const tanggalMulaiValid = tanggalMulaiField.value && new Date(tanggalMulaiField.value) > new Date();
        const tanggalSelesaiValid = tanggalSelesaiField.value && 
                                   new Date(tanggalSelesaiField.value) > new Date(tanggalMulaiField.value);

        // Check if duration is within 3 months
        let durationValid = true;
        if (tanggalMulaiValid && tanggalSelesaiValid) {
            const startDate = new Date(tanggalMulaiField.value);
            const endDate = new Date(tanggalSelesaiField.value);
            const diffTime = endDate - startDate;
            const diffMonths = Math.floor(diffTime / (1000 * 60 * 60 * 24 * 30));
            durationValid = diffMonths <= 3;
        }

        isFormValid = nikValid && tanggalMulaiValid && tanggalSelesaiValid && durationValid;
        updateSubmitButton();
    }

    function updateSubmitButton() {
        if (isFormValid) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-blue-300', 'cursor-not-allowed');
            submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            submitBtn.textContent = 'Simpan Perubahan';
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            submitBtn.classList.add('bg-blue-300', 'cursor-not-allowed');
            submitBtn.textContent = 'Perbaiki Data Terlebih Dahulu';
        }
    }

    // Form submission
    document.getElementById('editForm').addEventListener('submit', function(e) {
        validateNIK();
        validateTanggal();
        
        if (!isFormValid) {
            e.preventDefault();
            alert('Harap perbaiki error pada form sebelum menyimpan perubahan!');
            
            // Scroll to first error
            const firstError = document.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
});
</script>
@endpush