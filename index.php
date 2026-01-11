<?php
require_once 'helpers.php';
include 'partials/header.php';
?>
<div class="flex flex-col items-center justify-center min-h-[60vh] text-center space-y-8">
  <div class="space-y-4">
    <h1 class="font-display text-5xl md:text-6xl text-white tracking-tighter">
      Welcome to <span class="text-neonCyan">ArghyaLibrary</span>
    </h1>
    <p class="text-gray-400 max-w-lg mx-auto text-lg">
      The next generation of library management. Librarians control the inventory; members explore the knowledge.
    </p>
  </div>

  <div class="flex flex-wrap justify-center gap-4">
    <?php if(!is_logged_in()): ?>
      <a href="register.php" class="px-8 py-4 bg-neonCyan text-black font-bold rounded-2xl hover:scale-105 transition transform shadow-neon">
        GET STARTED
      </a>
      <a href="login.php" class="px-8 py-4 bg-white/5 border border-white/10 text-white font-bold rounded-2xl hover:bg-white/10 transition">
        MEMBER LOGIN
      </a>
    <?php else: ?>
      <a href="dashboard.php" class="px-10 py-4 bg-neonPurple text-black font-bold rounded-2xl hover:scale-105 transition transform shadow-lg">
        GO TO DASHBOARD
      </a>
    <?php endif; ?>
  </div>
</div>
<?php include 'partials/footer.php'; ?>