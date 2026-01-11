<?php
require_once 'config.php';
require_once 'helpers.php';
require_librarian();
$user=$_SESSION['user'];

$stmt=$conn->prepare("SELECT br.*,b.title,b.author,u.username AS member FROM borrowings br JOIN books b ON br.book_id=b.id JOIN users u ON br.member_id=u.id WHERE b.librarian_id=? ORDER BY br.borrow_date DESC");
$stmt->bind_param("i",$user['id']);
$stmt->execute();
$res=$stmt->get_result();
$borrowings=$res->fetch_all(MYSQLI_ASSOC);

include 'partials/header.php';
?>

<div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
    <div class="p-8 border-b border-white/10 bg-white/[0.02] flex justify-between items-center">
        <div>
            <h2 class="font-display text-3xl text-neonOrange tracking-tight">Master Borrowing Log</h2>
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em] mt-1">Librarian Authorization Level</p>
        </div>
        <div class="h-10 w-10 rounded-full bg-neonOrange/20 flex items-center justify-center border border-neonOrange/30">
            <div class="h-2 w-2 rounded-full bg-neonOrange animate-pulse"></div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-black/50 text-[10px] font-bold uppercase text-gray-500 tracking-widest">
                <tr>
                    <th class="px-8 py-5">Book Title</th>
                    <th class="px-8 py-5">Member Name</th>
                    <th class="px-8 py-5">Transaction Date</th>
                    <th class="px-8 py-5 text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                <?php foreach($borrowings as $b): ?>
                    <tr class="hover:bg-white/[0.02] transition group">
                        <td class="px-8 py-6">
                            <div class="font-semibold text-white"><?php echo e($b['title']); ?></div>
                            <div class="text-[10px] text-gray-500 italic"><?php echo e($b['author']); ?></div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-neonCyan font-mono">@<?php echo e($b['member']); ?></span>
                        </td>
                        <td class="px-8 py-6 text-gray-400">
                            <?php echo date('M d, Y', strtotime($b['borrow_date'])); ?>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <?php if($b['status'] === 'borrowed'): ?>
                                <span class="bg-neonOrange/10 text-neonOrange border border-neonOrange/20 px-3 py-1 rounded-lg text-[10px] font-black uppercase italic">Active Borrow</span>
                            <?php else: ?>
                                <span class="bg-neonGreen/10 text-neonGreen border border-neonGreen/20 px-3 py-1 rounded-lg text-[10px] font-black uppercase italic">Returned</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if(empty($borrowings)): ?>
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-gray-600 italic">No borrowing records found in the archive.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'partials/footer.php'; ?>