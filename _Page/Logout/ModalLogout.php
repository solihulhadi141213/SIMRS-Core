<!-- Modal Logout -->
<div class="modal fade" id="ModalLogout" tabindex="-1" aria-labelledby="ModalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form action="_Page/Logout/ProsesLogout.php" method="POST">
                <!-- Header -->
                <div class="modal-header text-dark">
                    <h5 class="modal-title" id="ModalLogoutLabel">
                        <i class="ti-lock"></i> Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="assets/images/question.gif" class="img-fluid mb-3" alt="Konfirmasi Logout">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="alert alert-danger">
                                <b>Apakah anda yakin ingin keluar dari akun ini?</b>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-md btn-round">
                        <i class="ti-check"></i> Ya, Logout
                    </button>
                    <button type="button" class="btn btn-dark btn-md btn-round" data-bs-dismiss="modal">
                        <i class="ti-close"></i> Tidak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>