<div>
  <?php
  echo '<pre>';

  while ($obj = $this->airlistData->fetch_object()) {
    print_r ($obj);
  }

  echo '</pre>';
  ?>
</div>