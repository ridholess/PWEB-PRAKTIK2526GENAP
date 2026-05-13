<div class="table-footer">

    <!-- Info Table -->
    <p class="table-info2">
        <?php
        $from = $total_rows === 0 ? 0 : $offset + 1;
        $to = min($offset + $per_page, $total_rows);
        echo "Menampilkan {$from}–{$to} dari {$total_rows} data";
        ?>
    </p>
    <!-- End of Info Table -->

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <div class="pagination-wrap">

            <?php if ($page > 1): ?>
                <a href="<?= page_url(['page' => $page - 1]) ?>" class="page-btn">
                    ‹
                </a>
            <?php else: ?>
                <span class="page-btn page-btn-disabled">‹</span>
            <?php endif; ?>

            <?php
            $startP = max(1, $page - 2);
            $endP = min($total_pages, $startP + 4);
            if ($endP - $startP < 4)
                $startP = max(1, $endP - 4);
            for ($p = $startP; $p <= $endP; $p++):
                ?>
                <?php if ($p === $page): ?>
                    <span class="page-btn page-btn-active">
                        <?= $p ?>
                    </span>
                <?php else: ?>
                    <a href="<?= page_url(['page' => $p]) ?>" class="page-btn">
                        <?= $p ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="<?= page_url(['page' => $page + 1]) ?>" class="page-btn">
                    ›
                </a>
            <?php else: ?>
                <span class="page-btn page-btn-disabled">›</span>
            <?php endif; ?>

        </div>
    <?php endif; ?>
    <!-- End of Pagination -->

</div>