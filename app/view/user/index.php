<html>
  <body>
  <?php
  if (isset($data['info'])){
    echo "<h2>Infomation:".$data['info']."</h2>";
  }
  if (isset($data['body'])){
    echo "<table>";
    foreach ($data['body'] as &$value) {
      echo "<tr>";
      foreach ($value as $k => $v) {
        echo "<td>" . $v . "</td>" ;   
      }
      if (isset($_SESSION['type'])) {
        if ($_SESSION['type']=="admin") {
          echo "<td><a href='./?url=user/update/".$value["id"]."'>edit</a></td>";
          echo "<td><a href='./?url=user/deleted/".$value["id"]."'>deleted</a></td>";
        } elseif ($_SESSION['user']==$value["name"]) {
          echo "<td><a href='./?url=user/update/".$value["id"]."'>edit</a></td>";
        }
      }
      echo"</tr>";
    }
    echo "</table>";
  }
  if (!isset($_SESSION['user'])) {
	 print ('Welcome, please login:<hr><a href="./?url=user/insert">register</a>
	 <a href="./?url=user/login">login</a>');
  } else {
    print('<a href="./?url=user/logout">log out</a>');
  }
  ?>
  </body>
</html>