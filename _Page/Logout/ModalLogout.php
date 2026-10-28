<!-- Modal Logout -->
<div class="modal fade" id="ModalLogout" tabindex="-1" aria-labelledby="ModalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form action="_Page/Logout/ProsesLogout.php" method="POST">
                <!-- Header -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title" id="ModalLogoutLabel">
                        <i class="bi bi-lock"></i> Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body text-center">
                    <i class="bi bi-box-arrow-right display-4 text-danger mb-3" aria-hidden="true"></i>
                    <p class="h5"><strong>Anda yakin ingin logout?</strong></p>
                    <p>Pastikan semua data telah disimpan sebelum melanjutkan.</p>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-md btn-round">
                        <i class="bi bi-check"></i> Ya, Logout
                    </button>
                    <button type="button" class="btn btn-dark btn-md btn-round" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>