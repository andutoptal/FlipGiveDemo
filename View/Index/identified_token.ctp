<?php if (isset($token)): ?>
  The token is <strong><?= $token ?></strong>
<?php else: ?>
  There was an error generating the token <pre><?= $errors ?></pre>
<?php endif; ?>

