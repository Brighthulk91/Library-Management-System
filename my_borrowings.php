<?php
require_once 'config.php';
require_once 'helpers.php';
require_member();
$user=$_SESSION['user'];

$stmt=$conn->prepare("SELECT br.*,b.title,b.author FROM borrowings br JOIN books b ON br.book_id=b.id WHERE br.member_id=? ORDER BY br.borrow_date DESC");
$stmt->bind_param("i",$user['id']);
$stmt->execute();
$res=$stmt->get_result();
$my_borrows=$res->fetch_all(MYSQLI_ASSOC);

include 'partials/header.php';
?>

<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="font-display text-4xl text-white tracking-tighter">My <span class="text-neonPurple">Active Collection</span></h2>
        <a href="books.php" class="inline-flex items-center text-xs font-bold text-neonCyan hover:underline">
            ← BACK TO ARCHIVES
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach($my_borrows as $b): ?>
            <div class="bg-white/5 border border-white/10 p-6 rounded-3xl relative overflow-hidden group hover:border-neonPurple/50 transition duration-300">
                <div class="absolute top-4 right-4">
                    <?php if($b['status'] === 'borrowed'): ?>
                        <div class="flex items-center gap-2 text-neonOrange">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neonOrange opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-neonOrange"></span>
                            </span>
                            <span class="text-[10px] font-black uppercase tracking-tighter">In Your Possession</span>
                        </div>
                    <?php else: ?>
                        <span class="text-gray-600 text-[10px] font-black uppercase tracking-tighter italic">Returned</span>
                    <?php endif; ?>
                </div>

                <div class="mt-4">
                    <h3 class="text-xl font-bold text-white leading-tight mb-1"><?php echo e($b['title']); ?></h3>
                    <p class="text-gray-500 text-sm mb-6"><?php echo e($b['author']); ?></p>
                    
                    <div class="pt-4 border-t border-white/5 flex justify-between items-end">
                        <div>
                            <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest">Issued On</p>
                            <p class="text-sm text-gray-300 font-mono"><?php echo date('Y-m-d', strtotime($b['borrow_date'])); ?></p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] text-gray-600 font-bold uppercase tracking-widest">ID</p>
                            <p class="text-sm text-gray-300 font-mono">#<?php echo e($b['id']); ?></p>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-neonPurple/5 rounded-full blur-3xl group-hover:bg-neonPurple/10 transition"></div>
            </div>
        <?php endforeach; ?>

        <?php if(empty($my_borrows)): ?>
            <div class="col-span-full py-20 bg-white/5 border border-dashed border-white/10 rounded-3xl text-center">
                <p class="text-gray-500 italic">You haven't borrowed any volumes yet.</p>
                <a href="books.php" class="mt-4 inline-block text-neonCyan font-bold uppercase text-xs tracking-widest hover:text-white transition">Explore Library</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'partials/footer.php'; ?>