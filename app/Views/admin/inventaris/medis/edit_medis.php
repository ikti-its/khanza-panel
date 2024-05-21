<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                Edit Data Barang Medis
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Manage your name, password and account settings.
            </p>
        </div>

        <form action="/submiteditmedis/<?= $medis_data['id'] ?>" method="post">
            <!-- Grid -->
            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                <input name="idbrgmedis" value="<?= $medis_data['id'] ?>" type="hidden">
                <input name="idjenisbrgmedis" value="<?= $jenis_data['id'] ?>" type="hidden">

                <div class="sm:col-span-3">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Nama
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <input id="af-account-email" name="nama" value="<?= $medis_data['nama'] ?>" type="text" class="py-2 px-3 pe-11 block w-full shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Paracetamol">
                </div>
                <!-- End Col -->

                <div class="sm:col-span-3">
                    <div class="inline-block">
                        <label for="af-account-phone" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Jenis
                        </label>
                    </div>
                </div>
                <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <select id="jenis" name="jenisbrgmedis" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <option value="<?= $medis_data['jenis'] ?>"><?= $medis_data['jenis'] ?></option>

                        </select>
                    </div>
                </div>
                <!-- <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <select id="jenis" name="jenisbrgmedis" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" disabled>
                            <?php
                            $options = ["Obat", "Alat Kesehatan", "Bahan Habis Pakai", "Darah"];
                            foreach ($options as $option) {
                                // Periksa jika nilai opsi adalah sama dengan nilai medis_data
                                if ($option === $medis_data['jenis']) {
                                    echo '<option value="' . $option . '" selected>' . $option . '</option>';
                                } else {
                                    echo '<option value="' . $option . '">' . $option . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>                 -->

                <!-- End Col -->
                <?php if ($medis_data['jenis'] === 'Obat') : ?>
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
                                    if ($valueIF === $jenis_data['industri_farmasi']) {

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
                        <input name="kandungan" type="text" value="<?= $jenis_data['kandungan'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Isi
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-3">
                        <input name="isi" type="number" value="<?= $jenis_data['isi'] ?>" class="py-2 px-3 pe-1 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Satuan Besar
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-3">
                        <select name="satuanbrgmedis" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <?php
                            foreach ($satuan_data as $satuan) {
                                $optionsatuan = [$satuan['id'] => $satuan['nama']];
                                foreach ($optionsatuan as $satuanid => $satuannama) {
                                    if ($satuanid === $jenis_data['satuan']) {
                                        echo '<option value="' . $satuan['id'] . '" selected>' . $satuan['nama'] . '</option>';
                                    } else {
                                        echo '<option value="' . $satuan['id'] . '">' . $satuan['nama'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Kapasitas
                        </label>
                    </div>
                    <div class="sm:col-span-3">
                        <input name="kapasitas" type="number" value="<?= $jenis_data['kapasitas'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Satuan Kecil
                        </label>
                    </div>
                    <div class="sm:col-span-3">
                        <select name="satuanobat" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <?php
                            foreach ($satuan_data as $satuan) {
                                $optionsatuan = [$satuan['id'] => $satuan['nama']];
                                foreach ($optionsatuan as $satuanid => $satuannama) {
                                    if ($satuanid === $jenis_data['satuan']) {
                                        echo '<option value="' . $satuan['id'] . '" selected>' . $satuan['nama'] . '</option>';
                                    } else {
                                        echo '<option value="' . $satuan['id'] . '">' . $satuan['nama'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
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
                                if ($valuejenis === $jenis_data['jenis']) {
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
                        <select name="kategoriobat" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <?php
                            $optionskategori = [
                                "1000" => "Obat Paten",
                                "2000" => "Obat Generik",
                                "3000" => "Obat Merek",
                                "4000" => "Obat Eksklusif"
                            ];

                            foreach ($optionskategori as $valuekategori => $textkategori) {
                                if ($valuekategori === $jenis_data['kategori']) {
                                    echo '<option value="' . $valuekategori . '" selected>' . $textkategori . '</option>';
                                } else {
                                    echo '<option value="' . $valuekategori . '">' . $textkategori . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Golongan
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <select name="golonganobat" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <?php
                            $optionsgolongan = [
                                "1000" => "Analgesik",
                                "2000" => "Antibiotik",
                                "3000" => "Antijamur",
                                "4000" => "Antivirus"
                            ];

                            foreach ($optionsgolongan as $valuegolongan => $textgolongan) {
                                if ($valuegolongan === $jenis_data['golongan']) {
                                    echo '<option value="' . $valuegolongan . '" selected>' . $textgolongan . '</option>';
                                } else {
                                    echo '<option value="' . $valuegolongan . '">' . $textgolongan . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Tanggal Kadaluwarsa
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <input name="kadaluwarsaobat" type="date" value="<?= $jenis_data['kadaluwarsa'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                    </div>
                <?php elseif ($medis_data['jenis'] === 'Alat Kesehatan') : ?>
                    <div class="sm:col-span-3">
                        <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Satuan
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <select name="satuanbrgmedis" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <?php
                            foreach ($satuan_data as $satuan) {
                                $optionsatuan = [$satuan['id'] => $satuan['nama']];
                                foreach ($optionsatuan as $satuanid => $satuannama) {
                                    if ($satuanid === $medis_data['satuan']) {
                                        echo '<option value="' . $satuan['id'] . '" selected>' . $satuan['nama'] . '</option>';
                                    } else {
                                        echo '<option value="' . $satuan['id'] . '">' . $satuan['nama'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Merek
                        </label>
                    </div>
                    <!-- End Col -->
                    <div class="sm:col-span-9">
                        <input id="af-account-email" name="merekalkes" value="<?= $jenis_data['merek'] ?>" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                    </div>
                <?php elseif ($medis_data['jenis'] === 'Bahan Habis Pakai') : ?>
                    <div class="sm:col-span-3">
                        <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Jumlah
                        </label>
                    </div>
                    <!-- End Col -->
                    <div class="sm:col-span-9">
                        <input id="af-account-email" name="jumlahbhp" type="text" value="<?= $jenis_data['jumlah'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Satuan
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <select name="satuanbrgmedis" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <?php
                            foreach ($satuan_data as $satuan) {
                                $optionsatuan = [$satuan['id'] => $satuan['nama']];
                                foreach ($optionsatuan as $satuanid => $satuannama) {
                                    if ($satuanid === $medis_data['satuan']) {
                                        echo '<option value="' . $satuan['id'] . '" selected>' . $satuan['nama'] . '</option>';
                                    } else {
                                        echo '<option value="' . $satuan['id'] . '">' . $satuan['nama'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Tanggal Kadaluwarsa
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <input name="kadaluwarsabhp" type="date" value="<?= $jenis_data['kadaluwarsa'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                    </div>
                <?php elseif ($medis_data['jenis'] === 'Darah') : ?>
                    <div class="sm:col-span-3">
                        <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Satuan
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <select name="satuanbrgmedis" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <?php
                            foreach ($satuan_data as $satuan) {
                                $optionsatuan = [$satuan['id'] => $satuan['nama']];
                                foreach ($optionsatuan as $satuanid => $satuannama) {
                                    if ($satuanid === $medis_data['satuan']) {
                                        echo '<option value="' . $satuan['id'] . '" selected>' . $satuan['nama'] . '</option>';
                                    } else {
                                        echo '<option value="' . $satuan['id'] . '">' . $satuan['nama'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Jenis Darah
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <select name="jenisdarah" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <?php
                            $options = [
                                "Whole Blood (WB)",
                                "Packed Red Cell (PRC)",
                                "Thrombocyte Concentrate (TC)",
                                "Fresh Frozen Plasma (FFP)"
                            ];

                            foreach ($options as $value) {
                                if ($value === $jenis_data['jenis']) {
                                    echo '<option value="' . $value . '" selected>' . $value . '</option>';
                                } else {
                                    echo '<option value="' . $value . '">' . $value . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Keterangan
                        </label>
                    </div>
                    <!-- End Col -->
                    <div class="sm:col-span-9">
                        <input id="af-account-email" name="keterangandarah" type="text" value="<?= $jenis_data['keterangan'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Tanggal Kadaluwarsa
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <input name="kadaluwarsadarah" type="date" value="<?= $jenis_data['kadaluwarsa'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                    </div>
                <?php endif; ?>
                <div class="sm:col-span-3">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Harga
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <input id="af-account-email" name="harga" type="text" value="<?= $medis_data['harga'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                </div>

                <div class="sm:col-span-3">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Stok
                    </label>
                </div>
                <!-- End Col -->
                <div class="sm:col-span-9">
                    <input id="af-account-email" name="stok" type="text" value="<?= $medis_data['stok'] ?>" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                </div>

            </div>
            <!-- End Grid -->

            <div class="mt-5 flex justify-end gap-x-2">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <a href="/datamedis">Cancel</a>
                </button>
                <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    Save changes
                </button>
            </div>
        </form>
    </div>
    <!-- End Card -->
</div>
<!-- End Card Section -->

<?= $this->endSection(); ?>