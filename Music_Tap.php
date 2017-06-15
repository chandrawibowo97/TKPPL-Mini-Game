<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Music Tap</title>
    <link rel="stylesheet" type="text/css" href="build/build.css">
    <link rel="stylesheet" type="text/css" href="build/css2/Music_Tap.css">

    <script type="text/javascript">
      var animation1 = false;
      function animateText(obj)
      {
        if(!animation1)
        {
          animation1 = true;
          var elem = obj;
          var elem2 = document.getElementById("showLater");
          var size = 25;
          var opacity = 1.0;
          var animation = setInterval(enlarge, 10);
          function enlarge()
          {
            if(opacity <= 0.0)
            {
              elem.style.border = "none";
              elem.innerHTML = " ";
              elem.style.cursor = "none";
              elem2.style.display = "block";
              clearInterval(animation);
            }
            elem.style.fontSize = size + 'px';
            size++;
            elem.style.color = "rgba(255, 255, 255, " + opacity + ")";
            elem.style.backgroundColor = "rgba(0, 0, 128, " + opacity * 0.5 + ")";
            elem.style.borderRadius = "1px solid rgba(0, 0, 128, " + opacity + ")";
            opacity = opacity - 0.02;
          }
        }
      }
  </script>
  </head>
  <body>
    <article>
      <section>
        <h2>Play Music Tap</h2>
        <h3 id = "text" onclick="animateText(this)">Select Music</h2>
        <?php
          session_start();
          $conn = mysqli_connect("localhost", "root", "", "music_tap");
          $result = mysqli_query($conn, "SELECT * FROM musiclist");
          echo "<div id=\"showLater\" class=\"table-responsive\" style=\"display: none;\"><table>";
          if(mysqli_num_rows($result) > 0)
          {
            $i = 1;
            echo "<thead><tr><th>Title</th><th>Duration</th><th>Difficulty</th><th></th></tr></thead>";
            while($row = mysqli_fetch_assoc($result))
            {
              echo "<tr class=\"musicRecord\"><td><form action=\"./PlayMusic.php\" method=\"GET\"><button id=\"title\" type=\"submit\" name=\"playButton\" value=\"" . $i . "\">" . $row["Title"] . "</button></form></td><td>" . $row["Duration"] . "</td><td>" . $row["Difficulty"] . "</td><td><form action=\"./SetMusic.php\" method=\"GET\"><button id=\"settingButton\" type=\"submit\" name=\"ID\" value=\"" . $i . "\" class=\"btn\"></button></form></td></tr>";
              $i++;
            }
          }
          else
            echo "(There is no music registered)";
          echo "</table></div>";
        ?>
      </section>
      <section>
        <h2>High Score</h2>
      </section>
    </article>
  </body>
  <script src="build/build.js"></script>
  <script src="build/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="build/js/bootstrap.min.js"></script>
</html>