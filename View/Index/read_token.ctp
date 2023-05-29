<?php if (isset($data)): ?>
  The data is <pre><?= $data ?></pre>
<?php else: ?>
  There was an error reading the token <pre><?= $errors ?></pre>
<?php endif; ?>
