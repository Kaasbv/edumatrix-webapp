<h2>Coming soon<span id="dots"></span></h2>
<script>
  var currentDots = 0;
  var maxDots = 3;

  setInterval(() => {
    currentDots = currentDots < maxDots ? currentDots+1 : 0;
    let dots = "";
    for(let index = 0; index < currentDots; index++){
      dots += ".";
    }
    document.querySelector("#dots").innerHTML = dots;
  }, 500);
</script>