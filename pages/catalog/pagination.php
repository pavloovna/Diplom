<nav aria-label="Page navigation example">
    <ul class="pagination">
        <div class="shadow-pagination">
            <li class="page-item-img">
                <a class="page-link" href="?page=1"><img src="../../assets/images/left.png"></a>
            </li>
            <!-- <?php if ($page >= 1) : ?>
            <li class="page-item-img">
                <a class="page-link" href="?page=<?php echo ($page - 1); ?>"><img src="../../assets/images/left.png"></a>
            </li>
            <?php endif; ?> -->

            <li class="page-item">
                <a class="page-link" href="?page=1">●</a>
            </li>

            <li class="page-item">
                <a class="page-link" href="?page=2">●</a>
            </li>

            <li class="page-item">
                <a class="page-link" href="?page=3">●</a>
            </li>

            <!-- <?php if ($page <= $total_pages) : ?>
            <li class="page-item-img">
                <a class="page-link" href="?page=<?php echo ($page + 1); ?>"><img src="../../assets/images/right.png"></a>
            </li>
            <?php endif; ?> -->

            <li class="page-item-img">
                <a class="page-link" href="?page=<?php echo $total_pages ?>"><img src="../../assets/images/right.png"></a>
            </li>
        </div>
    </ul>
</nav>