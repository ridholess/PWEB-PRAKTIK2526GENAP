<div
    class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-6 py-4 border-t-2 border-black bg-[#F7EDE8]">

    <!-- Info -->
    <p class="text-sm text-[#7A6E6A] font-medium">
        <?php
        $from = $total_rows === 0 ? 0 : $offset + 1;
        $to = min($offset + $per_page, $total_rows);
        echo "Menampilkan {$from}–{$to} dari {$total_rows} data";
        ?>
    </p>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <div class="flex flex-wrap gap-2">

            <!-- Prev -->
            <?php if ($page > 1): ?>
                <a href="<?= page_url(['page' => $page - 1]) ?>"
                    class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black shadow-[2px_2px_0px_rgba(0,0,0,0.15)] hover:shadow-[2px_2px_0px_#E8715A] transition-all duration-200 no-underline">
                    ‹
                </a>
            <?php else: ?>
                <span
                    class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black opacity-40 cursor-not-allowed">‹</span>
            <?php endif; ?>

            <!-- Page numbers -->
            <?php
            $startP = max(1, $page - 2);
            $endP = min($total_pages, $startP + 4);
            if ($endP - $startP < 4)
                $startP = max(1, $endP - 4);
            for ($p = $startP; $p <= $endP; $p++):
                ?>
                <?php if ($p === $page): ?>
                    <span
                        class="page-btn-active px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold cursor-default">
                        <?= $p ?>
                    </span>
                <?php else: ?>
                    <a href="<?= page_url(['page' => $p]) ?>"
                        class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black shadow-[2px_2px_0px_rgba(0,0,0,0.15)] hover:shadow-[2px_2px_0px_#E8715A] transition-all duration-200 no-underline">
                        <?= $p ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Next -->
            <?php if ($page < $total_pages): ?>
                <a href="<?= page_url(['page' => $page + 1]) ?>"
                    class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black shadow-[2px_2px_0px_rgba(0,0,0,0.15)] hover:shadow-[2px_2px_0px_#E8715A] transition-all duration-200 no-underline">
                    ›
                </a>
            <?php else: ?>
                <span
                    class="px-3.5 py-2 border-2 border-black rounded-md text-sm font-bold bg-white text-black opacity-40 cursor-not-allowed">›</span>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>