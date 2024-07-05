<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>


<?php
date_default_timezone_set('Asia/Bangkok'); // Set default timezone to Asia/Bangkok
?>

<!-- Table Section -->
<div class="overflow overflow-auto px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
        <div class="-m-3.5 overflow-x-auto">
            <div class="p-1.5 w-full inline-block align-midd    le">

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">

                    <form method="post" action="/submitkonfirmasitambahfoto">

                        <div class="px-6 py-5 grid gap-3 md:flex md:justify-between md:items-center">
                            <div class="sm:col-span-12">
                                <h2 class="text-lg font-bold text-gray-800 dark:text-neutral-200">
                                    Konfirmasi Tambah Foto Pegawai
                                </h2>
                            </div>

                        </div>

                        <div class="py-4 mx-6 flex justify-between items-center border-b border-gray-200 dark:border-neutral-700">

                            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                                <div class="sm:col-span-3">
                                    <label for="af-account-role" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                        ID Pegawai
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="sm:col-span-9">
                                    <!-- Input field to display the selected date -->
                                    <input id="id_pegawai" name="id_pegawai" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:outline-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="ID Pegawai">
                                </div>
                                <!-- End Col -->


                                <!-- Display photo if available -->
                                <div class="sm:col-span-3">
                                    <label for="af-account-alasan" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                        Foto
                                    </label>
                                </div>
                                <div class="sm:col-span-9 flex items-center">
                                    <?php if (!empty(session()->get('foto_data')['foto'])) : ?>
                                        <img src="<?= esc(session()->get('foto_data')['foto']) ?>" alt="foto"  class="rounded-lg h-16">
                                        <input id="foto" name="foto" type="hidden" value="<?= esc(session()->get('foto_data')['foto']) ?>" >
                                    <?php else : ?>
                                        <span class="text-sm text-gray-500">Swafoto tidak digunakan</span>
                                    <?php endif; ?>
                                </div>


                            </div>


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



                    </form>

                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Table Section -->




    <?= $this->endSection(); ?>