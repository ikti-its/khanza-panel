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
                                    File
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Unggah File
                                </p>
                            </div>

                        
                        </div>

                        <!-- End Header -->

                        <!-- Form for Adding User -->
                        <form action="/submittambahfile" method="post" enctype="multipart/form-data">
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="profile_picture" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Unggah File</label>

                                        <input type="file" name="file_up" id="file_up" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-700 file:text-white hover:file:bg-teal-600 dark:file:bg-teal-700 dark:hover:file:bg-teal-600" accept=".jpg,.jpeg,.png" required>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 flex justify-end">
                                <button type="submit" class="py-2 px-4 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 dark:bg-teal-700 dark:hover:bg-teal-600">Submit</button>
                            </div>
                        </form>
                        
                        <label for="filee" class="block text-sm font-medium text-gray-700 dark:text-gray-400"><?=$file_url2 ?? 'aa'?></label>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Table Section -->

    <?= $this->endSection(); ?>