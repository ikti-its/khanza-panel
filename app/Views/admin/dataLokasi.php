<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<div class="overflow overflow-x-auto mt-5 mr-4 ml-4 bg-white shadow-xl rounded-lg text-gray-900">
    <!-- Card Section -->
    <div class="overflow overflow-x-auto px-4 py-10 sm:px-6 lg:px-8 mx-auto"><!-- Card -->
     
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    Cek Lokasi Organisasi
                </h2>
            </div>

            <form action="/submiteditlokasi/<?= $lokasi_data['id'] ?? '' ?>" method="post">
                <!-- Grid -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                    <div class="sm:col-span-3">
                        <label for="af-account-id" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            ID
                        </label>
                    </div>
                    <!-- End Col -->
                    <div class="sm:col-span-9">
                        <input id="af-account-id" type="text" name="id" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:outline-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" value="<?= $lokasi_data['id'] ?? '' ?>" readonly>
                    </div>
                    <!-- End Col -->
                    <div class="sm:col-span-3">
                        <label for="af-account-nama" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Nama
                        </label>
                    </div>
                    <!-- End Col -->
                    <div class="sm:col-span-9">
                        <input id="af-account-nama" type="text" name="nama" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:outline-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" value="<?= $lokasi_data['nama'] ?? '' ?>">
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
                </div>
                <!-- End Grid -->
                <div class="mt-5 flex justify-end gap-x-2">
                    <button type="button" id="edit-location-btn" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-white/10 dark:hover:bg-white/20 dark:text-white dark:hover:text-white">
                        Ubah lokasi
                    </button>
                </div>
                <hr class="mt-10 border-gray-300 dark:border-white">
                <div class="mt-10 flex justify-end gap-x-2">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                        Batal
                    </button>
                    <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-900 text-teal-100 hover:bg-teal-500 disabled:opacity-50 disabled:pointer-events-none">
                        Simpan
                    </button>
                </div>
            </form>
    
        <!-- End Card -->
    </div>
    <!-- End Card Section -->
</div>

<script>
    function initMap() {

console.log("AAA")
// Get latitude and longitude from PHP variable
var latLng = '<?= ($lokasi_data['latitude'] ?? '') . ', ' . ($lokasi_data['longitude'] ?? '') ?>';
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

<?= $this->endSection(); ?>
