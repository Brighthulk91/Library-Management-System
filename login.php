<?php
require_once 'config.php';
require_once 'helpers.php';
if(is_logged_in()) redirect('dashboard.php');

$errors=[];

if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=trim($_POST['email']);
  $password=$_POST['password'];
  if(!$email || !$password) $errors[]='All fields required';

  if(empty($errors)){
    $stmt=$conn->prepare("SELECT id,username,email,password,role FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $res=$stmt->get_result();
    if($user=$res->fetch_assoc()){
      if(password_verify($password,$user['password'])){
        $_SESSION['user']=$user;
        redirect('dashboard.php');
      } else $errors[]='Invalid credentials';
    } else $errors[]='User not found';
  }
}
include 'partials/header.php';
?>
<div class="max-w-md mx-auto">
    <div class="bg-white/5 border border-white/10 backdrop-blur-xl p-8 rounded-3xl shadow-2xl">
        <h2 class="font-display text-3xl text-neonCyan mb-6 text-center">System Login</h2>
        
        <?php foreach($errors as $err): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-4 rounded-xl mb-6 text-sm">
                <?php echo e($err); ?>
            </div>
        <?php endforeach; ?>

        <form method="post" class="space-y-4">
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Email Address</label>
                <input type="email" name="email" placeholder="name@example.com" required
                    class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-neonCyan focus:ring-1 focus:ring-neonCyan outline-none transition">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Password</label>
                <input type="password" name="password" placeholder="••••••••" required
                    class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-neonCyan focus:ring-1 focus:ring-neonCyan outline-none transition">
            </div>
            <button type="submit" class="w-full bg-neonCyan text-black font-black py-4 rounded-xl hover:brightness-110 hover:shadow-neon transition active:scale-95">
                AUTHORIZE
            </button>
        </form>
        <p class="mt-6 text-center text-sm text-gray-500">
            Need an account? <a href="register.php" class="text-neonCyan hover:underline">Register here</a>
        </p>
    </div>
</div>
<?php include 'partials/footer.php'; ?>