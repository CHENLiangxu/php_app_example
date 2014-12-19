<html>
  <body>
    <?php
    var_dump($data);
    $name=$data['body']['name'];
    $age=$data['body']['age'];
    $id=$data['body']['id'];
    $birthday=$data['body']['birthday'];
	if ($_SERVER['REQUEST_METHOD']=="GET") {
	?>
		<h2>update</h2>
		<form action="./?url=user/update/"<?php echo $id; ?> method="post">
		  <div>name: <input type="text" name="name" value=<?php echo $name; ?> required></div>
		  <div>age: <input type='number' name='age' value=<?php echo $age; ?>></div>
		  <div>birthday: <input type='date' name='birthday' value=<?php echo $birthday; ?>></div>
		  <input type='hidden' name='id' value=<?php echo $id; ?> >
		  <div><input type='submit' value='Add'></div>
		</form>
	<?php }
	?>
  </body>
 </html>