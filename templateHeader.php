<header>
    <h1 onclick="location.href='./dashboard.php'">Mines Match</h1>
    <p>The online dating service for geeks, by geeks.</p>
    <nav>
        <a <?php if( !is_active('dashboard') ) { echo('href="'. $path_to_home . 'dashboard.php"'); }?> class="<?php if(is_active('dashboard')) {echo 'active-pg';}?>">Match Dashboard</a>
        <a <?php if( !is_active('my_profile') ) { echo('href="'. $path_to_home . 'my_profile.php"'); }?> class="<?php if(is_active('my_profile')) {echo 'active-pg';}?>">My Profile</a>
        <a onclick="logout()">Sign Out</a>
    </nav>
</header>

<script>
    function logout() {
        alert("Logout! Not yet implemented.");
    }
</script>

<?php
function is_active($page_name='') {
    global $current_page;
    if ($page_name==$current_page) {
        return true;
    } else {
        return false;
    }
}
?>