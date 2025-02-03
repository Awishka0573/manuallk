<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../manuallk/assets/css/ind.css">
    <link rel="stylesheet" href="../manuallk/assets/css/nav.css">
    <title>Manuallk</title>
    <script>
function initComparisons() {
  var x, i;
  x = document.getElementsByClassName("img-comp-overlay");
  for (i = 0; i < x.length; i++) {
    compareImages(x[i]);
  }
  function compareImages(img) {
    var slider, img, clicked = 0, w, h;
    w = img.offsetWidth;
    h = img.offsetHeight;
    img.style.width = (w / 2) + "px";
    slider = document.createElement("DIV");
    slider.setAttribute("class", "img-comp-slider");
    img.parentElement.insertBefore(slider, img);
    slider.style.top = (h / 2) - (slider.offsetHeight / 2) + "px";
    slider.style.left = (w / 2) - (slider.offsetWidth / 2) + "px";
    slider.addEventListener("mousedown", slideReady);
    window.addEventListener("mouseup", slideFinish);
    slider.addEventListener("touchstart", slideReady);
    window.addEventListener("touchend", slideFinish);
    function slideReady(e) {
      e.preventDefault();
      clicked = 1;
      window.addEventListener("mousemove", slideMove);
      window.addEventListener("touchmove", slideMove);
    }
    function slideFinish() {
      clicked = 0;
    }
    function slideMove(e) {
      var pos;
      
      if (clicked == 0) return false;
      pos = getCursorPos(e)
      if (pos < 0) pos = 0;
      if (pos > w) pos = w;
      slide(pos);
    }
    function getCursorPos(e) {
      var a, x = 0;
      e = (e.changedTouches) ? e.changedTouches[0] : e;
      a = img.getBoundingClientRect();
      x = e.pageX - a.left;
      x = x - window.pageXOffset;
      return x;
    }
    function slide(x) {
      img.style.width = x + "px";
      slider.style.left = img.offsetWidth - (slider.offsetWidth / 2) + "px";
    }
  }
}
</script>
<style>* {box-sizing: border-box;}

.img-comp-container {
  position: relative;
  height: 200px; 
}

.img-comp-img {
  position: absolute;
  width: auto;
  height: auto;
  overflow:hidden;
}

.img-comp-img img {
  display:block;
  /* vertical-align:middle; */
}

.img-comp-slider {
  position: absolute;
  z-index:9;
  cursor: ew-resize;
  /*set the appearance of the slider:*/
  width: 40px;
  height: 40px;
  background-color:rgb(31, 140, 223) ;
  opacity: 0.7;
  border-radius: 50%;
}
.move{
    display: flex;
    padding-top: 50px;
    padding-left: 700px;

}</style>
</head>

<body>
<?php
    include('../manuallk/partials/navbar.php');
    ?>
    <div class="move">
<div class="img-comp-container">
  <div class="img-comp-img">
    <img src="../manuallk/assets/images/r34.png" width="600" height="400">
  </div>
  <div class="img-comp-img img-comp-overlay">
    <img src="../manuallk/assets/images/photo-1493238792000-8113da705763.png" width="600" height="400">
  </div>
</div>
</div>
<script>
initComparisons();
</script>



</body>
</html>