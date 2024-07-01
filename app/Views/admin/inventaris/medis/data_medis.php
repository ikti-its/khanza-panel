<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<!-- Table Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="flex flex-col ">
        <div class="-m-1.5 overflow-y-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                    <!-- Header -->
                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                Barang Medis
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Add Barang Medis, edit and more.
                            </p>
                        </div>

                        <div>
                            <div class="inline-flex gap-x-2">
                                <?php
                                // Check if the reset button is clicked
                                if (isset($_GET['reset']) && $_GET['reset'] === 'true') {
                                    $notification_count = 0;
                                } else {
                                    // Count notifications
                                    $today = new DateTime();
                                    $notification_count = 0;
                                    $notification_period = 30;

                                    foreach ($medis_data as $medis) {
                                        $combined_data = array_combine(['obat', 'bhp', 'alkes', 'darah'], [$obat_data, $bhp_data, $alkes_data, $darah_data]);
                                        foreach ($combined_data as $jenis => $data) {
                                            foreach ($data as $item) {
                                                if ($medis['id'] === $item['id_barang_medis']) {
                                                    if ($jenis !== 'alkes') {
                                                        $kadaluwarsa = new DateTime($item['kadaluwarsa']);
                                                        $interval = $today->diff($kadaluwarsa);
                                                        $days_left = (int)$interval->format('%r%a'); // %r is for the sign and %a is for the total number of days

                                                        if ($days_left <= $notification_period && $days_left >= 0) {
                                                            // Increment the notification count
                                                            $notification_count++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                                <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                                    <button id="reset-notification" id="hs-dropdown-with-header" type="button" class="w-[2.375rem] h-[2.375rem] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 relative">
                                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                                        </svg>
                                        <span id="notification-count" class="absolute top-[-8px] right-[-8px] bg-red-500 rounded-full w-5 h-5 flex items-center justify-center text-white text-xs"><?= $notification_count ?></span>
                                    </button>



                                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg p-2 dark:bg-gray-800 dark:border dark:border-gray-700" aria-labelledby="hs-dropdown-with-header">
                                        <div class="mt-2 py-2 first:pt-0 last:pb-0">
                                            <?php
                                            $today = new DateTime();
                                            // Number of days before expiration to notify
                                            $notification_period = 30;
                                            foreach ($medis_data as $medis) {
                                                $combined_data = array_combine(['obat', 'bhp', 'alkes', 'darah'], [$obat_data, $bhp_data, $alkes_data, $darah_data]);
                                                foreach ($combined_data as $jenis => $data) {
                                                    foreach ($data as $item) {
                                                        if ($medis['id'] === $item['id_barang_medis']) {
                                                            if ($jenis !== 'alkes') {
                                                                $kadaluwarsa = new DateTime($item['kadaluwarsa']);
                                                                $interval = $today->diff($kadaluwarsa);
                                                                $days_left = (int)$interval->format('%r%a'); // %r is for the sign and %a is for the total number of days

                                                                if ($days_left <= $notification_period && $days_left >= 0) {
                                            ?>
                                                                    <a class="notification-item flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                                                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                                                                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                                                                        </svg>
                                                                        Stok <?= $medis['nama'] ?> kadaluwarsa <?= $item['kadaluwarsa'] ?>
                                                                    </a>
                                            <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                                                    <path d="M3 6h18" />
                                                    <path d="M16 10a4 4 0 0 1-8 0" />
                                                </svg>
                                                Tanggal kadaluwarsa Obat 13-05-2024
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                                    View all
                                </a>

                                <a href='/tambahmedis' class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                                    <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M2.63452 7.50001L13.6345 7.5M8.13452 13V2" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th scope="col" class="ps-6 py-3 text-start">
                                    <label for="hs-at-with-checkboxes-main" class="flex">
                                        <input type="checkbox" class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-at-with-checkboxes-main">
                                        <span class="sr-only">Checkbox</span>
                                    </label>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Nama
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Jenis Barang Medis
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center gap-x-2 justify-center">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Stok
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-center">
                                    <div class="flex items-center gap-x-2 justify-center">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Action
                                        </span>
                                    </div>
                                </th>

                            </tr>
                        </thead>




                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php foreach ($medis_data as $medis) : ?>
                                <div id="hs-vertically-centered-scrollable-modal-<?= $medis['id'] ?>" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
                                    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-3.5rem)] min-h-[calc(100%-3.5rem)] flex items-center">
                                        <div class="w-full max-h-full overflow-hidden flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                                            <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                                                <h3 class="font-bold text-gray-800 dark:text-white">
                                                    medis: <?= $medis['id'] ?>
                                                </h3>
                                                <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#hs-vertically-centered-scrollable-modal-<?= $medis['id'] ?>">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M18 6 6 18"></path>
                                                        <path d="m6 6 12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="p-4 overflow-y-auto">
                                                <div class="space-y-4">
                                                    <div>
                                                        <?php foreach ($obat_data as $jenis) {
                                                            if ($medis['id'] === $jenis['id_barang_medis']) {
                                                                if ($medis['jenis'] === 'Obat') { ?>
                                                                    <!-- Ini adalah input tambahan yang akan muncul -->
                                                                    <div class="sm:col-span-3">
                                                                        <div class="inline-block">
                                                                            <label for="af-account-phone" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                                Industri Farmasi
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="sm:col-span-9">
                                                                        <div class="sm:flex">
                                                                            <select name="industrifarmasi" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                                                                <?php
                                                                                $optionsIF = ["1000" => "Kalbe Farma"];
                                                                                foreach ($optionsIF as $valueIF => $textIF) {
                                                                                    // Periksa jika nilai opsi adalah sama dengan nilai medis_data
                                                                                    if ($valueIF === $jenis['industri_farmasi']) {

                                                                                        echo '<option value="' . $valueIF . '" selected>' . $textIF . '</option>';
                                                                                    } else {
                                                                                        echo '<option value="' . $valueIF . '">' . $textIF . '</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>


                                                                    <div class="sm:col-span-3">
                                                                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                            Kandungan
                                                                        </label>
                                                                    </div>
                                                                    <!-- End Col -->
                                                                    <div class="sm:col-span-9">
                                                                        <input name="kandungan" type="text" value="<?= $jenis['kandungan'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                                                    </div>

                                                                    <div class="sm:col-span-3">
                                                                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                            Isi
                                                                        </label>
                                                                    </div>
                                                                    <!-- End Col -->

                                                                    <div class="sm:col-span-3">
                                                                        <input name="isi" type="number" value="<?= $jenis['isi'] ?>" class="py-2 px-3 pe-1 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                                                    </div>
                                                                    <div class="sm:col-span-3">
                                                                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                            Satuan Besar
                                                                        </label>
                                                                    </div>
                                                                    <!-- End Col -->

                                                                    <div class="sm:col-span-3">

                                                                    </div>
                                                                    <div class="sm:col-span-3">
                                                                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                            Kapasitas
                                                                        </label>
                                                                    </div>
                                                                    <div class="sm:col-span-3">
                                                                        <input name="kapasitas" type="number" value="<?= $jenis['kapasitas'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                                                    </div>

                                                                    <div class="sm:col-span-3">
                                                                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                            Satuan Kecil
                                                                        </label>
                                                                    </div>
                                                                    <div class="sm:col-span-3">

                                                                    </div>
                                                                    <div class="sm:col-span-3">
                                                                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                            Jenis
                                                                        </label>
                                                                    </div>
                                                                    <!-- End Col -->

                                                                    <div class="sm:col-span-9">
                                                                        <select name="jenisobat" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                                                            <?php
                                                                            $optionsjenis = [
                                                                                "1000" => "Obat Oral",
                                                                                "2000" => "Obat Topikal",
                                                                                "3000" => "Obat Injeksi",
                                                                                "4000" => "Obat Sublingual"
                                                                            ];

                                                                            foreach ($optionsjenis as $valuejenis => $textjenis) {
                                                                                if ($valuejenis === $jenis['jenis']) {
                                                                                    echo '<option value="' . $valuejenis . '" selected>' . $textjenis . '</option>';
                                                                                } else {
                                                                                    echo '<option value="' . $valuejenis . '">' . $textjenis . '</option>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="sm:col-span-3">
                                                                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                            Kategori
                                                                        </label>
                                                                    </div>
                                                                    <!-- End Col -->

                                                                    <div class="sm:col-span-9">

                                                                    </div>

                                                                    <div class="sm:col-span-3">
                                                                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                            Golongan
                                                                        </label>
                                                                    </div>
                                                                    <!-- End Col -->

                                                                    <div class="sm:col-span-9">

                                                                    </div>

                                                                    <div class="sm:col-span-3">
                                                                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                                                            Tanggal Kadaluwarsa
                                                                        </label>
                                                                    </div>
                                                                    <!-- End Col -->

                                                                    <div class="sm:col-span-9">
                                                                        <input name="kadaluwarsaobat" type="date" value="<?= $jenis['kadaluwarsa'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                                                    </div>

                                                        <?php }
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
                                                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#hs-vertically-centered-scrollable-modal-<?= $medis['id'] ?>">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="ps-6 py-3">
                                                <label for="hs-at-with-checkboxes-1" class="flex">
                                                    <input type="checkbox" class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-at-with-checkboxes-1">
                                                    <span class="sr-only">Checkbox</span>
                                                </label>
                                            </div>
                                        </td>

                                        <td class="h-px w-72 whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200 hover:underline" data-hs-overlay="#hs-vertically-centered-scrollable-modal-<?= $medis['id'] ?>" data-id="<?= $medis['id'] ?>"><?= $medis['nama'] ?? 'N/A' ?></span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                                    <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                                    </svg>
                                                    <?= $medis['jenis'] ?? 'N/A' ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="h-px w-72 whitespace-nowrap">
                                            <div class="px-6 py-3 text-center">
                                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200"><?= $medis['stok'] ?? 'N/A' ?></span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-1.5 inline-flex text-center">
                                                <div class="px-3 py-1.5">
                                                    <button type="button" class="items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-vertically-centered-scrollable-modal-<?= $medis['id'] ?>">
                                                        More Info
                                                    </button>
                                                </div>
                                                <div class="px-3 py-1.5">
                                                    <a href="/editmedis/<?= $medis['id'] ?>" class="items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                                                        Edit
                                                    </a>
                                                </div>
                                                <div class="px-3 py-1.5">
                                                    <a href="/hapusmedis/<?= $medis['id'] ?>" class="items-center gap-x-1 text-sm text-red-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>

                                <?php endforeach; ?>
                        </tbody>


                    </table>
                    <!-- End Table -->

                    <!-- Footer -->
                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-gray-700">
                        <!-- Pagination -->
                        <nav class="flex items-center gap-x-1">
                            <?php if ($meta_data['page'] > 1) : ?>
                                <a href="/datamedis?page=<?= $meta_data['page'] - 1 ?>&size=5" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                                    <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                    <span aria-hidden="true" class="sr-only">Previous</span>
                                </a>
                            <?php endif; ?>

                            <div class="flex items-center gap-x-1">
                                <span class="min-h-[38px] min-w-[38px] flex justify-center items-center border border-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:border-gray-700 dark:text-white dark:focus:bg-white/10"><?= $meta_data['page'] ?></span>
                                <span class="min-h-[38px] flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-gray-500">of</span>
                                <span class="min-h-[38px] flex justify-center items-center text-gray-500 py-2 px-1.5 text-sm dark:text-gray-500"><?= $meta_data['total'] ?></span>
                            </div>

                            <?php if ($meta_data['page'] < $meta_data['total']) : ?>
                                <a href="/datamedis?page=<?= $meta_data['page'] + 1 ?>&size=5" class="min-h-[38px] min-w-[38px] py-2 px-2.5 inline-flex justify-center items-center gap-x-2 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                                    <span aria-hidden="true" class="sr-only">Next</span>
                                    <svg class="flex-shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </a>
                            <?php endif; ?>

                        </nav>


                        <!-- Dropdown -->
                        <div class="hs-dropdown relative inline-flex [--placement:top-left]">
                            <button id="dropDownButton" type="button" class="hs-dropdown-toggle min-h-[32px] py-1 px-2 inline-flex items-center gap-x-1 text-sm rounded-lg border border-gray-200 text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                                <?= $meta_data['size'] ?> page
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <div id="dropdown" class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-48 hidden z-50 transition-[margin,opacity] opacity-0 duration-300 mb-2 bg-white shadow-md rounded-lg p-2 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-700" aria-labelledby="hs-small-pagination-dropdown">

                                <a href="/datamedis?page=1&size=5">
                                    <button type="button" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700">
                                        5 page
                                    </button>
                                </a>

                                <a href="/datamedis?page=1&size=10">
                                    <button type="button" class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700">
                                        10 page
                                    </button>
                                </a>

                            </div>
                        </div>
                        <!-- End Dropdown -->


                        <!-- End Pagination -->
                    </div>

                    <!-- End Footer -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->
</div>
<!-- End Table Section -->
<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     const resetButton = document.getElementById("reset-notification");

    //     resetButton.addEventListener("click", function() {
    //         // Reset the notification count to 0
    //         document.getElementById("notification-count").innerText = "0";
    //         // Redirect to the same page with reset parameter
    //         window.location.href = window.location.pathname + "?reset=true";
    //     });
    // });
</script>
<?= $this->endSection(); ?>