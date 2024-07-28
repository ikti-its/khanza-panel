<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                Tambah Shift
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Tambah Shift Kerja
            </p>
        </div>

        <form id="shiftForm" action="/submittambahshift" method="post">
            <!-- Grid -->

            <div class="sm:col-span-3">
                <label for="af-pegawai-id" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    ID
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-id" name="id" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your name">
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
                    <input id="af-pegawai-nama" name="nama" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your name">
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <label for="af-pegawai-jam-masuk" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Jam Masuk
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-jam-masuk" name="jam_masuk" type="time" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your jam masuk">
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <label for="af-pegawai-jam-pulang" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Jam Pulang
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-jam-pulang" name="jam_pulang" type="time" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your jam pulang">
                </div>
            </div>
            <!-- End Col -->

            <div class="mt-5 flex justify-end gap-x-2">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" onclick="resetForm()">
                    Batal
                </button>
                <button type="submit" id="submitButton" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    Tambah Shift
                </button>
            </div>
        </form>
    </div>
    <!-- End Card -->
</div>
<!-- End Card Section -->

<script>
function formatTimeToHHMMSS(timeStr) {
    const [hours, minutes] = timeStr.split(':');
    return `${hours}:${minutes}:00`;
}

document.getElementById('shiftForm').addEventListener('submit', function(event) {
    const jamMasukInput = document.getElementById('af-pegawai-jam-masuk');
    const jamPulangInput = document.getElementById('af-pegawai-jam-pulang');

    jamMasukInput.value = formatTimeToHHMMSS(jamMasukInput.value);
    jamPulangInput.value = formatTimeToHHMMSS(jamPulangInput.value);
});

function resetForm() {
    document.getElementById('shiftForm').reset();
}
</script>

<?= $this->endSection(); ?>
