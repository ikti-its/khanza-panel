<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <form method="post" action="/submiteditjadwal/<?= $userId ?>">

            <div class="px-6 py-5 grid gap-3 md:flex md:justify-between md:items-center">
                <div class="sm:col-span-12">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                        Ubah Jadwal
                    </h2>
                </div>

            </div>

            <div class=" py-4 mx-6 flex justify-between items-center border-b border-gray-200 dark:border-neutral-700">

                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">



                    <div class="sm:col-span-3">
                        <label for="af-account-id" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            ID
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <input id="af-account-id" name="id" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:outline-teal-500 focus:ring-teal-500" value="<?= $jadwalData['id'] ?>">
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-3">
                        <label for="af-account-id-pegawai" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            ID Pegawai
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <input id="af-account-id-pegawai" name="id_pegawai" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:outline-teal-500 focus:ring-teal-500" value="<?= $jadwalData['id_pegawai'] ?>">
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-3">
                        <div class="inline-block">
                            <label for="af-account-phone" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                ID Hari
                            </label>
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <select name="id_hari" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                <option value="1" <?= $jadwalData['id_hari'] == 1 ? 'selected' : '' ?>>1 Senin</option>
                                <option value="2" <?= $jadwalData['id_hari'] == 2 ? 'selected' : '' ?>>2 Selasa</option>
                                <option value="3" <?= $jadwalData['id_hari'] == 3 ? 'selected' : '' ?>>3 Rabu</option>
                                <option value="4" <?= $jadwalData['id_hari'] == 4 ? 'selected' : '' ?>>4 Kamis</option>
                                <option value="5" <?= $jadwalData['id_hari'] == 5 ? 'selected' : '' ?>>5 Jumat</option>
                                <option value="6" <?= $jadwalData['id_hari'] == 6 ? 'selected' : '' ?>>6 Sabtu</option>
                                <option value="7" <?= $jadwalData['id_hari'] == 7 ? 'selected' : '' ?>>7 Minggu</option>
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-id-hari" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            ID Shift
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                        <select name="id_shift" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                <option value="S" <?= $jadwalData['id_shift'] == 'S' ? 'selected' : '' ?>>Sore</option>
                                <option value="P" <?= $jadwalData['id_shift'] == 'P' ? 'selected' : '' ?>>Pagi</option>
                                <option value="M" <?= $jadwalData['id_shift'] == 'M' ? 'selected' : '' ?>>Malam</option>
                            </select>

                        </div>
                    </div>

                    <!-- End Col -->
                </div>
                <!-- End Grid -->


                <!-- End Col -->
                <!-- Hidden input field for pegawai_id -->
                <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo session('user_specific_data')['pegawai'] ?>">


            </div>
            <div class=" py-2 mb-2 mx-6 flex justify-end items-center">
                <!-- Buttons -->
                <div class="mt-6 flex justify-end gap-x-3">
                    <button class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-teal-600 transition-all text-sm dark:bg-neutral-800 dark:hover:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                        Batal
                    </button>
                    <button class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-[#0A2D27] text-[#ACF2E7] hover:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none">

                        Ajukan
                    </button>
                </div>
                <!-- End Buttons -->
            </div>


    </div>


    </form>
</div>
<!-- End Card -->
</div>
<!-- End Card Section -->


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tanggalMulaiFlatpickr = flatpickr('#selected-date-mulai', {
            altInput: true, // Enable to use an alternative input field
            altFormat: 'Y-m-d', // Format of the alternative input field
            dateFormat: 'Y-m-d', // Date format
            onClose: function(selectedDates, dateStr, instance) {
                // Update the hidden input field with the selected date value
                document.getElementById('tanggal_mulai').value = dateStr;
                // Update the minimum date for tanggal_selesai
                tanggalSelesaiFlatpickr.set('minDate', dateStr);
            }
        });

        var tanggalSelesaiFlatpickr = flatpickr('#selected-date-selesai', {
            altInput: true, // Enable to use an alternative input field
            altFormat: 'Y-m-d', // Format of the alternative input field
            dateFormat: 'Y-m-d', // Date format
            onClose: function(selectedDates, dateStr, instance) {
                // Update the hidden input field with the selected date value
                document.getElementById('tanggal_selesai').value = dateStr;
            }
        });
    });
</script>


<?= $this->endSection(); ?>