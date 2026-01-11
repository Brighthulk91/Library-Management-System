<?php
require_once 'config.php';
require_once 'helpers.php';
require_librarian();
$user=$_SESSION['user'];

if(isset($_GET['delete'])){
    $id=intval($_GET['delete']);
    $stmt=$conn->prepare("DELETE FROM books WHERE id=? AND librarian_id=?");
    $stmt->bind_param("ii",$id,$user['id']);
    $stmt->execute();
    redirect('manage_books.php');
}

$stmt=$conn->prepare("SELECT * FROM books WHERE librarian_id=? ORDER BY created_at DESC");
$stmt->bind_param("i",$user['id']);
$stmt->execute();
$res=$stmt->get_result();
$books=$res->fetch_all(MYSQLI_ASSOC);

include 'partials/header.php';
?>
<div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
    <div class="p-8 border-b border-white/10 flex justify-between items-center bg-white/[0.02]">
        <div>
            <h2 class="font-display text-3xl text-neonPurple tracking-tight">Inventory Control</h2>
            <p class="text-xs text-gray-500 uppercase font-bold tracking-widest mt-1">Manage your registered volumes</p>
        </div>
        <a href="add_book.php" class="bg-neonPurple text-black px-6 py-3 rounded-xl font-black text-xs hover:scale-105 transition transform shadow-[0_0_20px_rgba(190,147,253,0.3)]">
            + ADD NEW VOLUME
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-black/50 text-[10px] font-bold uppercase text-gray-500 tracking-[0.2em]">
                <tr>
                    <th class="px-8 py-5">Title</th>
                    <th class="px-8 py-5">Author</th>
                    <th class="px-8 py-5">Category</th>
                    <th class="px-8 py-5">Stock</th>
                    <th class="px-8 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5 text-sm">
                <?php foreach($books as $b): ?>
                    <tr class="hover:bg-white/[0.03] transition">
                        <td class="px-8 py-6 font-semibold text-white"><?php echo e($b['title']); ?></td>
                        <td class="px-8 py-6 text-gray-400"><?php echo e($b['author']); ?></td>
                        <td class="px-8 py-6 text-neonCyan font-bold italic"><?php echo e($b['category']); ?></td>
                        <td class="px-8 py-6 text-white font-mono"><?php echo e($b['copies']); ?></td>
                        <td class="px-8 py-6 text-right space-x-2">
                            <a href="edit_book.php?id=<?php echo e($b['id']); ?>" class="inline-block border border-neonCyan/30 text-neonCyan px-4 py-2 rounded-lg text-xs font-bold hover:bg-neonCyan hover:text-black transition">EDIT</a>
                            <a href="?delete=<?php echo e($b['id']); ?>" class="inline-block border border-neonOrange/30 text-neonOrange px-4 py-2 rounded-lg text-xs font-bold hover:bg-neonOrange hover:text-white transition" onclick="return confirm('Permanent deletion?')">DELETE</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'partials/footer.php'; ?>