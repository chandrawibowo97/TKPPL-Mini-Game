<!DOCTYPE html>
<html id="page">
  <?php
    $conn = mysqli_connect("localhost", "root", "", "Music_Tap");
      $id = $_GET["playButton"];
      $result = mysqli_query($conn, "SELECT * FROM musiclist WHERE No = " . $id);
      if(mysqli_num_rows($result) > 0)
      {
        while($row = mysqli_fetch_assoc($result))
        {
          $path = $row['Path'];
          $title = $row['Title'];
          $keys = $row['Keywords'];
          $duration = $row['Duration'];
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
    <link rel="stylesheet" type="text/css" href="build/css2/PlayMusic.css">
    <script type="text/javascript">
      var counts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
      var alphaCoord = [31, -1, -1, 155, -1, 217, 279, 341, -1, 403, 465, 527, -1, -1, -1, -1, -1, -1, 93, -1, -1, -1, -1, -1, -1, -1];
      var animation1 = false;
      var min = 0;
      var myInterval = [];
      var sec = -3;
      var msec = 0;
      var charindex = 8;
      var score = 125;
      var keyVal;
      var redirect = false;
      function getMsec(string){
        var miliseconds = Number(string.substring(4, 8));
        var seconds = Number(string.substring(2, 4));
        var minutes = Number(string.substring(0, 2));
        return (60000 * minutes + 1000 * seconds + miliseconds);
      }
      function getMsec2(minutes, seconds, miliseconds){
        return (60000 * minutes + 1000 * seconds + miliseconds);
      }
      setTimeout(function(){
        generate();
      }, 1400);
      setTimeout(function(){
        document.getElementById("music").play();
      }, 3000);
      function tick(){
        if(!animation1)
        {
          animation1 = true;
          animation = setInterval(timeChange, 5);
          function timeChange(){
            msec += 5;
            if(msec > 1000)
            {
              msec -= 1000;
              sec++;
            }
            if(sec == 60)
            {
              sec = 0;
              min++;
            }
            if(sec >= 0)
              document.getElementById("time").innerHTML = min + " : " + sec;
            if(sec > endSec && min == endMin && !redirect)
            {
              redirect = true;
              window.location.href = "./Music_Tap.php#3";
            }
          }
        }
      }
      function moveDown(elId, position, childId, Id)
      {
        var pos = position;
        if(myInterval[Id] == undefined)
        {
          myInterval.push(setInterval(move, 20));
        }
        else
        {
          clearInterval(myInterval[Id]);
          myInterval[Id] = setInterval(move, 20);
        }
        function move(){
          if(pos >= 560)
          {
            clearInterval(myInterval[Id]);
            counts[document.getElementById(childId).innerHTML.charCodeAt(0) - 65]--;
            if(score - 5 < 0)
              score = 0;
            else
              score -= 5;
            document.getElementById("score").innerHTML = String(score);
            document.getElementById("Comment").innerHTML = "Missed";
            msec += 2.7;
            generateNew(Id);
          }
          else
          {
            pos += 5;
            document.getElementById(elId).style.top = pos + "px";
          }
        }
      }
      document.getElementById("page").addEventListener("keypress", function(event){
        var index = Number(event.keyCode) - 97;
        if(counts[index] > 0)
        {
          for(var i = 0; i < 25; i++)
          {
            if(document.getElementById("char" + String(i)).innerHTML.charCodeAt(0) == index + 65)
            {
              var delta = Math.abs(document.getElementById("tap" + String(i)).offsetTop - 400);
              if(delta < 50)
              {
                document.getElementById("debugging").innerHTML = "Key tapped : " + String.fromCharCode(index + 65);
                document.getElementById("tap" + String(i)).style.display = "none";
                if(delta < 10)
                {
                  document.getElementById("Comment").innerHTML = "Perfect";
                  score += 10;
                }
                else if(delta < 25)
                {
                  document.getElementById("Comment").innerHTML = "Great";
                  score += 5;
                }
                else
                {
                  document.getElementById("Comment").innerHTML = "Good";
                  score += 3;
                }
                counts[index]--;
                msec += 2.7;
                clearInterval(myInterval[i]);
                document.getElementById("score").innerHTML = String(score);
                generateNew(i);
                break;
              }
            }
            if(i == 24)
            {
              if(score - 5 < 0)
                score = 0;
              else
                score -= 5;
              document.getElementById("score").innerHTML = String(score);
            }
          }
        }
        else
        {
          if(score - 5 < 0)
            score = 0;
          else
            score -= 5;
          document.getElementById("score").innerHTML = String(score);
        }
      });

      function generate()
      {
        var upperBound = keyVal.length;
        if(keyVal > 224)
          upperBound = 25;
        else
          upperBound = (keyVal.length + 1 / 9);
        for (var i = 0; i < upperBound; i++)
        {
          document.getElementById("tap" + String(i)).style.display = "block";
          document.getElementById("tap" + String(i)).style.left = alphaCoord[ (keyVal[charindex]).charCodeAt() - 65 ] + "px";
          var temp = keyVal.substring(charindex - 8, charindex);
          var myPos = 600;
          document.getElementById("tap" + String(i)).style.top = String(myPos) + "px";
          document.getElementById("char" + String(i)).innerHTML = keyVal[charindex];
          moveDown("tap" + String(i), myPos, "char" + String(i), i);
          counts[keyVal[charindex].charCodeAt() - 65]++;
          charindex += 9;
        }
      }
      function generateNew(ind)
      {
        if(charindex < keyVal.length)
        {
          document.getElementById("tap" + String(ind)).style.display = "block";
          document.getElementById("tap" + String(ind)).style.left = alphaCoord[ (keyVal[charindex]).charCodeAt() - 65 ] + "px";
          var temp = keyVal.substring(charindex - 8, charindex);
          var myPos = 400 - Math.abs(getMsec(temp) - getMsec2(min, sec, msec)) * 0.251;
          document.getElementById("tap" + String(ind)).style.top = String(myPos) + "px";
          document.getElementById("char" + String(ind)).innerHTML = keyVal[charindex];
          moveDown("tap" + String(ind), myPos, "char" + String(ind), ind);
          counts[keyVal[charindex].charCodeAt() - 65]++;
          charindex += 9;
        }
        else
        {
          document.getElementById("char" + String(ind)).innerHTML = " ";
          document.getElementById("tap" + String(ind)).display = "none";
        }
      }
      tick();
    </script>
  </head>
  <body>
    <article>
      <section>
        <div id="dur" style="display: none;"><?php echo $duration; ?></div>
        <input id="myKey" type="hidden" value= <?php echo "\"" . $keys . "\""; ?> >
        <div id="ScoreContent">Score : <span id="score">0</span></div>
        <form id="ScoreForm" action="./Scoring.php" method="GET"><input type="hidden" name="musicID" value=<?php echo "\"" . $id . "\""; ?> ><input type="hidden" name="myScore" value="0"></form>
        <div id="time">0 : 0</div>
        <audio id="music">
          <source src = <?php echo "\"" . $path . "\""; ?> type="audio/mpeg">
        </audio>
        <div id="keyBar"></div>
        <div class="tap" id="tap0"><div id="char0">A</div></div>
        <div class="tap" id="tap1"><div id="char1"></div></div>
        <div class="tap" id="tap2"><div id="char2"></div></div>
        <div class="tap" id="tap3"><div id="char3"></div></div>
        <div class="tap" id="tap4"><div id="char4"></div></div>
        <div class="tap" id="tap5"><div id="char5"></div></div>
        <div class="tap" id="tap6"><div id="char6"></div></div>
        <div class="tap" id="tap7"><div id="char7"></div></div>
        <div class="tap" id="tap8"><div id="char8"></div></div>
        <div class="tap" id="tap9"><div id="char9"></div></div>
        <div class="tap" id="tap10"><div id="char10"></div></div>
        <div class="tap" id="tap11"><div id="char11"></div></div>
        <div class="tap" id="tap12"><div id="char12"></div></div>
        <div class="tap" id="tap13"><div id="char13"></div></div>
        <div class="tap" id="tap14"><div id="char14"></div></div>
        <div class="tap" id="tap15"><div id="char15"></div></div>
        <div class="tap" id="tap16"><div id="char16"></div></div>
        <div class="tap" id="tap17"><div id="char17"></div></div>
        <div class="tap" id="tap18"><div id="char18"></div></div>
        <div class="tap" id="tap19"><div id="char19"></div></div>
        <div class="tap" id="tap20"><div id="char20"></div></div>
        <div class="tap" id="tap21"><div id="char21"></div></div>
        <div class="tap" id="tap22"><div id="char22"></div></div>
        <div class="tap" id="tap23"><div id="char23"></div></div>
        <div class="tap" id="tap24"><div id="char24"></div></div>
        <div id="Comment" style="position: absolute; bottom: 0; right: 0;"></div>
        <div id="debugging" style="position: absolute; bottom:0; left: 0;">Key tapped : </div>
        <div></div>
      </section>
    </article>
  </body>
  <script src="build/build.js"></script>
  <script src="build/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="build/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    keyVal = document.getElementById("myKey").value;
    var endTime = document.getElementById("dur").innerHTML;
    var endMin = Number(endTime[0]) * 10 + Number(endTime[1]);
    var endSec =  Number(endTime[3]) * 10 + Number(endTime[4]);
  </script>
</html>
<!--  -->