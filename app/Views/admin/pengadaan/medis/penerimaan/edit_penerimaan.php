<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                Edit Penerimaan Barang Medis
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Manage your name, password and account settings.
            </p>
        </div>

        <form action="/submiteditpenerimaanmedis/<?= $penerimaan_data['id'] ?>" method="post">
            <!-- Grid -->
            <input type="hidden" value="<?= $penerimaan_data['id_pengajuan'] ?>" name="idpengajuan" class="text-center w-full border border-gray-300 text-center" readonly>

            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Tanggal Penerimaan
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <input name="tgldatang" value="<?= $penerimaan_data['tanggal_datang'] ?>" type="date" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Paracetamol">
                </div>
                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Tanggal Faktur
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <input name="tglfaktur" value="<?= $penerimaan_data['tanggal_faktur'] ?>" type="date" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Paracetamol">
                </div>
                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Tanggal Jatuh Tempo
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <input name="tgljatuhtempo" value="<?= $penerimaan_data['tanggal_jthtempo'] ?>" type="date" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Paracetamol">
                </div>
                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Nomor Faktur
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <input name="nofaktur" value="<?= $penerimaan_data['no_faktur'] ?>" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" value="">
                </div>
                <!-- End Col -->

                <div class="sm:col-span-3">
                    <div class="inline-block">
                        <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Nomor Pemesanan
                        </label>
                    </div>
                </div>
                <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <input name="idpemesanan" value="<?= $penerimaan_data['id_pemesanan'] ?>" type="hidden">
                        <input name="" value="<?php foreach ($pemesanan_data as $pemesanan) {
                                                    if ($penerimaan_data['id_pemesanan'] === $pemesanan['id']) {
                                                        echo $pemesanan['no_pemesanan'];
                                                    }
                                                } ?>" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" value="">
                    </div>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Pegawai
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <select name="pegawaipenerimaan" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <?php
                            foreach ($pegawai_data as $pegawai) {
                                $optionpegawai = [$pegawai['id'] => $pegawai['nama']];
                                foreach ($optionpegawai as $pegawaiid => $pegawainama) {
                                    if ($pegawaiid === $penerimaan_data['id_pegawai']) {
                                        echo '<option value="' . $pegawai['id'] . '" selected>' . $pegawai['nama'] . '</option>';
                                    } else {
                                        echo '<option value="' . $pegawai['id'] . '">' . $pegawai['nama'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Ruangan
                    </label>
                </div>
                <!-- End Col -->
                <div class="sm:col-span-9">
                    <select name="idruangan" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                        <?php
                        $optionsruangan = [
                            "1000" => "VIP 1",
                            "2000" => "VIP 2",
                            "3000" => "VVIP 1",
                            "4000" => "VVIP 2",
                            "5000" => "Gudang Farmasi"
                        ];

                        foreach ($optionsruangan as $valueruangan => $textruangan) {
                            if ($valueruangan === $penerimaan_data['id_ruangan']) {
                                echo '<option value="' . $valueruangan . '" selected>' . $textruangan . '</option>';
                            } else {
                                echo '<option value="' . $valueruangan . '">' . $textruangan . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

            </div>
            <!-- End Grid -->
            <div class="mt-5 flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="border rounded-lg overflow-hidden dark:border-neutral-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700" id="item-list">
                                <colgroup>

                                    <col width="7%">
                                    <!-- 38% -->
                                    <col width="13%">
                                    <col width="25%">
                                    <col width="10%">
                                    <col width="20%">
                                    <col width="25%">
                                </colgroup>
                                <thead>
                                    <tr class="bg-navy disabled">
                                        <th class="px-1 py-1 text-center">Qty</th>
                                        <th class="px-1 py-1 text-center">Satuan</th>
                                        <th class="px-1 py-1">Item</th>
                                        <th class="px-1 py-1 text-center">Jumlah Diterima</th>
                                        <th class="px-1 py-1 text-center">Kadaluwarsa</th>
                                        <th class="px-1 py-1 text-center">No Batch</th>
                                    </tr>
                                </thead>
                                <tbody class="tabelbodypesanan divide-y divide-gray-200 dark:divide-neutral-700">
                                    <?php foreach ($pesanan_data as $pesanan) : ?>
                                        <tr>
                                            <input type="hidden" value="<?= $pesanan['id'] ?>" class="text-center w-full border" name="idpesanan[]" />
                                            <input type="hidden" value="<?= $pesanan['harga_satuan'] ?>" class="text-center w-full border" name="harga_satuan[]" />

                                            <td class="align-middle p-1 text-center">
                                                <input type="number" value="<?= $pesanan['jumlah_pesanan'] ?>" class="text-center w-full" step="any" name="jumlah_pesanan[]" readonly />
                                            </td>
                                            <td class="align-middle p-1">
                                                <input name="satuan[]" value="<?= $pesanan['satuan'] ?>" type="hidden">
                                                <input name="" value="<?php foreach ($satuan_data as $satuan) {
                                                                            if ($pesanan['satuan'] === $satuan['id']) {
                                                                                echo $satuan['nama'];
                                                                            }
                                                                        } ?>" type="text" class="text-center w-full">
                                            </td>
                                            <td class="align-middle p-1">
                                                <input name="idbrgmedis[]" value="<?= $pesanan['id_barang_medis'] ?>" type="hidden">
                                                <input name="" value="<?php foreach ($barang_medis_data as $barang_medis) {
                                                                            if ($pesanan['id_barang_medis'] === $barang_medis['id']) {
                                                                                echo $barang_medis['nama'];
                                                                            }
                                                                        } ?>" type="text" class="text-center w-full">
                                            </td>
                                            <td class="align-middle p-1 text-center">
                                                <input type="text" value="<?= $pesanan['jumlah_diterima'] ?>" class="text-center w-full border" name="jumlah_diterima[]" />
                                            </td>
                                            <td class="align-middle p-1 text-center">
                                                <input type="date" value="<?= $pesanan['kadaluwarsa'] ?>" class="text-center w-full border" name="kadaluwarsa[]" />
                                            </td>
                                            <td class="align-middle p-1 text-center">
                                                <input type="text" value="<?= $pesanan['no_batch'] ?>" class="text-center w-full border" name="no_batch[]" />
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>



                            </table>

                        </div>

                    </div>
                </div>

            </div>
            <div class="mt-5 flex justify-end gap-x-2">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    Cancel
                </button>
                <button type="submit" value="4" name="statuspesanan" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    Save changes
                </button>
            </div>
        </form>

    </div>
    <!-- End Card -->

</div>

<!-- End Card Section -->

<?= $this->endSection(); ?>