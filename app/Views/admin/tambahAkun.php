<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<!-- Card Section -->
<div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                Profil
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Tambahkan akun
            </p>
        </div>

        <form id="addAccountForm" action="/submittambahakun" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <!-- Grid -->
            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Foto Profil
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <div class="flex items-center gap-5">
                        <img id="preview-image" class="inline-block size-16 rounded-full ring-2 ring-white dark:ring-gray-800" alt="Image Description">
                        <div class="max-w-sm">
                            <label class="block">
                                <span class="sr-only">Ubah profil foto</span>
                                <input id="profilePhoto" name="profilePhoto" type="file" accept=".jpg, .png" class="block w-full text-sm text-gray-500
                        file:me-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-teal-600 file:text-white
                        hover:file:bg-teal-700
                        file:disabled:opacity-50 file:disabled:pointer-events-none
                        dark:text-neutral-500
                        dark:file:bg-teal-500
                        dark:hover:file:bg-teal-400">
                            </label>
                        </div>
                    </div>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-3">
                    <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Email
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <input id="af-account-email" name="email" type="email" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="budi@fathoor.dev" required>
                    <div id="emailError" class="text-sm text-red-500 hidden">Email harus diisi dan harus valid.</div>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-3">
                    <label for="af-account-password" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        Password
                    </label>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <div class="space-y-2">
                        <input id="af-account-password" name="password" type="password" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Masukkan Password" required>
                        <div id="passwordError" class="text-sm text-red-500 hidden">Password harus diisi.</div>
                    </div>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-3">
                    <div class="inline-block">
                        <label for="af-account-phone" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            Role
                        </label>
                    </div>
                </div>
                <!-- End Col -->

                <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <select id="role" name="role" class="py-2 px-3 pe-9 block w-full sm:w-auto border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-teal-500 focus:ring-teal-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required>
                            <option value="">Pilih Role</option>
                            <?php foreach ($userData as $role) : ?>
                                <option value="<?= $role['id']; ?>"><?= $role['id']; ?> (<?= $role['nama']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <div id="roleError" class="text-sm text-red-500 hidden">Role harus dipilih.</div>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Grid -->

            <div class="mt-5 flex justify-end gap-x-2">
                <a href="javascript:history.back()">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        Batal
                    </button>
                </a>

                <button type="submit" id="submitButton" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    Tambah Akun
                </button>
            </div>
        </form>
    </div>
    <!-- End Card -->
</div>
<!-- End Card Section -->

<script>
    document.getElementById('profilePhoto').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var img = document.getElementById('preview-image');
            img.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    });

    function validateForm() {
        var email = document.getElementById('af-account-email').value;
        var password = document.getElementById('af-account-password').value;
        var role = document.getElementById('role').value;
        var valid = true;

        if (email.trim() === '' || !isValidEmail(email)) {
            document.getElementById('emailError').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('emailError').classList.add('hidden');
        }

        if (password.trim() === '') {
            document.getElementById('passwordError').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('passwordError').classList.add('hidden');
        }

        if (role === '') {
            document.getElementById('roleError').classList.remove('hidden');
            valid = false;
        } else {
            document.getElementById('roleError').classList.add('hidden');
        }

        return valid;
    }

    function isValidEmail(email) {
        // Basic email validation regex
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
</script>

<?= $this->endSection(); ?>