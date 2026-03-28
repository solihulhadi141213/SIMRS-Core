<?php
    if(empty($SessionGambar)){
        $LinkGambar="avatar-blank.jpg";
    }else{
        $LinkGambar="user/$SessionGambar";
    }
?>
<li class="user-profile header-notification">
    <a href="javascript:void(0);" class="waves-effect waves-light">
        <img src="assets/images/<?php echo $LinkGambar;?>" class="img-radius" alt="User-Profile-Image">
        <span><?php echo $SessionNama;?></span>
        <i class="ti-angle-down"></i>
    </a>
    <ul class="show-notification profile-notification">
        <li class="waves-effect waves-light">
            <a href="index.php?Page=ProfileUser&Sub=MyProfile">
                <i class="ti-user"></i> Profile
            </a>
        </li>
        <li class="waves-effect waves-light">
            <a href="index.php?Page=ProfileUser&Sub=LaporanPengguna">
                <i class="ti-email"></i> Laporan Pengguna
            </a>
        </li>
        <li class="waves-effect waves-light">
            <a href="index.php?Page=ProfileUser&Sub=MyLog">
                <i class="ti-time"></i> Log Aktivitas
            </a>
        </li>
        <li class="waves-effect waves-light">
            <a href="index.php?Page=Help">
                <i class="icofont-question-circle"></i></i> Bantuan
            </a>
        </li>
        <li class="waves-effect waves-light">
            <a href="javascript:void(0);" class="p p-3" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                <i class="ti-lock"></i> Logout
            </a>
        </li>
    </ul>
</li>