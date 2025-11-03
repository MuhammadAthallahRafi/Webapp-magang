<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Magang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-600">Formulir Pendaftaran Magang</h2>

        {{-- ✅ Error umum --}}
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('form.pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
              x-data="pendaftaranForm()" @submit="validateForm">
            @csrf

            <div class="space-y-4">
                <!-- Nama -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Nama</label>
                    <input type="text" name="nama" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                           value="{{ old('nama', auth()->user()->name) }}" 
                           required>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <select name="kelamin" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                            required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- NIK -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" 
                           name="nik" 
                           id="nik"
                           x-model="nik"
                           @input="validateNIK()"
                           :class="{
                               'border-red-500': errors.nik,
                               'border-green-500': isValid.nik,
                               'border-gray-300': !errors.nik && !isValid.nik
                           }"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors"
                           value="{{ old('nik') }}" 
                           maxlength="16" 
                           required
                           placeholder="Masukkan 16 digit angka NIK">

                    <template x-if="errors.nik">
                        <p class="text-red-500 text-sm mt-1" x-text="errors.nik"></p>
                    </template>
                    
                    <template x-if="isValid.nik">
                        <p class="text-green-500 text-sm mt-1" x-text="isValid.nik"></p>
                    </template>

                    @error('nik')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Instansi Pendidikan -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Instansi Pendidikan</label>
                    <input type="text" 
                           name="kampus" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                           value="{{ old('kampus') }}" 
                           required>
                </div>

                <!-- Jurusan -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Jurusan</label>
                    <input type="text" 
                           name="jurusan" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                           value="{{ old('jurusan') }}" 
                           required>
                </div>

                <!-- No Telepon -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">No Telepon</label>
                    <input type="text" 
                           name="no_telp" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                           value="{{ old('no_telp', auth()->user()->no_telp ?? '') }}" 
                           required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                           value="{{ old('email', auth()->user()->email ?? '') }}" 
                           required>
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" 
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                              required>{{ old('alamat') }}</textarea>
                </div>

                <!-- Tanggal Mulai & Selesai -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="block font-medium text-gray-700 mb-2">Tanggal Mulai Magang *</label>
                        <input type="date" 
                               name="tanggal_mulai" 
                               id="tanggal_mulai"
                               x-model="tanggalMulai"
                               @change="validateTanggal()"
                               :class="{
                                   'border-red-500': errors.tanggalMulai,
                                   'border-green-500': isValid.tanggalMulai,
                                   'border-gray-300': !errors.tanggalMulai && !isValid.tanggalMulai
                               }"
                               class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                               value="{{ old('tanggal_mulai') }}" 
                               required>

                        <template x-if="errors.tanggalMulai">
                            <p class="text-red-500 text-sm mt-1" x-text="errors.tanggalMulai"></p>
                        </template>
                        
                        <template x-if="isValid.tanggalMulai">
                            <p class="text-green-500 text-sm mt-1" x-text="isValid.tanggalMulai"></p>
                        </template>

                        @error('tanggal_mulai')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="tanggal_selesai" class="block font-medium text-gray-700 mb-2">Tanggal Selesai Magang *</label>
                        <input type="date" 
                               name="tanggal_selesai" 
                               id="tanggal_selesai"
                               x-model="tanggalSelesai"
                               @change="validateTanggal()"
                               :class="{
                                   'border-red-500': errors.tanggalSelesai,
                                   'border-green-500': isValid.tanggalSelesai,
                                   'border-gray-300': !errors.tanggalSelesai && !isValid.tanggalSelesai
                               }"
                               class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                               value="{{ old('tanggal_selesai') }}" 
                               required>

                        <template x-if="errors.tanggalSelesai">
                            <p class="text-red-500 text-sm mt-1" x-text="errors.tanggalSelesai"></p>
                        </template>
                        
                        <template x-if="isValid.tanggalSelesai">
                            <p class="text-green-500 text-sm mt-1" x-text="isValid.tanggalSelesai"></p>
                        </template>

                        @error('tanggal_selesai')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Info Durasi Magang -->
                <div x-show="showDurasiInfo" x-transition
                     class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-blue-700 text-sm">
                        <strong>Info Durasi Magang:</strong>
                        <span x-text="durasiInfo"></span>
                    </p>
                </div>

                <!-- Upload Files -->
                <div class="space-y-4">
                    <!-- CV -->
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Upload CV (PDF)</label>
                        <input type="file" 
                               name="cv" 
                               @change="validateFile($el, 'cv')"
                               :class="{
                                   'border-red-500': errors.cv,
                                   'border-green-500': isValid.cv,
                                   'border-gray-300': !errors.cv && !isValid.cv
                               }"
                               class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                               accept="application/pdf" 
                               required>
                        
                        <template x-if="errors.cv">
                            <p class="text-red-500 text-sm mt-1" x-text="errors.cv"></p>
                        </template>
                        
                        <template x-if="isValid.cv">
                            <p class="text-green-500 text-sm mt-1" x-text="isValid.cv"></p>
                        </template>

                        @error('cv')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Transkrip -->
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Upload Transkrip (PDF)</label>
                        <input type="file" 
                               name="transkrip" 
                               @change="validateFile($el, 'transkrip')"
                               :class="{
                                   'border-red-500': errors.transkrip,
                                   'border-green-500': isValid.transkrip,
                                   'border-gray-300': !errors.transkrip && !isValid.transkrip
                               }"
                               class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                               accept="application/pdf" 
                               required>
                        
                        <template x-if="errors.transkrip">
                            <p class="text-red-500 text-sm mt-1" x-text="errors.transkrip"></p>
                        </template>
                        
                        <template x-if="isValid.transkrip">
                            <p class="text-green-500 text-sm mt-1" x-text="isValid.transkrip"></p>
                        </template>

                        @error('transkrip')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Surat Pengantar -->
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">Upload Surat Pengantar (PDF)</label>
                        <input type="file" 
                               name="surat" 
                               @change="validateFile($el, 'surat')"
                               :class="{
                                   'border-red-500': errors.surat,
                                   'border-green-500': isValid.surat,
                                   'border-gray-300': !errors.surat && !isValid.surat
                               }"
                               class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors" 
                               accept="application/pdf" 
                               required>
                        
                        <template x-if="errors.surat">
                            <p class="text-red-500 text-sm mt-1" x-text="errors.surat"></p>
                        </template>
                        
                        <template x-if="isValid.surat">
                            <p class="text-green-500 text-sm mt-1" x-text="isValid.surat"></p>
                        </template>

                        @error('surat')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        :disabled="!formValid"
                        :class="{
                            'bg-blue-600 hover:bg-blue-700': formValid,
                            'bg-blue-300 cursor-not-allowed': !formValid
                        }"
                        class="w-full text-white px-4 py-3 rounded-lg transition duration-200 font-semibold text-lg">
                    <span x-text="formValid ? 'Kirim Pendaftaran' : 'Lengkapi Form Terlebih Dahulu'"></span>
                </button>
            </div>
        </form>
    </div>

    <script>
    function pendaftaranForm() {
        return {
            nik: '{{ old('nik') }}',
            tanggalMulai: '{{ old('tanggal_mulai') }}',
            tanggalSelesai: '{{ old('tanggal_selesai') }}',
            errors: {
                nik: '',
                tanggalMulai: '',
                tanggalSelesai: '',
                cv: '',
                transkrip: '',
                surat: ''
            },
            isValid: {
                nik: '',
                tanggalMulai: '',
                tanggalSelesai: '',
                cv: '',
                transkrip: '',
                surat: ''
            },
            showDurasiInfo: false,
            durasiInfo: '',
            formValid: false,

            init() {
                // Validasi awal jika ada nilai old
                if (this.nik) this.validateNIK();
                if (this.tanggalMulai || this.tanggalSelesai) this.validateTanggal();
            },

            validateNIK() {
                this.errors.nik = '';
                this.isValid.nik = '';

                if (!this.nik) {
                    this.errors.nik = 'NIK harus diisi';
                } else if (!/^\d{16}$/.test(this.nik)) {
                    this.errors.nik = 'NIK harus 16 digit angka';
                } else {
                    this.isValid.nik = '✅ NIK valid';
                }
                
                this.checkFormValidity();
            },

            validateTanggal() {
                const startDate = new Date(this.tanggalMulai);
                const endDate = new Date(this.tanggalSelesai);
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Reset waktu untuk perbandingan tanggal saja

                // Reset messages
                this.errors.tanggalMulai = '';
                this.errors.tanggalSelesai = '';
                this.isValid.tanggalMulai = '';
                this.isValid.tanggalSelesai = '';
                this.showDurasiInfo = false;

                // Validasi Tanggal Mulai
                if (!this.tanggalMulai) {
                    this.errors.tanggalMulai = 'Tanggal mulai harus diisi';
                } else if (startDate <= today) {
                    this.errors.tanggalMulai = 'Tanggal mulai harus SETELAH hari ini';
                } else {
                    this.isValid.tanggalMulai = '✅ Tanggal mulai valid';
                }

                // Validasi Tanggal Selesai
                if (!this.tanggalSelesai) {
                    this.errors.tanggalSelesai = 'Tanggal selesai harus diisi';
                } else if (this.tanggalMulai && endDate <= startDate) {
                    this.errors.tanggalSelesai = 'Tanggal selesai harus SETELAH tanggal mulai';
                } else if (this.tanggalMulai) {
                    // Hitung durasi dalam bulan
                    const diffTime = endDate - startDate;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    const diffMonths = Math.floor(diffDays / 30);
                    
                    if (diffMonths > 3) {
                        this.errors.tanggalSelesai = 'Durasi magang maksimal 3 bulan';
                    } else {
                        this.isValid.tanggalSelesai = '✅ Tanggal selesai valid';
                        this.showDurasiInfo = true;
                        this.durasiInfo = `Durasi magang: ${diffDays} hari (${diffMonths} bulan)`;
                    }
                }

                this.checkFormValidity();
            },

            validateFile(fileInput, fieldName) {
                this.errors[fieldName] = '';
                this.isValid[fieldName] = '';

                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const fileSize = file.size / 1024 / 1024; // MB
                    const fileType = file.type;
                    
                    if (fileType !== 'application/pdf') {
                        this.errors[fieldName] = 'File harus berupa PDF';
                    } else if (fileSize > 2) {
                        this.errors[fieldName] = 'Ukuran file maksimal 2MB';
                    } else {
                        this.isValid[fieldName] = '✅ File valid';
                    }
                } else {
                    this.errors[fieldName] = 'File harus diupload';
                }
                
                this.checkFormValidity();
            },

            checkFormValidity() {
                this.formValid = 
                    !this.errors.nik && 
                    !this.errors.tanggalMulai && 
                    !this.errors.tanggalSelesai && 
                    !this.errors.cv && 
                    !this.errors.transkrip && 
                    !this.errors.surat &&
                    this.nik.length === 16 &&
                    this.tanggalMulai !== '' &&
                    this.tanggalSelesai !== '';
            },

            validateForm(e) {
                this.validateNIK();
                this.validateTanggal();
                
                if (!this.formValid) {
                    e.preventDefault();
                    // Scroll ke error pertama
                    const firstError = document.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                    
                    // Tampilkan alert
                    alert('Harap perbaiki error pada form sebelum mengirim!');
                }
            }
        }
    }
    </script>
</body>
</html>