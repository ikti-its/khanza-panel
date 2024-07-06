<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                Profile
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Manage your name, password and account settings.
            </p>
        </div>

        <form action="/submiteditpegawai/<?= $pegawaiId ?>" method="post">
            <!-- Grid -->


            <div class="sm:col-span-3">
                <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    ID Akun
                </label>
            </div>

            <!-- End Col -->

            <div class="sm:col-span-9">
                <input id="af-id-akun" name="id_akun" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="36 characters uuid" value="<?= $pegawaiData['id_akun'] ?? '' ?>">
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <label for="af-pegawai-nip" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    NIP
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-nip" name="nip" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your nip" value="<?= $pegawaiData['nip'] ?? '' ?>">
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <label for="af-pegawai-nama" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Nama
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-nama" name="nama" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your name" value="<?= $pegawaiData['nama'] ?? '' ?>">
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <div class="inline-block">
                    <label for="af-pegawai-kelamin" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Jenis Kelamin
                    </label>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="sm:flex">
                    <select name="jenis_kelamin" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <option value="L" <?= ($pegawaiData['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>(L) Laki-laki</option>
                        <option value="P" <?= ($pegawaiData['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>(P) Perempuan</option>
                    </select>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <div class="inline-block">
                    <label for="af-pegawai-jabatan" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Jabatan
                    </label>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="sm:flex">
                    <select name="jabatan" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <option value="1000" <?= ($pegawaiData['jabatan']) === '1000' ? 'selected' : '' ?>>1000 Testing</option>
                        <option value="1" <?= ($pegawaiData['jabatan']) === '1' ? 'selected' : '' ?>>1 Direktur</option>
                        <option value="2" <?= ($pegawaiData['jabatan']) === '2' ? 'selected' : '' ?>>2 Manager</option>
                        <option value="3" <?= ($pegawaiData['jabatan']) === '3' ? 'selected' : '' ?>>3 Supervisor</option>
                        <option value="4" <?= ($pegawaiData['jabatan']) === '4' ? 'selected' : '' ?>>4 Staff</option>
                    </select>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <div class="inline-block">
                    <label for="af-pegawai-departemen" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Departemen
                    </label>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="sm:flex">
                    <select name="departemen" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <option value="1000" <?= ($pegawaiData['departemen']) === '1000' ? 'selected' : '' ?>>1000 Testing</option>
                        <option value="1" <?= ($pegawaiData['departemen']) === '1' ? 'selected' : '' ?>>1 HRD</option>
                        <option value="2" <?= ($pegawaiData['departemen']) === '2' ? 'selected' : '' ?>>2 Marketing</option>
                        <option value="3" <?= ($pegawaiData['departemen']) === '3' ? 'selected' : '' ?>>3 Keuangan</option>
                        <option value="4" <?= ($pegawaiData['departemen']) === '4' ? 'selected' : '' ?>>4 Operasional</option>
                    </select>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <div class="inline-block">
                    <label for="af-pegawai-status" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Status Aktif
                    </label>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="sm:flex">
                    <select name="status_aktif" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <option value="A" <?= ($pegawaiData['status_aktif']) === 'A' ? 'selected' : '' ?>>(A) Aktif</option>
                        <option value="BH" <?= ($pegawaiData['status_aktif']) === 'BH' ? 'selected' : '' ?>>(BH) Berhenti dengan Hormat</option>
                        <option value="C" <?= ($pegawaiData['status_aktif']) === 'C' ? 'selected' : '' ?>>(C) Cuti</option>
                        <option value="R" <?= ($pegawaiData['status_aktif']) === 'R' ? 'selected' : '' ?>>(R) Resign</option>
                        <option value="BT" <?= ($pegawaiData['status_aktif']) === 'BT' ? 'selected' : '' ?>>(BH) Berhenti dengan Tidak Hormat</option>
                    </select>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <div class="inline-block">
                    <label for="af-pegawai-jenis" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Jenis Pegawai
                    </label>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="sm:flex">
                    <select name="jenis_pegawai" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <option value="Tetap" <?= ($pegawaiData['jenis_pegawai']) === 'Tetap' ? 'selected' : '' ?>>Tetap</option>
                        <option value="Kontrak" <?= ($pegawaiData['jenis_pegawai']) === 'Kontrak' ? 'selected' : '' ?>>Kontrak</option>
                        <option value="Magang" <?= ($pegawaiData['jenis_pegawai']) === 'Magang' ? 'selected' : '' ?>>Magang</option>
                        <option value="Istimewa" <?= ($pegawaiData['jenis_pegawai']) === 'Istimewa' ? 'selected' : '' ?>>Istimewa</option>
                    </select>
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <label for="af-pegawai-departemen" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Telepon
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-departemen" name="telepon" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your telepon" value="<?= $pegawaiData['telepon'] ?? '' ?>">
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <label for="af-tanggal-masuk" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Tanggal Masuk
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <!-- Input field to display the selected date -->
                    <input id="selected-date" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Selected Date" readonly value="<?= $pegawaiData['tanggal_masuk'] ?>">
                    <!-- Hidden input field to store the original date value -->
                    <input id="original-tanggal-masuk" type="hidden" value="<?= $pegawaiData['tanggal_masuk'] ?>">
                    <!-- Hidden input field to store the updated date value -->
                    <input id="tanggal-masuk" name="tanggal_masuk" type="hidden" value="<?= $pegawaiData['tanggal_masuk'] ?>">
                </div>
            </div>
            <!-- End Col -->

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Initialize Flatpickr
                    flatpickr('#selected-date', {
                        altInput: true, // Enable to use an alternative input field
                        altFormat: 'Y-m-d', // Format of the alternative input field
                        dateFormat: 'Y-m-d', // Date format

                        onChange: function(selectedDates, dateStr, instance) {
                            // Get the original date value
                            var originalDate = document.getElementById('original-tanggal-masuk').value;
                            // Check if the selected date is different from the original date
                            if (dateStr !== originalDate) {
                                // Update the hidden input field with the selected date value
                                document.getElementById('tanggal-masuk').value = dateStr;
                            } else {
                                // Keep the original date value in the hidden input field
                                document.getElementById('tanggal-masuk').value = originalDate;
                            }
                        }
                    });
                });
            </script>

            <div class="sm:col-span-3">
                <label for="af-pegawai-alamat" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Alamat
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-alamat" name="alamat" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your alamat" value="<?= $alamatData['alamat'] ?>">
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <label for="af-pegawai-alamat-lat" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Alamat_Lat
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-alamat-lat" name="alamat_lat" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your alamat" value="<?= $alamatData['alamat_lat'] ?>">
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <label for="af-pegawai-alamat-Lon" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Alamat_Lon
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-alamat-Lon" name="alamat_lon" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your alamat" value="<?= $alamatData['alamat_lon'] ?>">
                </div>
            </div>
            <!-- End Col -->


            <div class="mt-5 flex justify-end gap-x-2">
        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            Cancel
        </button>
        <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            Simpan perubahan
        </button>
    </div>

    </div>
    <!-- End Grid -->

    
    </form>
</div>
<!-- End Card -->
</div>
<!-- End Card Section -->

<?= $this->endSection(); ?>