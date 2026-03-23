<?php
    date_default_timezone_set('UTC');
    //Koneksi
    include "../../_Config/Connection.php";
    //Menangkap id bridging
    if(empty($_POST['id_bridging'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Bridging Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_bridging=$_POST['id_bridging'];
        //Membuka data profile brdiging
        $QryBridging = mysqli_query($Conn,"SELECT * FROM bridging WHERE id_bridging='$id_bridging'")or die(mysqli_error($Conn));
        $DataBridging = mysqli_fetch_array($QryBridging);
        $id_bridging= $DataBridging['id_bridging'];
        $nama_bridging= $DataBridging['nama_bridging'];
        $consid= $DataBridging['consid'];
        $user_key= $DataBridging['user_key'];
        $secret_key= $DataBridging['secret_key'];
        $kode_ppk= $DataBridging['kode_ppk'];
        $url_vclaim= $DataBridging['url_vclaim'];
        $url_aplicare= $DataBridging['url_aplicare'];
        $url_faskes= $DataBridging['url_faskes'];
        $status= $DataBridging['status'];
        //Signature&timestamp
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $consid."&".$tStamp, $secret_key, true);
        // base64 encode…
        $encodedSignature = base64_encode($signature);
        // urlencodedSignature
        $urlencodedSignature = urlencode($encodedSignature);

?>
    <form action="javascript:void(0);" method="POST" id="ProsesConsol" autocomplete="off">
        <div class="modal-body p-0">
            <div class="card-body border-0 pb-0">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label for="base_url"><dt>URL</dt></label>
                        <input type="text" name="url" id="url" class="form-control" list="url_list">
                        <datalist id="url_list">
                            <option value="<?php echo "$url_vclaim"; ?>">
                            <option value="<?php echo "$url_aplicare"; ?>">
                            <option value="<?php echo "$url_faskes"; ?>">
                        </datalist>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <label for="consid"><dt>consid</dt></label>
                        <input type="text" name="consid" id="consid" class="form-control" value="<?php echo "$consid"; ?>">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="user_key"><dt>user_key</dt></label>
                        <input type="text" name="user_key" id="user_key" class="form-control" value="<?php echo "$user_key"; ?>">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="secret_key"><dt>secret_key</dt></label>
                        <input type="text" name="secret_key" id="secret_key" class="form-control" value="<?php echo "$secret_key"; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <label for="kode_ppk"><dt>kode_ppk</dt></label>
                        <input type="text" name="kode_ppk" id="kode_ppk" class="form-control" value="<?php echo "$kode_ppk"; ?>">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="timestamp"><dt>X-timestamp</dt></label>
                        <input type="text" name="timestamp" id="timestamp" class="form-control" value="<?php echo "$tStamp"; ?>">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label for="method"><dt>Method</dt></label>
                        <select name="method" id="method" class="form-control">
                            <option value="POST">POST</option>
                            <option value="GET">GET</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label for="signature"><dt>X-signature</dt></label>
                        <input type="text" name="signature" id="signature" class="form-control" list="signatureList">
                        <datalist id="signatureList">
                            <option value="<?php echo "$encodedSignature"; ?>">
                            <option value="<?php echo "$urlencodedSignature"; ?>">
                            <option value="<?php echo "$signature"; ?>">
                        </datalist>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <label for="request"><dt>Request</dt></label>
                        <textarea name="request" id="request" class="form-control" cols="30" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3 mb-4">
                        <label for="response"><dt>Response</dt></label>
                        <div id="GetResponse" class="pre-scrollable"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-inverse">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-md btn-primary mt-2 ml-2">
                        <i class="icofont-play-alt-3"></i> Start Connect
                    </button>
                    <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">
                        <i class="ti-close"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </form>
<?php } ?>