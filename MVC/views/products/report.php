<?php require __DIR__ . '/../layout/header.php'; ?>
<h1>Report</h1>
<div class="table-scroll">
<table>
  <thead><tr><th>Category</th><th class="num">Products</th><th class="num">Average price</th><th class="num">Highest price</th></tr></thead>
  <tbody>
  <?php foreach ($summary as $row): ?>
    <tr>
      <td><?= h($row['tenDanhMuc']) ?></td>
      <td class="num"><?= (int)$row['soSanPham'] ?></td>
      <td class="num"><?= (int)$row['soSanPham'] > 0 ? h(formatPrice($row['giaTrungBinh'])) : '-' ?></td>
      <td class="num"><?= (int)$row['soSanPham'] > 0 ? h(formatPrice($row['giaCaoNhat'])) : '-' ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
