<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                Tambah Pegawai
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Tambah Akun Pegawai
            </p>
        </div>

        <form action="/submittambahpegawai" method="post">
            <!-- Grid -->

            <div class="sm:col-span-3">
                    


            <div class="sm:col-span-3">
                <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    ID Akun
                </label>
            </div>

            <!-- End Col -->

            <div class="sm:col-span-9">
                <input id="af-id-akun" name="id_akun" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="36 characters uuid">
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
                    <input id="af-pegawai-nip" name="nip" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your nip">
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
                        <option value="L" selected>(L) Laki-laki</option>
                        <option value="P">(P) Perempuan</option>
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
                        <option value="1000" selected>1000 Kepala Departemen</option>
                        <option value="1001">1001 Wakil Kepala Departemen</option>
                        <option value="1002">1002 Pegawai</option>

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
                        <option value="1000" selected>(1000 Pelayanan Medik dan Keperawatan)</option>
                        <option value="1001">1001 (Pelayanan Penunjang Medik)</option>
                        <option value="2000">2000 (SDM Pendidikan dan Penelitian)</option>
                        <option value="2001">2001 (Perencanaan dan Evaluasi)</option>
                        <option value="2002">2002 (Keuangan dan BMN)</option>
                        <option value="2003">2003 (Organisasi dan Umum)</option>
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
                        <option value="A" selected>(A) Aktif</option>
                        <option value="BH">(BH) Berhenti dengan Hormat</option>
                        <option value="C">(C) Cuti</option>
                        <option value="R">(R) Resign</option>
                        <option value="BT">(BH) Berhenti dengan Tidak Hormat</option>
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
                        <option value="Tetap" selected>Tetap</option>
                        <option value="Kontrak">Kontrak</option>
                        <option value="Magang">Magang</option>
                        <option value="Istimewa">Istimewa</option>
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
                    <input id="af-pegawai-departemen" name="telepon" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your telepon">
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
                    <input id="selected-date" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Selected Date" readonly>
                    <!-- Hidden input field to store the selected date value -->
                    <input id="tanggal-masuk" name="tanggal_masuk" type="hidden">
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

                        onClose: function(selectedDates, dateStr, instance) {
                            // Update the hidden input field with the selected date value
                            document.getElementById('tanggal-masuk').value = dateStr;
                        }
                    });
                });
            </script>

            <!-- End Col -->


            <div class="sm:col-span-3">
                <label for="af-pegawai-kota" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Kota
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-kota" name="kota" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your kota">
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="af-pegawai-kode-pos" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                    Kode Pos
                </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
                <div class="space-y-2">
                    <input id="af-pegawai-kode-pos" name="kode_pos" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter your kode_pos">
                </div>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
                <label for="af-account-alamat" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                    Alamat
                </label>
            </div>
            <!-- End Col -->
            <div class="sm:col-span-9">
                <input readonly id="af-account-alamat-edit" type="text" name="alamat" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:outline-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Your alamat" value="<?= $lokasi_data['alamat'] ?? '' ?>">
            </div>
            <!-- End Col -->
            <div class="sm:col-span-3">
                <label for="af-account-lOkasi" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                    Denah Lokasi
                </label>
            </div>
            <!-- End Col -->
            <div class="sm:col-span-9">
                <input id="af-account-alamat-lat" type="text" name="latitude" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-teal-500 focus:ring-teal-500" placeholder="Your alamat" value="<?= $lokasi_data['latitude'] ?? '' ?>" readonly>
                <input id="af-account-alamat-lon" type="text" name="longitude" class="mt-4 py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-teal-500 focus:ring-teal-500" placeholder="Your alamat" value="<?= $lokasi_data['longitude'] ?? '' ?>" readonly>
                <div id="map2" class="mt-4 py-2 px-3 block w-full h-72 rounded-xl"></div>
            </div>
            <!-- End Col -->

            <!-- End Grid -->
            <div class="mt-5 flex justify-end gap-x-2">
                <button type="button" id="edit-location-btn" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-white/10 dark:hover:bg-white/20 dark:text-white dark:hover:text-white">
                    Ubah lokasi
                </button>
            </div>

            <div class="mt-5 flex justify-end gap-x-2">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    Batal
                </button>
                <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    Tambah Pegawai
                </button>
            </div>

    </div>
    <!-- End Grid -->


    </form>
</div>
<!-- End Card -->
</div>
<!-- End Card Section -->


<script>
    function initMap() {

        console.log("AAA")
        // Get latitude and longitude from PHP variable
        var latLng = '<?= ($lokasi_data['latitude'] ?? '7.2575') . ', ' . ($lokasi_data['longitude'] ?? '112.7521') ?>';
        var latLngArray = latLng.split(',').map(function(item) {
            return parseFloat(item);
        });

        console.log(latLngArray); // Add this line to check latLngArray values
        // If latitude and longitude are valid
        if (!isNaN(latLngArray[0]) && !isNaN(latLngArray[1])) {
            // Create a LatLng object
            var myLatLng = {
                lat: latLngArray[0],
                lng: latLngArray[1]
            };

            // Create a new map object
            var map = new google.maps.Map(document.getElementById('map2'), {
                zoom: 12, // Set the initial zoom level
                center: myLatLng // Center the map on the specified location
            });

            // Add a marker to the map
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Your Location'
            });

            // Add click event listener to the "Edit Location" button
            document.getElementById('edit-location-btn').addEventListener('click', function() {
                // Request the user's current location
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var userLatLng = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        // Center the map to the user's current location
                        map.setCenter(userLatLng);
                        map.setZoom(15);

                        // Remove previous marker
                        if (marker) {
                            marker.setMap(null);
                        }

                        // Add a new marker to the map
                        marker = new google.maps.Marker({
                            position: userLatLng,
                            map: map,
                            title: 'Your Location'
                        });

                        // Update the input field with the new coordinates
                        document.getElementById('af-account-alamat-lat').value = userLatLng.lat;
                        document.getElementById('af-account-alamat-lon').value = userLatLng.lng;

                        // Reverse geocode using OpenStreetMap Nominatim API
                        var apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLatLng.lat}&lon=${userLatLng.lng}`;

                        fetch(apiUrl)
                            .then(response => response.json())
                            .then(data => {
                                if (data.display_name) {
                                    // Set the location name to the input field
                                    document.getElementById('af-account-alamat-edit').value = data.display_name;
                                    if (data.address.city) {
                                        document.getElementById('af-pegawai-kota').value = data.address.city;
                                    } else if (data.address.town) {
                                        document.getElementById('af-pegawai-kota').value = data.address.town;
                                    } else if (data.address.village) {
                                        document.getElementById('af-pegawai-kota').value = data.address.village;
                                    }

                                    if (data.address.postcode) {
                                        document.getElementById('af-pegawai-kode-pos').value = data.address.postcode;
                                    }
                                } else {
                                    console.error('Error: No address found.');
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching address:', error);
                            });

                    }, function() {
                        alert('Error: The Geolocation service failed.');
                    });
                } else {
                    alert('Error: Your browser doesn\'t support Geolocation.');
                }
            });
        }

    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?= getenv('api_map_key') ?>&callback=initMap" async defer></script>

<script>
    document.getElementById('profilePhoto').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var img = document.getElementById('preview-image');
            img.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

<?= $this->endSection(); ?>