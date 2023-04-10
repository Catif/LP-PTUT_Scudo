<?php

use Faker\Factory;
use api\services\utils\FakerGenerator;

// Faker
$fakerFactory = Factory::create();
$fakerGenerator = new FakerGenerator($fakerFactory);

echo "<br/><br/>================= LOADING DATA GENERATION =================<br/>";
for ($u = 0; $u < 25; $u++) {
  $user = $fakerGenerator->FakeUser();
  for ($ur = 0; $ur < 5; $ur++) {
    $resource = $fakerGenerator->FakeResource($user);
    if (isset($resource)) {
      for ($j = 0; $j < 2; $j++) {
        $fakerGenerator->FakeComment($user, $resource);
      }
    }
  }
  for ($g = 0; $g < 2; $g++) {
    $group = $fakerGenerator->FakeGroup($user);
    for ($gr = 0; $gr < 5; $gr++) {
      $groupResource = $fakerGenerator->FakeGroupResource($user, $group);
      if (isset($groupResource)) {
        for ($z = 0; $z < 2; $z++) {
          $fakerGenerator->FakeComment($user, $groupResource);
        }
      }
    }
  }
  if ($u > 4) {
    $fakerGenerator->FakeFollow($user, $u);
  }
}
echo "<br/><br/>================= DATA GENERATION DONE =================<br/>";
