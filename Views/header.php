<a href="/" class="left-side"><img src="/images/edulogo_transparent.png" alt= "Edumatrix logo" id="edulogo"></a> 
<a href="/site/wip" class="right-side"><img src="https://icons.getbootstrap.com/icons/power.svg" alt= "Logout button" id="logout"></a>
<a href="/site/wip" class="right-side" id ="profileLink"><img src="https://icons.getbootstrap.com/icons/person-square.svg" alt= "Profiel link" id="profile"> <?= Session::$user ? Session::$user->voornaam : "Mijn profiel" ?></a>