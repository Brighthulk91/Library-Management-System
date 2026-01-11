<?php
require_once 'config.php';
require_once 'helpers.php';
require_member();
$user=$_SESSION['user'];

$stmt=$conn->prepare("SELECT b.*,u.username AS librarian FROM books b JOIN users u ON b.librarian_id=u.id ORDER BY b.created_at DESC");
$stmt->execute();
$res=$stmt->get_result();
$books=$res->fetch_all(MYSQLI_ASSOC);

include 'partials/header.php';
?>
<div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
    <div class="p-8 border-b border-white/10 flex justify-between items-center bg-white/[0.02]">
        <h2 class="font-display text-3xl text-neonCyan tracking-tight">Available Archives</h2>
        <span class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Global Collection</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-black/50 text-[10px] font-bold uppercase text-gray-500 tracking-[0.2em]">
                <tr>
                    <th class="px-8 py-5">Volume Title</th>
                    <th class="px-8 py-5">Author</th>
                    <th class="px-8 py-5">Category</th>
                    <th class="px-8 py-5">Stock</th>
                    <th class="px-8 py-5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                <?php foreach($books as $b): ?>
                    <tr class="hover:bg-white/[0.03] transition group">
                        <td class="px-8 py-6 font-semibold text-white"><?php echo e($b['title']); ?></td>
                        <td class="px-8 py-6 text-gray-400 font-medium"><?php echo e($b['author']); ?></td>
                        <td class="px-8 py-6 uppercase tracking-wider text-xs text-neonPurple font-bold"><?php echo e($b['category']); ?></td>
                        <td class="px-8 py-6">
                            <?php if($b['copies']>0): ?>
                                <span class="bg-neonGreen/10 text-neonGreen px-3 py-1 rounded-full text-[10px] font-black border border-neonGreen/20 italic"><?php echo e($b['copies']); ?> UNITS</span>
                            <?php else: ?>
                                <span class="text-red-500 opacity-50 px-3 py-1 text-[10px] font-black italic">DEPLETED</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <?php if($b['copies']>0): ?>
                                <a href="borrow_book.php?id=<?php echo e($b['id']); ?>" class="inline-block bg-neonCyan text-black px-5 py-2 rounded-xl font-black text-[10px] hover:scale-110 transition transform active:scale-95 shadow-neon">
                                    BORROW
                                </a>
                            <?php else: ?>
                                <span class="text-gray-600 text-[10px] font-bold uppercase italic">Unavailable</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'partials/footer.php'; ?>