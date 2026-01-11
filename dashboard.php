<?php
require_once 'helpers.php';
require_login();
$user = $_SESSION['user'];
include 'partials/header.php';
?>
<div class="space-y-10">
    <div class="bg-white/5 border border-white/10 p-10 rounded-3xl text-center relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="font-display text-4xl text-white mb-2 italic">Welcome Back, <?php echo e($user['username']); ?>!</h1>
            <p class="text-neonPurple font-bold uppercase tracking-widest text-sm">Session Type: <?php echo e(ucfirst($user['role'])); ?></p>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-neonPurple/10 rounded-full blur-3xl"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if($user['role'] === 'librarian'): ?>
            <a href="manage_books.php" class="group p-8 bg-white/5 border border-white/10 rounded-2xl hover:border-neonCyan transition shadow-lg">
                <div class="text-neonCyan mb-4 text-3xl font-display">01.</div>
                <h3 class="text-xl font-bold text-white mb-2">Inventory Management</h3>
                <p class="text-sm text-gray-500">Update, delete, or modify existing book metadata.</p>
            </a>
            <a href="add_book.php" class="group p-8 bg-white/5 border border-white/10 rounded-2xl hover:border-neonGreen transition shadow-lg">
                <div class="text-neonGreen mb-4 text-3xl font-display">02.</div>
                <h3 class="text-xl font-bold text-white mb-2">Acquisition</h3>
                <p class="text-sm text-gray-500">Register new volumes into the database.</p>
            </a>
            <a href="borrowings.php" class="group p-8 bg-white/5 border border-white/10 rounded-2xl hover:border-neonOrange transition shadow-lg">
                <div class="text-neonOrange mb-4 text-3xl font-display">03.</div>
                <h3 class="text-xl font-bold text-white mb-2">Borrow History</h3>
                <p class="text-sm text-gray-500">View all active and past transactions.</p>
            </a>
        <?php else: ?>
            <a href="books.php" class="group p-8 bg-white/5 border border-white/10 rounded-2xl hover:border-neonCyan transition shadow-lg">
                <div class="text-neonCyan mb-4 text-3xl font-display">01.</div>
                <h3 class="text-xl font-bold text-white mb-2">Browse Archives</h3>
                <p class="text-sm text-gray-400">Search and borrow from our full collection.</p>
            </a>
            <a href="my_borrowings.php" class="group p-8 bg-white/5 border border-white/10 rounded-2xl hover:border-neonPurple transition shadow-lg">
                <div class="text-neonPurple mb-4 text-3xl font-display">02.</div>
                <h3 class="text-xl font-bold text-white mb-2">Active Borrows</h3>
                <p class="text-sm text-gray-400">Track books you currently have or need to return.</p>
            </a>
        <?php endif; ?>
        
        <a href="gallery.php" class="group p-8 bg-white/5 border border-white/10 rounded-2xl hover:border-neonYellow transition shadow-lg">
            <div class="text-neonYellow mb-4 text-3xl font-display">04.</div>
            <h3 class="text-xl font-bold text-white mb-2">Visual Gallery</h3>
            <p class="text-sm text-gray-400">View book cover assets and visual records.</p>
        </a>
    </div>
</div>
<?php include 'partials/footer.php'; ?>