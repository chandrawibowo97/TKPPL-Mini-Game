<!DOCTYPE html>
<html id="page">
  <?php
    $conn = mysqli_connect("localhost", "root", "", "Music_Tap");
      $id = $_GET["ID"];
      $result = mysqli_query($conn, "SELECT * FROM musiclist WHERE No = " . $id);
      if(mysqli_num_rows($result) > 0)
      {
        while($row = mysqli_fetch_assoc($result))
        {
          $path = $row['Path'];
          $title = $row['Title'];
        }
      }
      else
        echo "(There is no music found)";
  ?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Music Tap - <?php echo $title; ?> </title>
    <link rel="stylesheet" type="text/css" href="build/build.css">
    <link rel="stylesheet" type="text/css" href="build/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="build/css2/SetMusic.css">
    <script type="text/javascript">
      var animation;
      var animation1 = false;
      var min = 0;
      var sec = 0;
      var msec = 0;
      function twoDigit(integer){
        if(integer < 10)
          return "0" + String(integer);
        return String(integer);
      }
      function fourDigit(integer){
        if(integer < 1000)
          return "0" + String(integer);
        else if(integer < 100)
          return "00" + String(integer);
        else if(integer < 10)
          return "000" + String(integer);
        return String(integer);
      }
      document.getElementById("page").addEventListener("keypress", function(event){
        var temp = String.fromCharCode(event.keyCode)
        document.getElementById("hiddenText").value += twoDigit(min) + twoDigit(sec) + fourDigit(msec);
        document.getElementById("hiddenText").value += temp;
        document.getElementById("debugging").innerHTML = document.getElementById("hiddenText").value;
      });
      function tick(){
        if(!animation1)
        {
          animation1 = true;
          var elem = document.getElementById("time");
          animation = setInterval(timeChange, 5);
          function timeChange(){
            msec += 5;
            if(msec >= 1000)
            {
              msec -= 1000;
              sec++;
            }
            if(sec == 60)
            {
              sec = 0;
              min++;
            }
            elem.innerHTML = min + " : " + sec;
          }
        }
      }
      function stopTick(){
        animation1 = false;
        clearInterval(animation);
      }
      function playMusic(){
        document.getElementById("audioBar").play();
        tick();
      }
      function pauseMusic(){
        document.getElementById("audioBar").pause();
        stopTick();
      }
      function stopMusic(){
        stopTick();
        document.getElementById("audioBar").pause();
        document.getElementById("audioBar").currentTime = 0;
        min = 0;
        sec = 0;
        msec = 0;
        document.getElementById("time").innerHTML = min + " : " + sec;
      }
    </script>
  </head>
  <body>
    <article>
      <section>
        <audio id="audioBar" controls>
          <source src=<?php echo "\"" . $path . "\"" ?>type="audio/mpeg">
        </audio>
        <div id="time" onclick="tick()">0 : 0</div>
        <button class="btn btn-primary" onclick="playMusic()">Play</button>
        <button class="btn btn-info" onclick="pauseMusic()">Pause</button>
        <button class="btn btn-warning" onclick="stopMusic()">Stop</button>
        <form action = "./SubmitKey.php" method = "GET">
          <input type="hidden" name="key" id="hiddenText" value="">
          <input type="hidden" name="id" value= <?php echo "\"" . $id . "\""; ?> >
          <button type="submit" class="btn btn-success">Finished</button>
        </form>
        <p id="debugging"></p>
      </section>
    </article>
  </body>
  <script src="build/build.js"></script>
  <script src="build/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="build/js/bootstrap.min.js"></script>
</html>