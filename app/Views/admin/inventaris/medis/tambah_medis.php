<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                Tambah Data Barang Medis
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Manage your name, password and account settings.
            </p>
        </div>

        <form action="/submittambahmedis" method="post">
            <!-- Grid -->
            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                <div class="sm:col-span-3">
                    <div class="inline-block">
                        <label for="af-account-phone" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Jenis
                        </label>
                    </div>
                </div>
                <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <select id="jenis" name="jenisbrgmedis" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required>
                            <option value="" selected>-</option>
                            <option value="Obat">Obat</option>
                            <option value="Alat Kesehatan">Alat Kesehatan</option>
                            <option value="Bahan Habis Pakai">Bahan Habis Pakai</option>
                            <option value="Darah">Darah</option>
                        </select>
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Nama
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <input id="af-account-email" name="nama" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Paracetamol">
                </div>

                <!-- End Col -->

                <!-- Ini adalah input tambahan yang akan muncul -->
                <div class="sm:col-span-3 additionalInputObat" style="display:none;">
                    <div class="inline-block">
                        <label for="af-account-phone" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Industri Farmasi
                        </label>
                    </div>
                </div>
                <div class="sm:col-span-9 additionalInputObat" style="display:none;">
                    <div class="sm:flex">
                        <select name="industrifarmasi" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <option selected>-</option>
                            <option value="1000">Kalbe Farma</option>
                        </select>
                    </div>
                </div>


                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Kandungan
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputObat sm:col-span-9" style="display:none;">
                    <input name="kandungan" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>
                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Isi
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <input name="isi" type="number" class="py-2 px-3 pe-1 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>
                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Satuan Besar
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <select name="satuanobat" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <?php foreach ($satuan_data as $satuan) : ?>
                            <option value="<?= $satuan['id'] ?>"><?= $satuan['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Kapasitas
                    </label>
                </div>

                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <input name="kapasitas" type="number" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>

                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Satuan Kecil
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <select name="satkecil" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <?php foreach ($satuan_data as $satuan) : ?>
                            <option value="<?= $satuan['id'] ?>"><?= $satuan['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Jenis
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputObat sm:col-span-9" style="display:none;">
                    <select name="jenisobat" class="py-2 px-3 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <option selected>-</option>
                        <option value="1000">Obat Oral</option>
                        <option value="2000">Obat Topikal</option>
                        <option value="3000">Obat Injeksi</option>
                        <option value="4000">Obat Sublingual</option>
                    </select>
                </div>

                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Kategori
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputObat sm:col-span-9" style="display:none;">
                    <select name="kategoriobat" class="py-2 px-3 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <option selected>-</option>
                        <option value="1000">Obat Paten</option>
                        <option value="2000">Obat Generik</option>
                        <option value="3000">Obat Merek</option>
                        <option value="4000">Obat Eksklusif</option>
                    </select>
                </div>

                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Golongan
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputObat sm:col-span-9" style="display:none;">
                    <select name="golonganobat" class="py-2 px-3 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <option selected>-</option>
                        <option value="1000">Analgesik</option>
                        <option value="2000">Antibiotik</option>
                        <option value="3000">Antijamur</option>
                        <option value="4000">Antivirus</option>
                    </select>
                </div>

                <div class="additionalInputObat sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Tanggal Kadaluwarsa
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputObat sm:col-span-9" style="display:none;">
                    <input name="kadaluwarsaobat" type="date" class="py-2 px-3 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>

                <div class="additionalInputAlkes sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Satuan
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputAlkes sm:col-span-9" style="display:none;">
                    <select name="satuanalkes" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <?php foreach ($satuan_data as $satuan) : ?>
                            <option value="<?= $satuan['id'] ?>"><?= $satuan['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="additionalInputAlkes sm:col-span-3" style="display: none;">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Merek
                    </label>
                </div>
                <!-- End Col -->
                <div class="additionalInputAlkes sm:col-span-9" style="display: none;">
                    <input id="af-account-email" name="merekalkes" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>

                <div class="additionalInputBHP sm:col-span-3" style="display: none;">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Jumlah
                    </label>
                </div>
                <div class="additionalInputBHP sm:col-span-9" style="display: none;">
                    <input id="af-account-email" name="jumlahbhp" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>
                <!-- End Col -->
                <div class="additionalInputBHP sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Satuan
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputBHP sm:col-span-9" style="display:none;">
                    <select name="satuanbhp" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <?php foreach ($satuan_data as $satuan) : ?>
                            <option value="<?= $satuan['id'] ?>"><?= $satuan['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- End Col -->

                <div class="additionalInputBHP sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Tanggal Kadaluwarsa
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputBHP sm:col-span-9" style="display:none;">
                    <input name="kadaluwarsabhp" type="date" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>

                <div class="additionalInputDarah sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Satuan
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputDarah sm:col-span-9" style="display:none;">
                    <select name="satuandarah" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <?php foreach ($satuan_data as $satuan) : ?>
                            <option value="<?= $satuan['id'] ?>"><?= $satuan['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="additionalInputDarah sm:col-span-3" style="display: none;">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Jenis Darah
                    </label>
                </div>
                <!-- End Col -->
                <div class="additionalInputDarah sm:col-span-9" style="display: none;">
                    <select name="jenisdarah" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <option value="" selected>-</option>
                        <option value="Whole Blood (WB)">Whole Blood (WB)</option>
                        <option value="Packed Red Cell (PRC)">Packed Red Cell (PRC)</option>
                        <option value="Thrombocyte Concentrate (TC)">Thrombocyte Concentrate (TC)</option>
                        <option value="Fresh Frozen Plasma (FFP)">Fresh Frozen Plasma (FFP)</option>
                    </select>
                </div>
                <div class="additionalInputDarah sm:col-span-3" style="display: none;">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Keterangan
                    </label>
                </div>
                <!-- End Col -->
                <div class="additionalInputDarah sm:col-span-9" style="display: none;">
                    <input id="af-account-email" name="keterangandarah" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>

                <div class="additionalInputDarah sm:col-span-3" style="display:none;">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Tanggal Kadaluwarsa
                    </label>
                </div>
                <!-- End Col -->

                <div class="additionalInputDarah sm:col-span-9" style="display:none;">
                    <input name="kadaluwarsadarah" type="date" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>

                <div class="sm:col-span-3">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Harga
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <input id="af-account-email" name="harga" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>

                <div class="sm:col-span-3">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Stok
                    </label>
                </div>
                <!-- End Col -->
                <div class="sm:col-span-9">
                    <input id="af-account-email" name="stok" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0">
                </div>

            </div>
            <!-- End Grid -->

            <div class="mt-5 flex justify-end gap-x-2">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    Cancel
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
<script>
    document.getElementById('jenis').addEventListener('change', function() {
        var jenisValue = this.value;
        var additionalInputObats = document.getElementsByClassName('additionalInputObat');
        var additionalInputAlkess = document.getElementsByClassName('additionalInputAlkes');
        var additionalInputBHPs = document.getElementsByClassName('additionalInputBHP');
        var additionalInputDarahs = document.getElementsByClassName('additionalInputDarah');

        // Loop melalui setiap elemen additionalInputObat dan atur tampilan sesuai dengan nilai jenisValue
        for (var i = 0; i < additionalInputObats.length; i++) {
            var additionalInputObat = additionalInputObats[i];
            if (jenisValue === 'Obat') {
                additionalInputObat.style.display = 'block';
            } else {
                additionalInputObat.style.display = 'none';
            }
        }

        // Loop melalui setiap elemen additionalInputAlkes dan atur tampilan sesuai dengan nilai jenisValue
        for (var j = 0; j < additionalInputAlkess.length; j++) {
            var additionalInputAlkes = additionalInputAlkess[j];
            if (jenisValue === 'Alat Kesehatan') {
                additionalInputAlkes.style.display = 'block';
            } else {
                additionalInputAlkes.style.display = 'none';
            }
        }

        for (var k = 0; k < additionalInputBHPs.length; k++) {
            var additionalInputBHP = additionalInputBHPs[k];
            if (jenisValue === 'Bahan Habis Pakai') {
                additionalInputBHP.style.display = 'block';
            } else {
                additionalInputBHP.style.display = 'none';
            }
        }

        for (var l = 0; l < additionalInputDarahs.length; l++) {
            var additionalInputDarah = additionalInputDarahs[l];
            if (jenisValue === 'Darah') {
                additionalInputDarah.style.display = 'block';
            } else {
                additionalInputDarah.style.display = 'none';
            }
        }
    });
</script>
<?= $this->endSection(); ?>