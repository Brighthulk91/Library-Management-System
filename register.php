<?php
require_once 'config.php';
require_once 'helpers.php';
if(is_logged_in()) redirect('dashboard.php');

$errors=[];

if($_SERVER['REQUEST_METHOD']==='POST'){
  $username=trim($_POST['username']);
  $email=trim($_POST['email']);
  $password=$_POST['password'];
  $role=$_POST['role'];

  if(!$username) $errors[]='Username required';
  if(!$email) $errors[]='Email required';
  if(!$password) $errors[]='Password required';
  if(!in_array($role,['librarian','member'])) $errors[]='Invalid role';

  if(empty($errors)){
    $stmt=$conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows>0){
      $errors[]='Email already registered';
    } else {
      $hashed=password_hash($password,PASSWORD_DEFAULT);
      $stmt2=$conn->prepare("INSERT INTO users (username,email,password,role) VALUES (?,?,?,?)");
      $stmt2->bind_param("ssss",$username,$email,$hashed,$role);
      if($stmt2->execute()){
        redirect('login.php');
      } else $errors[]='Registration failed';
    }
  }
}
include 'partials/header.php';
?>
<div class="card center-form">
  <h2>Register</h2>
  <?php foreach($errors as $err): ?>
    <div class="error"><?php echo e($err); ?></div>
  <?php endforeach; ?>
  <form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="role">
      <option value="member">Member</option>
      <option value="librarian">Librarian</option>
    </select>
    <button type="submit">Register</button>
  </form>
</div>
<?php include 'partials/footer.php'; ?>
