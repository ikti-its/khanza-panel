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
                                Data Jadwal
                            </h2>
                   
                        </div>

                        
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                      

                                <th scope="col" class="ps-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            ID
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            ID Pegawai
                                        </span>
                                    </div>
                                </th>


                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            ID Hari
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            ID Shift
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Jam Masuk
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Jam Pulang
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-end"></th>
                                <th scope="col" class="px-6 py-3 text-end"></th>
                            </tr>
                        </thead>


                    

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <?php foreach ($jadwal_data as $jadwalEntry) : ?>
                                    <tr>
                          
                                        <td class="size-px whitespace-nowrap">
                                            <div class="ps-6 py-3">
                                                <div class="flex items-center gap-x-3">
                                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200"><?= $jadwalEntry['id'] ?? 'N/A' ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="h-px w-72 whitespace-nowrap">
                                            <div class="px-6 py-3">
                                               
                                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200"><?= $jadwalEntry['id_pegawai'] ?? 'N/A' ?></span>
                                           
                                             
                                            </div>
                                        </td>

                                        <td class="h-px w-72 whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200"><?= $jadwalEntry['id_hari'] ?? 'N/A' ?></span>
                                            </div>
                                        </td>

                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                            <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200"><?= $jadwalEntry['id_shift'] ?? 'N/A' ?></span>
                                            </div>
                                        </td>

                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                            <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200"><?= $jadwalEntry['jam_masuk'] ?? 'N/A' ?></span>
                                            </div>
                                        </td>


                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                            <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200"><?= $jadwalEntry['jam_pulang'] ?? 'N/A' ?></span>
                                            </div>
                                        </td>

                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-1.5">
                                                <a href="/editjadwal/<?= $jadwalEntry['id']?>" class="inline-flex items-center gap-x-1 text-sm text-teal-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                                                    Edit
                                                </a>
                                            </div>
                                        </td>

                                        <!-- <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-1.5">
                                                <a  href ="/hapuscuti/<?= $jadwalEntry['id'] ?>"class="inline-flex items-center gap-x-1 text-sm text-red-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                                                    Delete
                                                </a>
                                            </div>
                                        </td> -->
                                    </tr>

                                <?php endforeach; ?>


                            </tbody>
                        

                    </table>
                    <!-- End Table -->

                    
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->
</div>
<!-- End Table Section -->

<?= $this->endSection(); ?>