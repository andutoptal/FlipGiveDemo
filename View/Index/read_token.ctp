<?php if (isset($payload)): ?>
  The data is <pre><?= $payload ?></pre>
<?php else: ?>
  There was an error reading the token <pre><?= $errors ?></pre>
<?php endif; ?>
